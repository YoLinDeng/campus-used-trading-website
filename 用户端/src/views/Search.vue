<template>
  <div class="search">
    <!-- 搜索 -->
    <div class="search-top">
      <van-nav-bar left-text="返回"
                   right-text="搜索"
                   left-arrow
                   @click-left="onClickLeft"
                   @click-right="onClickRight" />
      <input type="text"
             placeholder="请输入关键词"
             class="search-input"
             v-model="value">
    </div>
    <!-- 历史搜索 -->
    <div class="history">
      <div class="top">
        <span class="title">历史搜索</span>
        <img src="@/assets/images/trash.png"
             alt=""
             class="delete-icon"
             @click="deleteHistory">
      </div>
      <div class="history-item"
           v-for="(item, index) in historyList"
           :key="index"
           @click="goToSeachList(item.key)">{{item.key}}</div>
    </div>
  </div>
</template>
<script>
import { NavBar, Dialog } from 'vant'
export default {
  name: 'search',
  data () {
    return {
      value: '',
      historyList: []
    }
  },
  components: {
    NavBar,
    Dialog
  },
  created () {
    let uid = localStorage.getItem('uid')
    API.getUserSearchHistory({ uid }).then(res => {
      this.historyList = res.data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    onClickLeft () {
      this.$router.push({ path: '/' })
    },
    onClickRight () {
      if (this.value !== '') {
        let uid = localStorage.getItem('uid')
        API.addSearchHistory({ key: this.value, uid }).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
        this.$router.push({
          path: '/searchlist',
          query: {
            inputVal: this.value
          }
        })
      }
    },
    deleteHistory () {
      Dialog.confirm({
        title: '提示',
        message: '确定要清楚历史搜索数据吗？'
      }).then(() => {
        this.historyList = []
        let uid = localStorage.getItem('uid')
        API.deleteUserSearchHistory({ uid }).then(res => {
          console.log(res)
        }).catch(_ => {
          console.log(_)
        })
      }).catch(() => {
        console.log('')
      })
    },
    goToSeachList (key) {
      this.$router.push({
        path: '/searchlist',
        query: {
          inputVal: key
        }
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.search {
  .search-top {
    position: relative;
    top: 0;
    left: 0;
    .search-input {
      position: absolute;
      left: 20%;
      top: 15%;
      z-index: 1;
      width: 65%;
      height: 30px;
      font-size: 14px;
      background: #fcfcfc;
      outline: none;
      border: none;
      border-radius: 0.5rem;
      text-indent: 10px;
    }
  }
  .history {
    background: #fff;
    border-top: 1px solid #fcfcfc;
    .top {
      position: relative;
      border-bottom: 1px solid #fcfcfc;
      .title {
        font-size: 0.43rem;
        height: 1rem;
        display: inline-block;
        line-height: 1rem;
        margin-left: 2%;
      }
      .delete-icon {
        width: 5vw;
        height: 5vw;
        display: inline-block;
        position: absolute;
        right: 3%;
        top: 45%;
      }
    }
    .history-item {
      height: 1rem;
      font-size: 0.43rem;
      line-height: 1rem;
      border-bottom: 1px solid #fcfcfc;
      margin-left: 0.1rem;
    }
  }
}
</style>
