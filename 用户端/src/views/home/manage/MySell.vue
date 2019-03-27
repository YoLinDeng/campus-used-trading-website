<template>
  <div class="sell-wrapper">
    <app-header title="卖出管理"
                back></app-header>
    <my-sell-item v-for="(item, index) in mySellList"
                  :key="index"
                  :data="item"></my-sell-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import MySellItem from '@/components/MysellItem'
export default {
  components: {
    AppHeader,
    MySellItem
  },
  props: {},
  data () {
    return {
      mySellList: []
    }
  },
  computed: {},
  created () {
    const uid = localStorage.getItem('uid')
    const status = 1
    API.getOrderList({ uid, status }).then(res => {
      console.log(res)
      let data = res.data
      data.forEach((item) => {
        item.imgUrl = 'http://www.deng.com' + item.imgUrl
      })
      this.mySellList = res.data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {}
}
</script>
<style lang="scss" scoped>
.sell-wrapper {
}
</style>
