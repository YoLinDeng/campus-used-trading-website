<template>
  <div class="sell-item-wrapper">
    <div class="sell-img">
      <img :src="data.goodsImg"
           alt="">
    </div>
    <div class="desc">
      <div class="title">{{data.title}}</div>
    </div>
    <div class="price">￥{{data.price}}</div>
    <div class="total">共一件商品 合计：￥{{data.price}}</div>
  </div>
</template>

<script>
export default {
  components: {},
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
  methods: {}
}
</script>
<style lang="scss" scoped>
.sell-item-wrapper {
  height: 3rem;
  background: #fff;
  border-bottom: 1px solid#d8d8d8;
  padding-top: 0.5rem;
  box-sizing: border-box;
  position: relative;
  .sell-img {
    img {
      display: inline-block;
      width: 18vw;
      height: 18vw;
      border-radius: 5px;
      margin-left: 0.5rem;
    }
  }
  .desc {
    position: absolute;
    left: 2.5rem;
    top: 0.5rem;
    .title {
      width: 6rem;
      font-size: 0.43rem;
      font-weight: bold;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }
  .price {
    position: absolute;
    top: 0.5rem;
    right: 0.2rem;
    font-size: 0.4rem;
    color: #ff0000;
  }
  .total {
    position: absolute;
    bottom: 0.1rem;
    right: 0.2rem;
    font-size: 0.4rem;
  }
}
</style>
