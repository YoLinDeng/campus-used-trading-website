<template>
  <div class="item-wrapper"
       @click="selectEdit">
    <div class="item-img">
      <img :src="data.imgUrl"
           alt="">
    </div>
    <div class="desc">
      <div class="title">
        <span class="icon"
              v-if="data.newLevel === 0">全新</span>
        <span class="title-name">{{data.title}}</span>
      </div>
      <div class="price">￥{{data.price}}</div>
    </div>
    <div class="public-time">
      {{data.postTime}}
    </div>
    <div class="delete"
         @click.stop="selectDelete">删除</div>
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
  methods: {
    selectDelete () {
      this.$emit('event-click-delete')
    },
    selectEdit () {
      this.$emit('event-click-edit')
    }
  }
}
</script>
<style lang="scss" scoped>
.item-wrapper {
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
    .price {
      font-size: 0.4rem;
      font-weight: bold;
      margin-top: 0.5rem;
      color: #ff0000;
    }
  }
  .public-time {
    font-size: 0.4rem;
    margin-left: 0.5rem;
    margin-top: 0.05rem;
  }
  .delete {
    font-size: 0.4rem;
    border: 1px solid #0d0d0d;
    width: 1.2rem;
    height: 0.6rem;
    text-align: center;
    line-height: 0.6rem;
    border-radius: 0.2rem;
    position: absolute;
    bottom: 0.2rem;
    right: 0.2rem;
  }
}
</style>
