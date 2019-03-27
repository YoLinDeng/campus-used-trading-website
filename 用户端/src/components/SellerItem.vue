<template>
  <div class='seller-item-wapper'
       @click="goToSellerInfo">
    <div class="item-img">
      <img :src="data.userImg"
           alt="">
    </div>
    <div class="desc">
      <div class="title">
        <span class="title-name">{{data.follUname}}</span>
      </div>
    </div>
    <mt-button size="small"
               type="danger"
               v-if="isFollow"
               @click.stop="clickBtn"
               class="btn">取消关注</mt-button>
    <mt-button size="small"
               type="primary"
               v-else
               class="btn"
               @click.stop="clickBtn">关注</mt-button>
  </div>
</template>

<script>

export default {
  name: 'seller-item',
  props: ['data'],
  data () {
    return {
      isFollow: true
    }
  },

  components: {},

  computed: {},

  methods: {
    clickBtn () {
      const uid = localStorage.getItem('uid')
      let follUid = this.data.follUid
      let follUname = this.data.follUname
      let userImg = this.data.userImg.slice(19)
      if (this.isFollow === true) {
        API.cancelFollowUser({ uid, follUid }).then(res => {
          console.log(res)
        }).catch(_ => {
        })
        this.isFollow = false
      } else {
        API.followUser({
          uid,
          follUid,
          follUname,
          userImg
        }).then(res => {
          console.log(res)
        })
        this.isFollow = true
      }
    },
    goToSellerInfo () {
      const uid = this.data.follUid
      this.$router.push({
        path: '/personaldata', query: {
          uid
        }
      })
    }
  }

}

</script>
<style lang='scss' scoped>
.seller-item-wapper {
  border-bottom: 1px solid#d8d8d8;
  height: 3rem;
  background: #fff;
  padding-top: 0.5rem;
  box-sizing: border-box;
  position: relative;
  .item-img {
    width: 18vw;
    height: 18vw;
    border-radius: 5px;
    margin-left: 0.5rem;
    img {
      width: 100%;
    }
  }
  .desc {
    position: absolute;
    left: 2.8rem;
    top: 0.5rem;
    .title {
      font-size: 0.4rem;
      .title-name {
        font-size: 0.4rem;
        font-weight: bold;
        margin-left: 0.1rem;
      }
    }
  }
  .btn {
    width: 23vw;
    height: 5vh;
    position: absolute;
    right: 0.5rem;
    top: 35%;
  }
}
</style>
