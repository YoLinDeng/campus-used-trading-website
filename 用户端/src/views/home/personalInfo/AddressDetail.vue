<template>
  <div class="address-Detail-wrapper">
    <app-header title="修改地址"
                back
                :right="right"
                @right-click="saveAddress"></app-header>
    <mt-field label="收货人"
              placeholder="姓名"
              v-model="userName"></mt-field>
    <mt-field label="手机号码"
              placeholder="11位手机号"
              v-model="phone"
              disabled
              class="phone"></mt-field>
    <mt-field label="学校地址"
              placeholder="学校地址信息"
              v-model="address"></mt-field>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import { MessageBox, Field } from 'mint-ui'
export default {
  components: {
    AppHeader,
    Field
  },
  props: {},
  data () {
    return {
      right: '保存',
      userName: '',
      phone: '',
      address: ''
    }
  },
  computed: {},
  created () {
    const telNum = localStorage.getItem('telNum')
    API.getUserInfo({ telNum }).then(res => {
      this.userName = res.data.userName
      this.phone = res.data.telNum
      this.address = res.data.address
    })
  },
  methods: {
    saveAddress () {
      MessageBox.confirm('你确定要保存这些地址信息吗?').then(action => {
        if (action === 'confirm') {
          const telNum = localStorage.getItem('telNum')
          const userName = this.userName
          const address = this.address
          API.changeUserInfo({ telNum, userName, address }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log('内容相同')
          })
          this.$router.go(-1)
        }
      }).catch(_ => {

      })
    }
  }
}
</script>
<style lang="scss" scoped>
.address-Detail-wrapper {
  input.mint-field-core {
    background: #fff;
  }
  button, input, textarea{
     background: #fff;
  }
}
</style>
