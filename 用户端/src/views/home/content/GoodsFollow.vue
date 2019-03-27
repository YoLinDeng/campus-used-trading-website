<template>
  <div class='goods-follow-wapper'>
    <app-header title="商品关注"
                back></app-header>
    <goods-item v-for="(item, index) in goodsList"
                :key="index"
                :data="item"
                @click.native="goToGoodsDetail(item.pubUid,item.goodsId)"></goods-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import GoodsItem from '@/components/GoodsItem'
export default {
  name: 'goods-follow',
  props: [''],
  data () {
    return {
      goodsList: []
    }
  },

  components: {
    AppHeader,
    GoodsItem
  },

  computed: {},
  created () {
    const uid = localStorage.getItem('uid');
    API.getFavoriteList({ uid }).then(res => {
      console.log(res)
      let data = res.data
      data.forEach(item => {
        item.goodsImg = 'http://www.deng.com' + item.goodsImg
        item.pubUimg = 'http://www.deng.com' + item.pubUimg
      })
      this.goodsList = data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    goToGoodsDetail (uid, goodsid) {
      this.$router.push({
        path: '/goodsdetail',
        query: {
          uid,
          goodsid
        }
      })
    }
  }

}

</script>
<style lang='scss' scoped>
.goods-follow-wapper {
}
</style>
