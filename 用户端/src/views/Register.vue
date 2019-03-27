<template>
  <div class="register-wrapper">
    <mt-field label="用户名"
              placeholder="输入用户名"
              v-model="username"></mt-field>
    <mt-field label="密码"
              placeholder="输入6-8位密码"
              type="password"
              v-model="password"></mt-field>
    <mt-field label="电子邮箱"
              placeholder="输入电子邮箱"
              type="email"
              v-model="email"></mt-field>
    <mt-field label="电话号码"
              placeholder="输入电话号码"
              type="tel"
              v-model="phone"></mt-field>
    <mt-field label="年龄"
              placeholder="输入年龄"
              type="number"
              v-model="age"></mt-field>
    <div class="sex">
      <span>性别</span>
      <select name="sex"
              class="select"
              v-model="value">
        <option value="0">男</option>
        <option value="1">女</option>
      </select>
    </div>
    <mt-field label="地址"
              placeholder="输入收货地址"
              type="textarea"
              rows="4"
              v-model="address"></mt-field>
    <mt-button type="primary"
               class="register-btn"
               @click="Register">注册</mt-button>
  </div>
</template>

<script>
import { Field, Button, MessageBox } from 'mint-ui'
export default {
  components: {
    Field,
    Button
  },
  props: {},
  data () {
    return {
      username: '',
      password: '',
      email: '',
      phone: '',
      age: '',
      value: 0,
      address: '',
      isFormat: true
    }
  },
  computed: {},
  methods: {
    Register () {
      // 表单验证
      this.testFormat()
      if (this.isFormat) {
        const telNum = this.phone
        API.checkTelNum({ telNum }).then(res => {
          if (res.isOnly === false) {
            MessageBox('提示', '该手机号已被使用')
          } else {
            MessageBox('提示', '注册成功').then(action => {
              let sexSrc = this.value === 0 ? '男' : '女'
              const params = {
                userName: this.username,
                password: this.password,
                email: this.email,
                telNum: this.phone,
                age: this.age,
                sex: sexSrc,
                address: this.address
              }
              this.$store.dispatch('setUserInfoAction', params)
              this.$router.push({ path: '/login' })
            })
          }
        })
      }
    },
    // 表单验证
    testFormat () {
      this.isFormat = true
      if (this.username === '' ||
        this.password === '' ||
        this.email === '' ||
        this.phone === '' ||
        this.age === '' ||
        this.address === '') {
        MessageBox('注意', '请将信息填写完整')
        this.isFormat = false
      } else {
        if (this.password.length < 6 || this.password.length > 8) {
          MessageBox('提示', '密码格式错误，密码长度为6-8位')
          this.isFormat = false
        }
        var reg = new RegExp('^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$') // 正则表达式
        if (!reg.test(this.email)) {
          MessageBox('提示', '邮箱格式错误')
          this.isFormat = false
        }
        if (!(/^1[34578]\d{9}$/.test(this.phone))) {
          MessageBox('提示', '电话号码格式错误')
          this.isFormat = false
        }
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.register-wrapper {
  .sex {
    height: 1rem;
    background: #fff;
    line-height: 1rem;
    font-size: 0.4rem;
    span {
      margin-left: 0.2rem;
      margin-right: 1.5rem;
    }
  }
  .register-btn {
    width: 100%;
  }
}
</style>
