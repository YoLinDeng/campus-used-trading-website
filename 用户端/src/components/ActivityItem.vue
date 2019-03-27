<template>
  <div class='activity-item-wapper'>
    <img :src="data.img"
         alt=""
         class="activity-img">
    <div class="info">
      <div class="title">{{ data.title }}</div>
      <div class="desc">{{ data.desc }}</div>
      <mt-button size="small"
                 type="danger"
                 v-if="!isSignUp"
                 @click.stop="clickBtn"
                 class="btn">报名</mt-button>
      <mt-button size="small"
                 v-else
                 class="btn"
                 @click.stop="clickBtn">已报名</mt-button>
    </div>
  </div>
</template>

<script>
import { MessageBox } from 'mint-ui'
export default {
  name: 'activity-item',
  props: ['data'],
  data () {
    return {
      isSignUp: false
    }
  },

  components: {
    MessageBox
  },

  computed: {},

  methods: {
    clickBtn () {
      if (this.isSignUp === true) {
        MessageBox.confirm('你确定取消报名吗?').then(action => {
          if (action === 'confirm') {
            this.isSignUp = false
          }
        }).catch(_ => {

        })
      } else {
        this.isSignUp = true
      }
    }
  }
}

</script>
<style lang='scss' scoped>
.activity-item-wapper {
  background: #fff;
  height: 2.5rem;
  position: relative;
  padding-top: 0.5rem;
  border-bottom: 1px solid#d8d8d8;
  .activity-img {
    width: 13vw;
    height: 13vw;
    display: inline-block;
  }
  .info {
    position: absolute;
    left: 20%;
    top: 15%;
    width: 90%;
    .title {
      font-size: 0.4rem;
      font-weight: bold;
    }
    .desc {
      font-size: 0.38rem;
      color: #555;
      width: 90%;
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;
      width: 90%;
    }
  }
}
</style>
