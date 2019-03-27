<template>
  <div class="more-info">
    <app-header title="更多信息"
                back></app-header>
    <mt-cell class="user-sex"
             title="性别"
             is-link
             v-model="sex"
             @click.native="selectSex">
    </mt-cell>
    <mt-cell to='/changeage'
             title="年龄"
             is-link
             v-model="age">
    </mt-cell>
    <!-- 性别选择模态框 -->
    <div class="select-sex"
         v-if="isShowSelect">
      <div class="man"
           @click="selectMan">
        <span>男</span>
      </div>
      <div class="woman"
           @click="selectWoman">
        <span>女</span>
      </div>
    </div>
    <div class="modal-bg"
         v-if="isShowSelect"
         @click="isShowSelect=false"></div>
  </div>
</template>
<script>
import AppHeader from '@/components/AppHeader'
import { Toast, Cell } from 'mint-ui'
export default {
  name: 'more-info',
  data () {
    return {
      sex: '',
      age: '', // 出生日期
      isShowSelect: false
    }
  },
  created () {
    const telNum = localStorage.getItem('telNum')
    API.getUserInfo({ telNum }).then(res => {
      this.sex = res.data.sex
      this.age = res.data.age
    })
  },
  methods: {
    // 选择性别
    selectSex () {
      this.isShowSelect = true
    },
    selectMan () {
      this.sex = '男'
      const sex = this.sex
      const telNum = localStorage.getItem('telNum')
      API.changeUserInfo({ telNum, sex }).then(res => {
        console.log(res)
      }).catch(_ => {
        console.log('性别相同')
      })
      this.isShowSelect = false
      Toast({
        message: '修改成功',
        position: 'center',
        duration: 2000
      })
    },
    selectWoman () {
      this.sex = '女'
      const sex = this.sex
      const telNum = localStorage.getItem('telNum')
      API.changeUserInfo({ telNum, sex }).then(res => {
        console.log(res)
      }).catch(_ => {
        console.log('性别相同')
      })
      this.isShowSelect = false
      Toast({
        message: '修改成功',
        position: 'center',
        duration: 2000
      })
    }
  },
  components: {
    AppHeader,
    Toast,
    Cell
  }
}
</script>
<style lang="scss" scoped>
.modal-bg {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1000;
  background: rgba(0, 0, 0, 0.5);
}
.more-info {
  .user-sex {
    border-bottom: 1px solid#d8d8d8;
  }
  .select-sex {
    width: 6rem;
    height: 2rem;
    background: #fff;
    font-size: 0.4rem;
    position: absolute;
    top: 30%;
    left: 20%;
    z-index: 1001;
    border: 1px solid #ccc;
    border-radius: 3px;
    box-shadow: 0 3px 3px#696969;
    .man {
      height: 50%;
      border-bottom: 1px solid#E8E8E8;
    }
    .woman {
      height: 50%;
    }
    span {
      display: block;
      padding-top: 0.2rem;
      padding-left: 0.3rem;
    }
  }
}
</style>
