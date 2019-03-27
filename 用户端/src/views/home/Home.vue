<template>
  <div class="home">
    <div class="home-header"
         @click="goToPersonalInfo"
         v-if="hasLogin">
      <div class="user-img">
        <img :src="userImg"
             alt="">
      </div>
      <div class="user-name">{{this.username}}</div>
      <div class="user-id">用户手机号：{{this.telNum}}</div>
      <div class="jiantou">
        <img src="@/assets/images/right-jt.png"
             alt="">
      </div>
    </div>
    <div class="home-header"
         v-else>
      <img src="@/assets/images/user-photo.png"
           alt=""
           class="photo">
      <mt-button type="primary"
                 class="login-btn"
                 size="small"
                 @click.native="goToLogin">立即登录</mt-button>
    </div>
    <div class="title">
      <span>订单管理</span>
    </div>
    <div class="operation">
      <operation-item v-for="(item,index) in operationList"
                      :key="index"
                      :data="item"></operation-item>
    </div>
    <div class="content">
      <div class="item"
           v-for="(item,index) in contentList"
           :key="index"
           @click="goToContentPage(item.type)">
        <img :src="item.imgSrc"
             alt=""
             class="content-icon">
        <div class="item-name">{{item.itemName}}</div>
      </div>
    </div>
    <mt-cell title="客服电话"
             is-link
             to="/servicecenter">
      <img slot="icon"
           src="@/assets/images/server.png"
           width="24"
           height="24">
    </mt-cell>
    <mt-cell title="意见反馈"
             is-link
             to="/feedback">
      <img slot="icon"
           src="@/assets/images/feedback.png"
           width="24"
           height="24">
    </mt-cell>
    <mt-cell title="平台规则"
             is-link
             to="/rule">
      <img slot="icon"
           src="@/assets/images/rule.png"
           width="24"
           height="24">
    </mt-cell>
    <app-footer></app-footer>
  </div>
</template>
<script>
import Vue from 'vue'
import { Cell, Button } from 'mint-ui'
import AppFooter from '@/components/AppFooter'
import OperationItem from '@/components/OperationItem'
Vue.component(Cell.name, Cell)
Vue.component(Button.name, Button)
export default {
  name: 'home',
  data () {
    return {
      operationList: [
        {
          num: '-',
          itemName: '我的发布',
          type: 1
        },
        {
          num: '-',
          itemName: '卖出管理',
          type: 2
        },
        {
          num: '-',
          itemName: '买到管理',
          type: 3
        },
        {
          num: '-',
          itemName: '收藏夹',
          type: 4
        }
      ],
      contentList: [
        {
          type: 1,
          itemName: '我的评论',
          imgSrc: require('@/assets/images/comment.png')
        },
        {
          type: 2,
          itemName: '商品关注',
          imgSrc: require('@/assets/images/follow-shop.png')

        },
        {
          type: 3,
          itemName: '关注卖家',
          imgSrc: require('@/assets/images/concerned-sellers.png')

        },
        {
          type: 4,
          itemName: '浏览记录',
          imgSrc: require('@/assets/images/history.png')

        },
        {
          type: 5,
          itemName: '活动',
          imgSrc: require('@/assets/images/activity.png')
        }
      ],
      username: '',
      telNum: '',
      userImg: ''
    }
  },
  computed: {
    hasLogin () {
      const telNum = localStorage.getItem('telNum')
      if (telNum) {
        return true
      } else {
        return false
      }
    }
  },
  created () {
    const telNum = localStorage.getItem('telNum')
    const uid = localStorage.getItem('uid')
    API.getUserInfo({ telNum }).then(res => {
      this.username = res.data.userName
      this.telNum = res.data.telNum
      this.userImg = 'http://www.deng.com' + res.data.userImg
    })
    API.getManageNum({ uid }).then(res => {
      this.operationList[0].num = res.publicNum
      this.operationList[1].num = res.sellNum
      this.operationList[2].num = res.buyNum
      this.operationList[3].num = res.favoriteNum
    }).catch(_ => { })
  },
  methods: {
    goToPersonalInfo () {
      this.$router.push({ path: '/personal' })
    },
    goToContentPage (type) {
      if (type === 1) {
        this.$router.push({ path: '/mycomment' })
      } else if (type === 2) {
        this.$router.push({ path: '/goodsfollow' })
      } else if (type === 3) {
        this.$router.push({ path: '/sellerfollow' })
      } else if (type === 4) {
        this.$router.push({ path: '/seehistory' })
      } else {
        this.$router.push({ path: '/activity' })
      }
    },
    goToLogin () {
      this.$router.push({ path: '/login' })
    }
  },
  components: {
    AppFooter,
    OperationItem
  }
}
</script>
<style lang="scss" scoped>
.home {
  .home-header {
    width: 100%;
    height: 3rem;
    margin-bottom: 0.1rem;
    position: relative;
    background: #fff;
    padding-top: 0.2rem;
    .user-img {
      width: 15vw;
      height: 15vw;
      // background: #ccc;
      border-radius: 50%;
      position: absolute;
      top: 30%;
      left: 10%;
      overflow: hidden;
      img {
        width: 100%;
        height: 100%;
      }
    }
    .user-name {
      position: absolute;
      top: 30%;
      left: 28%;
      font-size: 0.5rem;
      font-weight: bold;
    }
    .user-id {
      font-size: 0.35rem;
      position: absolute;
      top: 60%;
      left: 28%;
    }
    .jiantou {
      position: absolute;
      right: 10%;
      top: 25%;
      img {
        width: 5vw;
        height: 5vw;
      }
    }
    .photo {
      width: 15vw;
      height: 15vw;
      border-radius: 50%;
      background: #ccc;
      display: block;
      margin: 0 auto;
    }
    .login-btn {
      display: block;
      margin: 2% auto;
    }
  }
  .title {
    background: #fff;
    font-size: 0.43rem;
    font-weight: 500;
    color: #030303;
    padding-top: 0.2rem;
    padding-left: 0.3rem;
  }
  .operation {
    display: flex;
    font-size: 0.38rem;
    background: #fff;
    margin-bottom: 0.2rem;
  }
  .content {
    display: flex;
    font-size: 0.35rem;
    background: #fff;
    margin-bottom: 0.1rem;
    .item {
      flex: 1;
      text-align: center;
      padding-top: 0.3rem;
      padding-bottom: 0.3rem;
      .content-icon {
        width: 7vw;
        height: 7vw;
      }
    }
  }
}
</style>
