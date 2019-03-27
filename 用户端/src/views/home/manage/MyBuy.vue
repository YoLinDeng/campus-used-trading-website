<template>
  <div class="buy-wrapper">
    <app-header title="买到管理"
                back></app-header>
    <my-sell-item v-for="(item, index) in myBuyList"
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
      myBuyList: []
    }
  },
  computed: {},
  created () {
    const uid = localStorage.getItem('uid')
    const status = 0
    API.getOrderList({ uid, status }).then(res => {
      console.log(res)
      let data = res.data
      this.myBuyList = res.data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {}
}
</script>
<style lang="scss" scoped>
.buy-wrapper {
}
</style>
