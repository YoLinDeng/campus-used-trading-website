<template>
  <div class="goods-detail-wrapper">
    <app-header back></app-header>
    <div class="user-detail"
         @click="goToPersonalDetail">
      <img :src="userImg"
           alt=""
           class="photo">
      <div class="user-name">{{userName}}</div>
    </div>
    <div class="price">￥{{price}}
      <span>面交</span>
    </div>
    <!-- 标题 -->
    <div class="title">{{title}}</div>
    <!-- 商品详情 -->
    <div class="goods-detail">
      <div class="text"><span class="icon"></span>
        <p>商品详情</p>
      </div>
      <div class="desc">{{ desc }}</div>
      <div class="goods-img">
        <img v-for="(item1, index) in goodsImgList"
             :key="index"
             :src="item1"
             alt=""
             @click="getImg(goodsImgList, index)">
      </div>
      <div class="count">
        <div class="info">
          <span class="like-num">{{ likeNum }}人想要</span> |
          <span class="look-num">{{ lookNum }}次浏览</span>
        </div>
      </div>
    </div>
    <!-- 留言 -->
    <div class="interaction">
      <div class="text"><span class="icon"></span>
        <p>评论</p>
      </div>
      <div class="addcomment">
        <img :src="activeUserImg"
             alt="">
        <input type="text"
               placeholder="请输入你的评论"
               v-model="commentText">
        <div type="primary"
             @click="addComment"
             class="comment-btn">留言</div>
      </div>
      <interaction-item v-for="(item, index) in interactionList"
                        :key="index"
                        :data="item"></interaction-item>
    </div>
    <!-- 底部操作 -->
    <div class="bottom"
         v-if="isShow">
      <div class="like">
        <img :src="isLike"
             alt=""
             class="star"
             @click="addFavorite">
        想要
      </div>
      <div class="car"
           @click="goToCarPage">
        <img src="@/assets/images/small-car.png"
             alt=""
             class="small-car">
        购物车
      </div>
      <div class="btn">
        <mt-button type="primary"
                   size="small"
                   @click.native="addCar">加入购物车</mt-button>
        <mt-button type="danger"
                   size="small"
                   @click.native="goToBuyPage">马上买</mt-button>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import interactionItem from '@/components/interactionItem'
