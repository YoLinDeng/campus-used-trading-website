<template>
  <div class="search-item-wrapper"
       @click="goToGoodsDetail">
    <div class="item-img">
      <img :src="data.imgUrl"
           alt="">
    </div>
    <div class="desc">
      <div class="title">
        <span class="title-name">{{ data.title }}</span>
      </div>
      <div class="content">{{ data.desc }}</div>
      <div class="price">￥{{ data.price }}</div>
    </div>
    <div class="public-time">
      {{ data.postTime.split(' ')[0] }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'search-item',
  components: {},
  props: ['data'],
  data () {
    return {
    }
  },
  computed: {},
  methods: {
    goToGoodsDetail () {
      let uid = this.data.uid
      let goodsid = this.data.goodsId
      this.$router.push({
        path: '/goodsdetail',
        query: {
          uid,
          goodsid
        }
      })
    }
  },
}
</script>
<style lang="scss" scoped>
.search-item-wrapper {
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
      height: 100%;
    }
  }
  .desc {
    width: 100%;
    position: absolute;
    left: 2.8rem;
    top: 0.5rem;
    .title {
      font-size: 0.4rem;
      .icon {
        display: inline-block;
        font-size: 0.35rem;
        width: 1rem;
        height: 0.5rem;
        background: red;
        color: #fff;
        border-radius: 0.2rem;
        text-align: center;
      }
      .title-name {
        font-size: 0.4rem;
        font-weight: bold;
        margin-left: 0.1rem;
      }
    }
    .content {
      width: 70%;
      margin-top: 0.1rem;
      font-size: 0.4rem;
      margin-left: 0.1rem;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
    }
    .price {
      font-size: 0.4rem;
      font-weight: bold;
      margin-top: 0.3rem;
      color: #ff0000;
    }
  }
  .public-time {
    font-size: 0.38rem;
    position: absolute;
    right: 0.2rem;
    bottom: 0.2rem;
    color: #c1c1c1;
  }
}
</style>