<template>
  <div class='goods-item-wapper'>
    <div class="item-img">
      <img :src="data.goodsImg"
           alt="">
    </div>
    <div class="desc">
      <div class="title">
        <span class="title-name">{{data.goodsTitle}}</span>
      </div>
      <div class="price">￥{{data.price}}</div>
    </div>
    <mt-button size="small"
               type="danger"
               v-if="isFollow"
               @click.stop="clickBtn"
               class="btn">取消关注</mt-button>
    <mt-button size="small"
               type="primary"
               v-else
               class="btn"
               @click.stop="clickBtn">关注</mt-button>
  </div>
</template>
<script>
import { Button } from 'mint-ui'
export default {
  name: 'goods-item',
  props: ['data'],
  data () {
    return {
      isFollow: true
    }
  },

  components: {
    Button
  },

  computed: {},

  methods: {
    clickBtn () {
      let uid = localStorage.getItem('uid')
      let goodsId = this.data.goodsId
      if (this.isFollow === true) {
        API.deleteFavorite({ uid, goodsId }).then(res => {
          console.log(res)
        }).catch(_ => { })
        this.isFollow = false
      } else {
        let goodsImg = this.data.goodsImg.slice(19)
        let pubUimg = this.data.pubUimg.slice(19)
        let params = {
          pubUid: this.data.pubUid,
          pubUname: this.data.pubUname,
          pubUimg,
          goodsImg,
          goodsTitle: this.data.goodsTitle,
          price: this.data.price,
          postTime: this.data.postTime,
          uid: this.data.uid,
          sex: this.data.sex,
          goodsId: this.data.goodsId
        }
        API.addFavorite(params).then(res => {
          console.log(res)
        }).catch(_ => {
        })
        this.isFollow = true
      }
    }
  }

}

</script>
<style lang='scss' scoped>
.goods-item-wapper {
  border-bottom: 1px solid#d8d8d8;
  height: 3rem;
  background: #fff;
  padding-top: 0.5rem;
  box-sizing: border-box;
  position: relative;
  .item-img {
    width: 18vw;
    height: 18vw;
    border-radius: 5px;
    margin-left: 0.5rem;
    img {
      width: 100%;
    }
  }
  .desc {
    position: absolute;
    left: 2.8rem;
    top: 0.5rem;
    .title {
      font-size: 0.4rem;
      .title-name {
        font-size: 0.4rem;
        font-weight: bold;
        margin-left: 0.1rem;
      }
    }
    .price {
      font-size: 0.4rem;
      font-weight: bold;
      margin-top: 0.5rem;
    }
  }
  .btn {
    width: 23vw;
    height: 5vh;
    position: absolute;
    right: 0.5rem;
    top: 35%;
  }
}
</style>
