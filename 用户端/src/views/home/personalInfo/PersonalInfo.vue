<template>
  <div class="personal-info">
    <app-header title="个人信息"
                back></app-header>
    <div class="user-icon"
         @click="changeIcon">
      <div class="title-name">
        头像
      </div>
      <img :src="userImg"
           alt=""
           class="user-img">
      <img src="@/assets/images/right-jt.png"
           alt=""
           class="right-jt">
      <input type="file"
             ref="file"
             :accept="accept"
             @change="fileChange">
    </div>
    <mt-cell class="user-name cell-item"
             title="昵称"
             to="/changename"
             is-link
             :value="userName">
    </mt-cell>
    <mt-cell title="用户账号"
             :value="phone"
             class="user-id cell-item"></mt-cell>
    <mt-cell class="more cell-item"
             title="更多"
             to="/moreinfo"
             is-link>
    </mt-cell>
    <mt-cell class="address cell-item"
             title="我的地址"
             to="/myaddress"
             is-link>
    </mt-cell>
    <mt-button type="danger"
               class="quit"
               size="large"
               @click="quit">退出登录</mt-button>
  </div>
</template>
<script>
import { MessageBox, Button } from 'mint-ui'
import AppHeader from '@/components/AppHeader'
export default {
  name: 'personal-info',
  data () {
    return {
      accept: 'image/*',
      maxSize: 3000000, // (单位:b = 字节, 1mb = 1024000b)
      name: '',
      icon: '',
      userName: '',
      phone: '',
      userImg: ''
    }
  },
  created () {
    const telNum = localStorage.getItem('telNum')
    API.getUserInfo({ telNum }).then(res => {
      this.userName = res.data.userName
      this.phone = res.data.telNum
      this.userImg = 'http://www.deng.com' + res.data.userImg
    })
  },
  methods: {
    // 将头像div绑定到input file 上
    changeIcon () {
      this.$refs.file.click()
    },
    fileChange (e) {
      let file = e.target.files[0]
      let telNum = localStorage.getItem('telNum')
      if (file.size > this.maxSize) {
        MessageBox('提示', '图片太大了噢')
      } else {
        let formData = new FormData()
        formData.append('img', file)
        formData.append('telNum', telNum)
        API.upload(formData).then(res => {
          console.log(res)
          let host = 'http://www.deng.com'
          this.userImg = host + res.path
        })
      }
    },
    goToChangeNamePage () {
      this.$router.push({ path: '/changename' })
    },
    goToMyAddress () {
      this.$router.push({ path: '/myaddress' })
    },
    quit () {
      MessageBox.confirm('确定要退出账号吗?').then(action => {
        localStorage.clear()
        this.$router.push({ path: '/login' })
      }).catch(_ => {
        console.log('error')
      })
    }
  },
  components: {
    AppHeader,
    Button
  }
}
</script>
<style lang="scss" scoped>
.personal-info {
  .user-icon {
    height: 2rem;
    padding-left: 0.3rem;
    font-size: 0.38rem;
    line-height: 2rem;
    background: #fff;
    border-bottom: 1px solid#d8d8d8;
    .user-img {
      display: block;
      width: 13vw;
      height: 13vw;
      border-radius: 50%;
      position: absolute;
      right: 1rem;
      top: 1.3rem;
    }
    .right-jt {
      width: 3vw;
      height: 3vw;
      position: absolute;
      right: 0.38rem;
      top: 1.8rem;
    }
    input[type="file"] {
      display: none;
    }
  }
  .cell-item {
    border-bottom: 1px solid#d8d8d8;
  }
  .address {
    border-top: 1px solid#d8d8d8;
    margin-top: 0.2rem;
  }
  .quit {
    margin-top: 0.2rem;
  }
}
</style>
