<template>
  <div class="change-name">
    <app-header title="更改年龄"
                back
                :right="right"
                @right-click="saveAge">
    </app-header>
    <div class="user-name">
      <input type="text"
             v-model="age">
      <div class="desc">填写年龄让身份更清晰。</div>
    </div>
  </div>
</template>
<script>
import AppHeader from '@/components/AppHeader'
import { MessageBox } from 'mint-ui'
export default {
  name: 'change-age',
  data () {
    return {
      right: '保存',
      age: ''
    }
  },
  created () {
    const telNum = localStorage.getItem('telNum')
    API.getUserInfo({ telNum }).then(res => {
      this.age = res.data.age
    })
  },
  methods: {
    saveAge () {
      MessageBox.confirm('你确定要修改年龄吗?').then(action => {
        if (action === 'confirm') {
          const telNum = localStorage.getItem('telNum')
          const age = this.age
          API.changeUserInfo({ telNum, age }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log('年龄没有变化')
          })
          this.$router.go(-1)
        }
      })
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
