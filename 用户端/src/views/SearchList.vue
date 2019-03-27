<template>
  <div class="search-list-wrapper">
    <!-- 搜索 -->
    <div class="search-top">
      <van-nav-bar left-text="返回"
                   left-arrow
                   @click-left="onClickLeft" />
      <div class="input-div"
           @click="goToSearch">
        <input type="text"
               class="search-input"
               v-model="value">
        <img src="@/assets/images/small-search.png"
             alt="">
      </div>
    </div>
    <!-- 搜索列表内容 -->
    <search-list-item v-for="(item, index) in searchList"
                      :key="index"
                      :data="item"></search-list-item>
    <div class="no-list"
         v-if="tipData.code===0">没有相关商品信息~</div>
  </div>
</template>
<script>
import { NavBar, Dialog } from 'vant'
import SearchListItem from '@/components/SearchListItem'
export default {
  components: {
    NavBar,
    Dialog,
    SearchListItem
  },
  props: {},
  data () {
    return {
      value: this.$route.query.inputVal,
      searchList: [],
      tipData: ''
    }
  },
  computed: {},
  created () {
    API.searchByKey({ key: this.value }).then(res => {
      this.searchList = res.data
    }).catch(_ => {
      this.tipData = _
    })
  },
  methods: {
    onClickLeft () {
      this.$router.push({ path: '/' })
    },
    goToSearch () {
      this.$router.push({
        path: '/search'
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.search-list-wrapper {
  .search-top {
    position: relative;
    top: 0;
    left: 0;
    .input-div {
      position: absolute;
      left: 20%;
      top: 15%;
      width: 65%;
      height: 30px;
      z-index: 1;
      font-size: 14px;
      background: #fcfcfc;
      border-radius: 0.5rem;
    }
    .search-input {
      outline: none;
      border: none;
      position: absolute;
      height: 90%;
      left: 35%;
      top: 5%;
      background: #fcfcfc;
      text-indent: 10px;
    }
    img {
      position: absolute;
      left: 25%;
      top: 10%;
      z-index: 1;
      width: 25px;
      height: 25px;
      display: block;
    }
  }
  .no-list {
    font-size: 0.4rem;
    text-align: center;
    width: 100%;
    margin-top: 1rem;
  }
}
</style>