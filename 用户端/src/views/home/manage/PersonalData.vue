<template>
  <div class="personal-data-wrapper">
    <app-header title="用户信息"
                back></app-header>
    <div class="user-info">
      <div class="top">
        <img :src="userImg"
             alt=""
             class="user-photo">
        <div class="user-name">
          <div class="num">{{userNum}}</div>
          <div class="name">昵称 : {{userName}}</div>
        </div>
        <mt-button type="primary"
                   size="small"
                   class="btn"
                   @click="clickBtn"
                   v-if="!isFollow">关注</mt-button>
        <mt-button type="default"
                   size="small"
                   class="btn"
                   @click="clickBtn"
                   v-if="isFollow">已关注</mt-button>
      </div>
      <div class="user-desc">
        <div class="title">所在地址</div>
        <div class="content"> {{ content }}</div>
      </div>
      <div class="fans-follow">
        <div class="fans-num">{{fansNum}}粉丝</div>
        <div class="follow-num">{{followNum}}关注</div>
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import { Button, MessageBox } from 'mint-ui'
export default {
  components: {
    AppHeader,
    Button,
    MessageBox
  },
  props: {},
  data () {
    return {
      userNum: '',
      userName: '',
      content: '',
      userImg: '',
      fansNum: 2,
      followNum: 3,
      isFollow: ''
    }
  },
  computed: {},
  created () {
    const uid = this.$route.query.uid
    const userId = localStorage.getItem('uid')
    API.getUserInfoById({ uid, userId }).then(res => {
      this.userNum = res.data[0].telNum
      this.userName = res.data[0].userName
      this.content = res.data[0].address
      this.fansNum = res.data[0].fansNum
      this.followNum = res.data[0].followNum
      this.isFollow = res.isFollow
      this.userImg = 'http://www.deng.com' + res.data[0].userImg
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    clickBtn () {
      let uid = localStorage.getItem('uid')
      let follUid = this.$route.query.uid
      let follUname = this.userName
      let userImg = this.userImg.slice(19)
      if (this.isFollow === false) {
        API.followUser({
          uid,
          follUid,
          follUname,
          userImg
        }).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
        this.isFollow = true
        this.fansNum++
      } else {
        MessageBox.confirm('确定取消关注吗?').then(action => {
          if (action === 'confirm') {
            API.cancelFollowUser({ uid, follUid }).then(res => {
              this.isFollow = false
              this.fansNum--
            }).catch(_ => {
              console.log(_)
            })

          }
        })
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.personal-data-wrapper {
  .user-info {
    height: 5.5rem;
    background: #fff;
    .top {
      position: relative;
      .user-photo {
        margin-top: 0.5rem;
        margin-left: 0.5rem;
        width: 15vw;
        height: 15vw;
        border-radius: 4px;
        display: inline-block;
      }
      .user-name {
        height: 100%;
        position: absolute;
        left: 25%;
        top: 20%;
        color: #222;
        .num {
          font-size: 0.45rem;
        }
        .name {
          font-size: 0.38rem;
          margin-top: 0.1rem;
        }
      }
      .btn {
        position: absolute;
        right: 0.5rem;
        top: 30%;
      }
    }
    .user-desc {
      .title {
        font-size: 0.43rem;
        margin-left: 0.2rem;
        font-weight: bold;
      }
      .content {
        font-size: 0.4rem;
        margin-left: 0.2rem;
      }
    }
    .fans-follow {
      font-size: 0.45rem;
      font-weight: bold;
      line-height: 1rem;
      height: 1rem;
      .fans-num {
        display: inline-block;
        margin-left: 0.1rem;
      }
      .follow-num {
        display: inline-block;
        margin-left: 0.3rem;
      }
    }
  }
}
</style>