import { Button, MessageBox } from 'mint-ui'
import { Dialog, Toast, ImagePreview } from 'vant'
export default {
  components: {
    AppHeader,
    interactionItem,
    Button,
    Dialog,
    Toast,
    ImagePreview
  },
  props: {},
  data () {
    return {
      userImg: '',
      activeUserImg: 'http://www.deng.com' + localStorage.getItem('userImg'),
      userName: '',
      price: '',
      title: '',
      desc: '',
      isShow: true,
      likeNum: '',
      lookNum: '',
      sex: '',
      postTime: '',
      commentText: '',
      interactionList: [],
      like: false,
      goodsImgList: []
    }
  },
  computed: {
    isLike () {
      if (!this.like) {
        return require('@/assets/images/star.png')
      } else {
        return require('@/assets/images/click-star.png')
      }
    }
  },
  created () {
    // 商品ID
    const goodsId = this.$route.query.goodsid
    // 发布人ID
    const uid = this.$route.query.uid
    const loginUid = localStorage.getItem('uid')
    if (uid == loginUid) {
      this.isShow = false
    }
    // 获取商品信息
    API.getGoodsDetailInfo({ goodsId, uid }).then(res => {
      this.userImg = 'http://www.deng.com' + res.userData.userImg
      this.userName = res.userData.userName
      this.price = res.goodsData.price
      this.title = res.goodsData.title
      this.desc = res.goodsData.desc
      let goodsImg = res.goodsData.imgUrl
      this.goodsImgList.push(goodsImg)
      this.likeNum = res.goodsData.likeNum
      this.lookNum = res.goodsData.lookNum
      this.sex = res.userData.sex
      this.postTime = res.goodsData.postTime
      // 添加历史查看记录
      let params = {
        uid: localStorage.getItem('uid'),
        pubUid: uid,
        goodsId: goodsId,
        pubUname: res.userData.userName,
        pubUimg: res.userData.userImg,
        goodsImg: res.goodsData.imgUrl,
        title: res.goodsData.title,
        price: res.goodsData.price,
        lookNum: res.goodsData.lookNum
      }
      API.addHistoryLookList(params).then(res => {
        console.log(res)
      }).catch(_ => {
      })
    }).catch(_ => {
      console.log(_)
    })
    // 判断是否已经下单
    API.judgeBuy({ uid: localStorage.getItem('uid'), goodsId }).then(res => {
      this.isShow = false
    }).catch(_ => {
    })
    // 判断是否已经加入购物车
    API.getFavoriteList({
      uid: localStorage.getItem('uid'),
      goodsId
    }).then(res => {
      this.like = true
    }).catch(_ => {
      this.like = false
    })

    // 获取评论列表
    API.getCommentList({ goodsId }).then(res => {
      console.log(res)
      let data = res.data
      this.interactionList = data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    goToCarPage () {
      this.$router.push({ path: '/car' })
    },
    // 添加购物车
    addCar () {
      Dialog.confirm({
        title: '提示',
        message: '确定要加入购物车吗'
      }).then(() => {
        const activeid = localStorage.getItem('uid')
        if (!activeid) {
          MessageBox.alert('登录后才能加入购物车哦~').then(action => {
            this.$router.push({ path: '/login' })
          })
        }
        // 商品ID
        const goodsId = this.$route.query.goodsid
        // 发布人ID
        const uid = this.$route.query.uid
        const loginUid = localStorage.getItem('uid')
        const title = this.title
        const price = this.price
        const sex = this.sex === '男' ? 1 : 2
        const postTime = this.postTime.split(' ')[0]
        const goodsImg = this.goodsImgList[0]
        const pubUimg = this.userImg
        const pubUname = this.userName
        let params = {
          goodsId,
          pubUid: uid,
          uid: loginUid,
          title,
          price,
          sex,
          postTime,
          goodsImg,
          pubUimg,
          pubUname
        }
        API.addCar(params).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
        Toast('添加成功')
      }).catch(() => {
        console.log('')
      })
    },
    // 跳转到确认订单页面
    goToBuyPage () {
      const goodsId = this.$route.query.goodsid
      this.$router.push({
        path: '/confirmorder',
        query: {
          goodsId
        }
      })
    },
    // 查看图片
    getImg (images, index) {
      ImagePreview({
        images: images,
        showIndex: true,
        loop: false,
        startPosition: index
      })
    },
    // 跳转到个人信息页面
    goToPersonalDetail () {
      let uid = this.$route.query.uid
      this.$router.push({
        path: '/personaldata',
        query: {
          uid
        }
      })
    },
    // 添加收藏夹
    addFavorite () {
      const uid = localStorage.getItem('uid')
      if (!uid) {
        MessageBox.alert('登录后才能收藏哦~').then(action => {
          this.$router.push({ path: '/login' })
        })
      }
      // 商品ID
      const goodsId = this.$route.query.goodsid
      // 发布人ID
      const pubUid = this.$route.query.uid
      const pubUname = this.userName
      const pubUimg = this.userImg
      const goodsImg = this.goodsImgList[0]
      const goodsTitle = this.title
      const price = this.price
      const postTime = this.postTime
      const sex = this.sex === '男' ? 1 : 2
      const params = {
        uid,
        pubUid,
        goodsId,
        pubUname,
        pubUimg,
        goodsImg,
        goodsTitle,
        price,
        postTime,
        sex
      }
      if (this.like) {
        // 删除收藏夹
        API.deleteFavorite({ uid, goodsId }).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
        this.like = false
      } else {
        // 添加收藏夹
        API.addFavorite(params).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
        this.like = true
      }
    },
    // 添加评论
    addComment () {
      let uid = localStorage.getItem('uid')
      if (!uid) {
        MessageBox.alert('登录后才能评论哦~').then(action => {
          this.$router.push({ path: '/login' })
        })
      }
      if (this.commentText) {
        let content = this.commentText
        let userName = localStorage.getItem('username')
        let uid = localStorage.getItem('uid')
        let userImg = 'http://www.deng.com' + localStorage.getItem('userImg')
        let goodsId = this.$route.query.goodsid
        let goodsImg = this.goodsImgList[0]
        let params = {
          content,
          userName,
          uid,
          userImg,
          goodsId,
          goodsImg
        }
        API.addComment(params).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
        this.interactionList.unshift({
          userImg,
          userName,
          content,
          time: '刚刚'
        })
        this.commentText = ''
      }
      console.log(this.interactionList)
    }

  }
}
</script>
<style lang="scss" scoped>
.goods-detail-wrapper {
  background: #fff;
  overflow-x: hidden;
  padding-bottom: 1.5rem;
  .user-detail {
    position: relative;
    left: 5%;
    padding-top: 0.1rem;
    .photo {
      width: 8vw;
      height: 8vw;
      display: inline-block;
      border-radius: 50%;
    }
    .user-name {
      display: inline-block;
      position: absolute;
      left: 10%;
      top: 30%;
      font-size: 0.4rem;
    }
  }
  .price {
    font-size: 0.5rem;
    font-weight: bold;
    margin-left: 5%;
    margin-top: 0.1rem;
    color: #ff0000;
    span {
      font-size: 0.35rem;
      color: #999;
    }
  }
  .title {
    font-size: 0.56rem;
    font-weight: bold;
    margin-left: 5%;
  }
  .goods-detail {
    .text {
      position: relative;
      .icon {
        display: inline-block;
        width: 0.18rem;
        height: 3.5vh;
        background: #ff3030;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
        margin-left: 5%;
      }
      p {
        font-size: 0.45rem;
        font-weight: bold;
        position: absolute;
        left: 8%;
        top: 0;
      }
    }
    .desc {
      font-size: 0.4rem;
      width: 90%;
      margin: 0 auto;
    }
    .goods-img {
      width: 90%;
      margin: 3% auto;
      img {
        width: 100%;
      }
    }
    .count {
      width: 90%;
      margin: 5% auto;
      border-top: 1px solid #eee0e5;
      font-size: 0.38rem;
      color: #a8a8a8;
      padding-top: 0.2rem;
      position: relative;
      height: 0.6rem;
      .info {
        position: absolute;
        right: 0;
      }
    }
  }
  .interaction {
    .text {
      position: relative;
      .icon {
        display: inline-block;
        width: 0.18rem;
        height: 3.5vh;
        background: #ff3030;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
        margin-left: 5%;
      }
      p {
        font-size: 0.45rem;
        font-weight: bold;
        position: absolute;
        left: 8%;
        top: 0;
      }
    }
    .addcomment {
      width: 90%;
      height: 1.5rem;
      margin: 5% auto;
      img {
        width: 10vw;
        height: 10vw;
        border-radius: 50%;
        float: left;
      }
      input {
        width: 60%;
        height: 1rem;
        border: none;
        background: #f5f5f5;
        float: left;
        font-size: 0.4rem;
        margin-left: 0.3rem;
      }
      .comment-btn {
        float: left;
        width: 15%;
        height: 1rem;
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
        background: #26a2ff;
        color: #fff;
        text-align: center;
        font-size: 0.4rem;
        line-height: 1rem;
      }
    }
  }
  .bottom {
    width: 100%;
    height: 1.5rem;
    position: fixed;
    bottom: 0;
    background: #fff;
    border-top: #eee0e5;
    box-shadow: 0 0 2px #ccc;
    .like {
      position: absolute;
      left: 5%;
      top: 20%;
      font-size: 0.38rem;
      .star {
        width: 5vw;
        height: 5vw;
        display: block;
        margin-left: 15%;
      }
    }
    .car {
      position: absolute;
      left: 20%;
      top: 10%;
      font-size: 0.38rem;
      .small-car {
        width: 6.5vw;
        height: 6.5vw;
        display: block;
        margin-left: 15%;
      }
    }
    .btn {
      position: absolute;
      right: 5%;
      top: -8%;
    }
  }
}
</style>
