  <template>
  <div class='history-item-wapper'>
    <div class="top"
         @click="goToPersonalData(data.pubUid)">
      <img :src="data.pubUimg"
           alt=""
           class="user-img">
      <div class="user-name">{{data.pubUname}}</div>
    </div>
    <div class="content"
         @click="goToGoodsDetail(data.pubUid,data.goodsId)">
      <img :src="data.goodsImg"
           alt=""
           class="content-img">
      <div class="desc">
        <div class="title">{{ data.title }}</div>
        <div class="price">￥{{ data.price }}</div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: 'history-item',
  props: ['data'],
  data () {
    return {

    }
  },

  components: {},

  computed: {},

  methods: {
    // 个人信息跳转
    goToPersonalData (uid) {
      this.$router.push({
        path: '/personaldata',
        query: {
          uid
        }
      })
    },
    // 商品详情跳转
    goToGoodsDetail (uid, goodsid) {
      this.$router.push({
        path: '/goodsdetail',
        query: {
          uid,
          goodsid
        }
      })
    }
  }

}

</script>
  <style lang='scss' scoped>
.history-item-wapper {
  height: 3rem;
  background: #fff;
  border-bottom: 1px solid#d8d8d8;
  position: relative;
  .top {
    height: 1rem;
    position: relative;
    .user-img {
      display: inline-block;
      width: 8vw;
      height: 8vw;
      border-radius: 50%;
      margin-left: 0.3rem;
    }
    .user-name {
      display: inline-block;
      font-size: 0.43rem;
      font-weight: bold;
      position: relative;
      left: 0;
      top: -0.2rem;
    }
    .sex {
      width: 6vw;
      height: 6vw;
    }
  }
  .content {
    height: 3rem;
    .content-img {
      display: inline-block;
      width: 13vw;
      height: 13vw;
      border-radius: 5px;
      margin-top: 0.35rem;
      margin-left: 0.5rem;
    }
    .desc {
      position: absolute;
      left: 3rem;
      top: 1.35rem;
      .title {
        font-size: 0.41rem;
        font-weight: bold;
      }
      .price {
        font-size: 0.4rem;
        margin-top: 0.3rem;
        color: #ff0000;
      }
    }
  }
}
</style>
