<template>
  <div class="index">
    <!-- 搜索 -->
    <van-search v-model="value"
                placeholder="请输入搜索关键词"
                show-action
                shape="round"
                @click="onSearch">
      <div slot="action"
           @click="onSearch">搜索</div>
    </van-search>
    <!-- 轮播图 -->
    <van-swipe :autoplay="3000"
               :height="200">
      <van-swipe-item v-for="(image, index) in images"
                      :key="index">
        <img v-lazy="image"
             class="swipe-img" />
      </van-swipe-item>
    </van-swipe>
    <!-- 商品内容 -->
    <section class="content">
      <van-tabs v-model="active">
        <van-tab title="全部商品"
                 class="tab-content">
          <commodity-card v-for="(item, index) in allGoodsList"
                          :key="index"
                          :data="item"
                          @click.native="goToGoodsDetail(item.uid,item.goodsId)"></commodity-card>
        </van-tab>
        <van-tab title="电脑数码">
          <commodity-card v-for="(item, index) in DigitalList"
                          :key="index"
                          :data="item"
                          @click.native="goToGoodsDetail(item.uid,item.goodsId)"></commodity-card>
        </van-tab>
        <van-tab title="运动户外">
          <commodity-card v-for="(item, index) in spotList"
                          :key="index"
                          :data="item"
                          @click.native="goToGoodsDetail(item.uid,item.goodsId)"></commodity-card>
        </van-tab>
        <van-tab title="服饰鞋包">
          <commodity-card v-for="(item, index) in dressList"
                          :key="index"
                          :data="item"
                          @click.native="goToGoodsDetail(item.uid,item.goodsId)"></commodity-card>
        </van-tab>
        <van-tab title="文具书籍">
          <commodity-card v-for="(item, index) in bookList"
                          :key="index"
                          :data="item"
                          @click.native="goToGoodsDetail(item.uid,item.goodsId)"></commodity-card>
        </van-tab>
        <van-tab title="日用品">
          <commodity-card v-for="(item, index) in commodityList"
                          :key="index"
                          :data="item"
                          @click.native="goToGoodsDetail(item.uid,item.goodsId)"></commodity-card>
        </van-tab>
        <loading :data="tipData"></loading>
      </van-tabs>
    </section>
    <app-footer></app-footer>
  </div>
</template>

<script>
import AppFooter from '@/components/AppFooter'
import CommodityCard from '@/components/CommodityCard'
import Loading from '@/components/Loading'
import { Search, Swipe, SwipeItem, Tab, Tabs } from 'vant'
export default {
  name: 'index',
  data () {
    return {
      value: '',
      images: [
        require('@/assets/images/banner1.jpg'),
        require('@/assets/images/banner2.png')
      ],
      active: 0,
      page: 1,
      tipData: {
        code: -2,
        msg: ''
      },
      allGoodsList: [],
      // 电脑数码列表
      DigitalList: [],
      // 运动户外列表
      spotList: [],
      // 服饰鞋包列表
      dressList: [],
      // 文具书籍列表
      bookList: [],
      // 日用品列表
      commodityList: []
    }
  },
  components: {
    AppFooter,
    CommodityCard,
    Search,
    Swipe,
    SwipeItem,
    Tab,
    Tabs,
    Loading
  },
  mounted () {
    window.addEventListener('scroll', this.handleScroll, true)
  },
  created () {
    let type = this.active
    let page = this.page
    API.getAllGoodsListByType({ type, page }).then(res => {
      console.log(res)
      this.tipData = {
        code: -1,
        msg: '加载中...'
      }
      this.allGoodsList = res.data
    }).catch(_ => {
      this.tipData = _
    })
  },
  methods: {
    onSearch () {
      this.$router.push({ path: '/search' })
    },
    goToGoodsDetail (uid, goodsid) {
      this.$router.push({
        path: '/goodsdetail',
        query: {
          uid,
          goodsid
        }
      })
    },
    // 分类查询接口调用
    getGoodsListByType (type) {
      if (type === 0) {
        API.getAllGoodsListByType({ type }).then(res => {
          this.allGoodsList = res.data
        }).catch(_ => {
          console.log(_)
        })
      }
      if (type === 1) {
        API.getAllGoodsListByType({ type }).then(res => {
          this.DigitalList = res.data
        }).catch(_ => {
          console.log(_)
        })
      }
      if (type === 2) {
        API.getAllGoodsListByType({ type }).then(res => {
          this.spotList = res.data
        }).catch(_ => {
          console.log(_)
        })
      }
      if (type === 3) {
        API.getAllGoodsListByType({ type }).then(res => {
          this.dressList = res.data
        }).catch(_ => {
          console.log(_)
        })
      }
      if (type === 4) {
        API.getAllGoodsListByType({ type }).then(res => {
          this.bookList = res.data
        }).catch(_ => {
          console.log(_)
        })
      }
      if (type === 5) {
        API.getAllGoodsListByType({ type }).then(res => {
          this.commodityList = res.data
        }).catch(_ => {
          console.log(_)
        })
      }
    },
    // 滚动查询分页数据
    getNextPageData () {
      let type = this.active
      let page = this.page
      if (type === 0) {
        API.getAllGoodsListByType({ type, page }).then(res => {
          for (let i = 0; i < res.data.length; i++) {
            this.allGoodsList.push(res.data[i])
          }
        }).catch(_ => {
          this.tipData = _
        })
      }
    },
    // 滚动事件
    handleScroll () {
      //变量scrollTop是滚动条滚动时，距离顶部的距离
      var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
      //变量windowHeight是可视区的高度
      var windowHeight = document.documentElement.clientHeight || document.body.clientHeight;
      //变量scrollHeight是滚动条的总高度
      var scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
      //滚动条到底部的条件
      if (scrollTop + windowHeight == scrollHeight) {
        this.page++
        this.isShow = true
        this.getNextPageData()
        console.log(this.page)
      }
    }
  },
  destroyed () {
    window.removeEventListener('scroll', this.handleScroll, true)
  },
  watch: {
    active (val) {
      this.page = 1
      this.tipData = {
        code: -2,
        msg: ''
      }
      let type = val
      this.getGoodsListByType(type)
    }
  }
}
</script>
<style lang="scss" scoped>
.index {
  height: 100%;
  background: #fff;
  .search {
    font-size: 0.38rem;
  }
  .swipe-img {
    width: 100%;
  }
  .content {
    background: #fff;
    padding-bottom: 2rem;
  }
}
</style>
