<template>
  <div class="change-name">
    <app-header title="更改信息"
                back
                :right="right"
                @right-click="saveUserName">
    </app-header>
    <div class="user-name">
      <input type="text"
             v-model="userName">
      <div class="desc">好名字可以让人更容易记住你。</div>
    </div>
  </div>
</template>
<script>
import AppHeader from '@/components/AppHeader'
import { MessageBox } from 'mint-ui'
export default {
  name: 'change-name',
  data () {
    return {
      right: '保存',
      userName: ''
    }
  },
  created () {
    const telNum = localStorage.getItem('telNum')
    API.getUserInfo({ telNum }).then(res => {
      this.userName = res.data.userName
    })
  },
  methods: {
    saveUserName () {
      MessageBox.confirm('你确定要保存这个昵称吗?').then(action => {
        if (action === 'confirm') {
          const telNum = localStorage.getItem('telNum')
          const userName = this.userName
          console.log(this.userName)
          API.changeUserInfo({ telNum, userName }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log('用户名没有变化')
          })
          this.$router.go(-1)
        }
      }).catch(_ => { })
    }
  },
  components: {
    AppHeader,
    MessageBox
  }

}
</script>
<style lang="scss" scoped>
.change-name {
  .user-name {
    width: 95%;
    height: 1.2rem;
    margin: 0 auto;
    border-bottom: 1px solid #00cd00;
    input {
      width: 100%;
      height: 100%;
      border: none;
      outline: none;
      background: transparent;
      font-size: 0.5rem;
      text-indent: 0.1rem;
    }
    .desc {
      font-size: 0.35rem;
      color: #768893;
    }
  }
}
</style>
