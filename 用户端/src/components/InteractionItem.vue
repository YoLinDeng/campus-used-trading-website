<template>
  <div class="interaction-item-wrapper">
    <img :src="data.userImg"
         alt=""
         class="user-img"
         @click="goToPersonalDetail">
    <div class="info">
      <div class="user-name">{{ data.userName }}
        <span class="time">{{ data.time.split(' ')[0] }}</span>
      </div>
      <div class="message">{{ data.content }}</div>
    </div>
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
  methods: {
    // 跳转到个人信息页面
    goToPersonalDetail () {
      this.$router.push({ path: '/personaldata' })
    }
  }
}
</script>
<style lang="scss" scoped>
.interaction-item-wrapper {
  width: 90%;
  margin: 5% auto;
  border-bottom: 1px solid #eee0e5;
  .user-img {
    width: 10vw;
    height: 10vw;
    display: inline-block;
    border-radius: 50%;
  }
  .info {
    display: inline-block;
    font-size: 0.43rem;
    .time {
      color: #a8a8a8;
      font-size: 0.38rem;
    }
  }
}
</style>
