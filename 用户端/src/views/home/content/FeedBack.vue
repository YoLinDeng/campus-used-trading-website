<template>
  <div class='feedback-wapper'>
    <app-header title="意见反馈" back></app-header>
    <div class="text-title">您的意见或建议是平台进步的源泉</div>
    <div class="content">
         <textarea class="text-desc"
                  cols="30"
                  rows="10"
                  placeholder="在这里输入你宝贵的意见吧~"
                  v-model="textValue">
        </textarea>
        <mt-button size="small" type="primary"  class="btn" @click.stop="clickBtn">提交</mt-button>
    </div>
  </div>
</template>

<script>
import { MessageBox, Toast } from 'mint-ui'
import AppHeader from '@/components/AppHeader'
export default {
  name: 'feed-back',
  props: [''],
  data () {
    return {
      textValue: ''
    }
  },

  components: {
    AppHeader
  },

  computed: {},

  methods: {
    clickBtn () {
      MessageBox.confirm('确定提交意见吗?').then(action => {
        if (action === 'confirm') {
          Toast('提交成功')
          this.textValue = ''
        }
      }).catch(_ => {
        console.log('error')
      })
    }
  }

}

</script>
<style lang='scss' scoped>
.feedback-wapper {
  background: #fff;
  .text-title {
    font-size: 0.4rem;
    margin-top: 5%;
    margin-left: 5%;
  }
  .content {
    position: relative;
    height: 5rem;
    .text-desc {
      border: 1px solid #ccc;
      outline: none;
      width: 90%;
      height: 4rem;
      display: block;
      margin: 0 auto;
      font-size: 0.4rem;
      margin-top: 0.2rem;
    }
    .btn {
      position: absolute;
      right: 5%;
      bottom: 18%;
    }
  }
}
</style>
