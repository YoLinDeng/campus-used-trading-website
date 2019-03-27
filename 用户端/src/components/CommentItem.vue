<template>
  <div class='comment-item-wapper'>
    <img :src="data.userImg"
         alt=""
         class="user-photo">
    <div class="desc">
      <div class="user-name">{{data.userName}}</div>
      <div class="message">{{data.content}}</div>
    </div>
    <img :src="data.goodsImg"
         alt=""
         class="goods-img">
  </div>
</template>

<script>

export default {
  name: 'comment-item',
  props: ['data'],
  data () {
    return {

    }
  },

  components: {},

  computed: {},

  methods: {}

}

</script>
<style lang='scss' scoped>
.comment-item-wapper {
  position: relative;
  border-bottom: 1px solid #ddd;
  height: 2.5rem;
  background: #fff;
  .user-photo {
    display: inline-block;
    width: 13vw;
    height: 13vw;
    margin-top: 0.5rem;
    margin-left: 0.2rem;
    border-radius: 4px;
  }
  .desc {
    position: absolute;
    left: 21%;
    top: 20%;
    .user-name {
      font-size: 0.43rem;
      font-weight: bold;
    }
    .message {
      font-size: 0.35rem;
      color: #666;
      margin-top: 0.1rem;
    }
  }
  .goods-img {
    width: 18vw;
    height: 18vw;
    border-radius: 4px;
    display: inline-block;
    position: absolute;
    right: 0.3rem;
    top: 0.3rem;
  }
}
</style>
