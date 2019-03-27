<template>
  <div class="favorite-item-wrapper">
    <div class="top"
         @click="goToPersonalData">
      <img :src="data.pubUimg"
           alt=""
           class="user-img">
      <div class="user-name">{{data.pubUname}}</div>
      <img src="@/assets/images/man.png"
           alt=""
           class="sex"
           v-if="data.sex===1">
      <img src="@/assets/images/woman.png"
           alt=""
           class="sex"
           v-if="data.sex===2">
      <div class="publish-time">{{ data.postTime.split(' ')[0] }}</div>
    </div>
    <div class="content"
         @click="goToGoodsDetail(data.pubUid,data.goodsId)">
      <img :src="data.goodsImg"
           alt=""
           class="content-img">
      <div class="desc">
        <div class="title">{{ data.goodsTitle }}</div>
        <div class="price">￥{{ data.price }}</div>
      </div>
      <mt-button type="default"
                 class="delete"
                 @click.native.stop="deleteItem">删除</mt-button>
    </div>
  </div>
</template>

<script>
import { Button } from 'mint-ui'
export default {
  components: {
    Button
  },
  props: {
    data: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
    }
  },
  computed: {},
  methods: {
    goToPersonalData () {
      let uid = this.data.pubUid
      this.$router.push({
        path: '/personaldata',
        query: {
          uid
        }
      })
    },
    goToOrder () {
      this.$router.push({ path: '/confirmorder' })
    },
    // 删除
    deleteItem () {
      this.$emit('event-delete')
    },
    goToGoodsDetail (uid, goodsid) {
      this.$router.push({ path: '/goodsdetail', query: { uid, goodsid } },
      )
    }
  }
}
</script>
<style lang="scss" scoped>
.favorite-item-wrapper {
  height: 4rem;
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
    .publish-time {
      position: absolute;
      right: 0.1rem;
      top: 0.3rem;
      font-size: 0.4rem;
    }
  }
  .content {
    height: 3rem;
    .content-img {
      display: inline-block;
      width: 18vw;
      height: 18vw;
      border-radius: 5px;
      margin-top: 0.5rem;
      margin-left: 0.5rem;
    }
    .desc {
      position: absolute;
      left: 3rem;
      top: 1.5rem;
      .title {
        font-size: 0.43rem;
        font-weight: bold;
      }
      .price {
        font-size: 0.4rem;
        margin-top: 0.3rem;
        color: #ff0000;
      }
    }
    .delete {
      width: 15vw;
      height: 4vh;
      font-size: 0.38rem;
      position: absolute;
      right: 0.5rem;
      bottom: 0.2rem;
    }
  }
}
</style>
