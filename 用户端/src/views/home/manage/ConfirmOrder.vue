<template>
  <div class="order-wapper">
    <app-header title="确认订单"
                back></app-header>
    <div class="address-item"
         @click="goToChangeAddress">
      <div class="item-title">
        {{ nameAndPhone }}
      </div>
      <div class="item-detail">
        {{ detailInfo }}
      </div>
    </div>
    <div class="order-content">
      <div class="seller-info">
        <img :src="pubUimg"
             alt=""
             class="photo">
        <span class="seller-name">{{ sellerName }}</span>
      </div>
      <div class="desc">
        <img :src="goodsImg"
             alt=""
             class="photo">
        <div class="title">{{ title }}</div>
        <div class="price">￥{{ price }}</div>
      </div>
    </div>
    <div class="pay-type">
      <span class="title">支付方式</span>
      <span class="type">线下支付</span>
    </div>
    <div class="footer">
      <div class="price-text">合计：￥{{ price }}</div>
      <div class="confirm-btn"
           @click="confirmOrder">确认下单</div>
    </div>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import { MessageBox } from 'mint-ui'
export default {
  name: 'confirm-order',
  props: [''],
  data () {
    return {
      nameAndPhone: '',
      detailInfo: '',
      pubUimg: '',
      goodsImg: '',
      sellerName: '',
      title: '',
      price: '',
      pubUid: ''
    }
  },

  components: {
    AppHeader,
    MessageBox
  },

  computed: {},
  created () {
    const uid = localStorage.getItem('uid')
    const goodsId = this.$route.query.goodsId
    API.getConfirmOrderInfo({ uid, goodsId }).then(res => {
      let userData = res.userData[0]
      let carData = res.carData[0]
      this.nameAndPhone = userData.userName + ', ' + userData.telNum
      this.detailInfo = userData.address
      this.goodsImg = carData.imgUrl
      this.title = carData.title
      this.price = carData.price
      this.pubUid = carData.uid
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    confirmOrder () {
      const uid = localStorage.getItem('uid')
      const pubUid = this.pubUid
      const price = this.price
      const address = this.detailInfo
      const title = this.title
      const goodsImg = this.goodsImg
      const goodsId = this.$route.query.goodsId
      MessageBox.confirm('确定要下单吗?').then(action => {
        if (action === 'confirm') {
          let uParams = {
            uid: uid,
            price,
            address,
            title,
            goodsImg,
            goodsId,
            status: 0
          }
          let pubParams = {
            uid: pubUid,
            price,
            address,
            title,
            goodsImg,
            goodsId,
            status: 1
          }
          // 添加买家信息
          API.addOrderInfo(uParams).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log(_)
          })
          // 添加卖家信息
          API.addOrderInfo(pubParams).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log(_)
          })
          // 删除购物车信息
          API.deleteCarItem({ uid, goodsId }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log(_)
          })
          // 删除发布信息
          API.deletePublishInfo({ pubUid, goodsId }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log(_)
          })

          this.$router.push({ path: '/home' })
        }
      })
    },
    goToChangeAddress () {
      this.$router.push({ path: '/myaddress' })
    }
  }

}

</script>
<style lang='scss' scoped>
.order-wapper {
  background: #fff;
  border: 1px solid transparent;
  .address-item {
    width: 98%;
    height: 2rem;
    margin: 0 auto;
    border-radius: 3px;
    box-shadow: 0px 0px 10px #ddd;
    background: #fff;
    padding-left: 0.3rem;
    padding-top: 0.3rem;
    box-sizing: border-box;
    margin-top: 0.2rem;
    &:active {
      background: #d8d8d8;
    }
    &:focus {
      background: #d8d8d8;
    }
    .item-title {
      font-size: 0.45rem;
    }
    .item-detail {
      font-size: 0.38rem;
      color: #888;
      margin-top: 0.1rem;
    }
  }
  .order-content {
    width: 98%;
    height: 4rem;
    box-shadow: 0px 0px 10px #ddd;
    background: #fff;
    margin: 0 auto;
    margin-top: 0.2rem;
    .seller-info {
      position: relative;
      .photo {
        display: inline-block;
        width: 8vw;
        height: 8vw;
        border-radius: 50%;
        margin-left: 0.35rem;
      }
      .seller-name {
        font-size: 0.45rem;
        position: absolute;
        left: 15%;
        top: 20%;
        font-weight: bold;
      }
    }
    .desc {
      position: relative;
      .photo {
        width: 20vw;
        height: 20vw;
        border-radius: 3px;
        display: inline-block;
        margin-left: 0.35rem;
      }
      .title {
        font-size: 0.45rem;
        font-weight: bold;
        position: absolute;
        left: 30%;
        top: 0;
      }
      .price {
        font-size: 0.38rem;
        color: orangered;
        font-weight: bold;
        position: absolute;
        left: 30%;
        bottom: 15%;
      }
    }
  }
  .pay-type {
    width: 98%;
    height: 1.5rem;
    line-height: 1.5rem;
    margin: 0.2rem auto;
    font-size: 0.4rem;
    box-shadow: 0px 0px 10px #ddd;
    .title {
      margin-left: 0.2rem;
    }
    .type {
      position: absolute;
      right: 0.5rem;
      color: lightskyblue;
    }
  }
  .footer {
    font-size: 0.45rem;
    font-weight: bold;
    width: 100%;
    height: 1.5rem;
    line-height: 1.5rem;
    background: #fff;
    position: fixed;
    bottom: 0;
    .price-text {
      margin-left: 0.3rem;
    }
    .confirm-btn {
      width: 25vw;
      height: 5vh;
      text-align: center;
      line-height: 5vh;
      color: #fff;
      border-radius: 4px;
      background: orangered;
      position: absolute;
      right: 2%;
      top: 20%;
    }
  }
}
</style>
