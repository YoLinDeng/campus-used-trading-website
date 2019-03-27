<template>
  <div class="login-wrapper">
    <img src="@/assets/images/user-photo.png"
         alt=""
         class="photo">
    <div class="content">
      <div class="input-wrap">
        <img src="@/assets/images/user-login.png"
             alt="">
        <input type="text"
               placeholder="手机号"
               name="phone"
               v-model="telNum">
      </div>
      <div class="input-wrap">
        <img src="@/assets/images/password.png"
             alt="">
        <input type="password"
               placeholder="密码"
               name="password"
               v-model="password">
      </div>
      <mt-button type="primary"
                 size="large"
                 class="login-btn"
                 @click="Login">登录</mt-button>
      <div class="radio">
        <van-checkbox v-model="checked">记住密码</van-checkbox>
      </div>
      <mt-button type="default"
                 class="register"
                 @click="goToRegister">立即注册</mt-button>
    </div>

  </div>
</template>

<script>
import Vue from 'vue'
import { Button, MessageBox } from 'mint-ui'
import { Checkbox, CheckboxGroup } from 'vant'
Vue.component(Button.name, Button)
Vue.use(Checkbox).use(CheckboxGroup)
export default {
  components: {},
  props: {},
  data () {
    return {
      telNum: null,
      password: null,
      checked: false
    }
  },
  computed: {
    activeTelNum () {
      return this.$store.getters.getActiveTelNum
    },
    activePassword () {
      return this.$store.getters.getActivePassword
    }
  },
  created () {
    if (this.activeTelNum) {
      this.checked = true
      this.telNum = this.activeTelNum
      this.password = this.activePassword
    }
  },
  methods: {
    Login () {
      if (this.telNum === null || this.password === null) {
        MessageBox('提示', '请输入用户名或密码')
      } else {
        let telNum = this.telNum
        let password = this.password
        API.login({ telNum, password }).then(res => {
          if (this.checked === true) {
            this.$store.commit('UPDATE_ACTIVE_TELNUM', this.telNum)
            this.$store.commit('UPDATE_ACTIVE_PASSWORD', this.password)
          } else {
            this.$store.commit('UPDATE_ACTIVE_TELNUM', '')
            this.$store.commit('UPDATE_ACTIVE_PASSWORD', '')
          }
          localStorage.setItem('username', res.data[0].userName)
          localStorage.setItem('telNum', res.data[0].telNum)
          localStorage.setItem('userImg', res.data[0].userImg)
          localStorage.setItem('uid', res.data[0].uid)
          this.$router.push({ path: '/' })
        }).catch(_ => {
          MessageBox('提示', '用户名或密码输入错误')
        })
      }
    },
    goToRegister () {
      this.$router.push({
        path: '/register'
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.login-wrapper {
  .photo {
    width: 20vw;
    height: 20vw;
    border-radius: 50%;
    background: #ccc;
    display: block;
    margin: 20% auto;
  }
  .content {
    position: relative;
    .input-wrap {
      width: 80%;
      height: 1.2rem;
      margin: 0 auto;
      background: #fff;
      margin-bottom: 0.5rem;
      border-radius: 0.6rem;
      position: relative;
      img {
        width: 8vw;
        height: 8vw;
        margin-left: 0.3rem;
      }
      input {
        width: 70%;
        height: 1rem;
        position: absolute;
        left: 1.5rem;
        top: 0.12rem;
        border: none;
        outline: none;
        font-size: 0.39rem;
      }
    }
    .radio {
      font-size: 0.4rem;
      margin-left: 10%;
    }
    .register {
      position: absolute;
      left: 65%;
      top: 85%;
    }
  }
  .login-btn {
    width: 80%;
    margin: 10% auto;
  }
}
</style>
