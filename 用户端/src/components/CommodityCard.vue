<template>
  <div class="commodity-wrapper">
    <div class="commodity-img">
      <img :src="data.imgUrl"
           alt="">
    </div>
    <div class="title">
      {{data.title}}
    </div>
    <div class="price">￥{{data.price}}</div>
    <div class="icon"
         v-if="data.newLevel === 0">全新</div>
  </div>
</template>

<script>
export default {
  components: {},
  props: ['data'],
  data () {
    return {
    }
  },
  computed: {},
  methods: {}
}
</script>
<style lang="scss" scoped>
.commodity-wrapper {
  width: 45%;
  height: 7rem;
  margin-left: 3.5%;
  box-shadow: 0 1px 3px #ccc;
  border-radius: 3px;
  margin-top: 3%;
  font-size: 0.39rem;
  position: relative;
  background: #fff;
  display: inline-block;
  .commodity-img {
    width: 45vw;
    height: 45vw;
    border-radius: 3px;
    background: pink;
    img {
      width: 100%;
      height: 100%;
    }
  }
  .title {
    width: 95%;
    margin: 8% auto;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
  .price {
    font-size: 0.43rem;
    color: #ff0000;
    margin-left: 2%;
  }
  .icon {
    position: absolute;
    right: 5%;
    bottom: 4%;
    border: 1px solid #eee0e5;
    color: #ff0000;
    padding: 1%;
    border-radius: 3px;
    font-size: 0.38rem;
    font-weight: bolder;
  }
}
</style>
