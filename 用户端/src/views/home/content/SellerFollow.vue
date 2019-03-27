<template>
  <div class='seller-item-wapper'>
    <app-header title="关注卖家"
                back></app-header>
    <seller-item v-for="(item, index) in SellerList"
                 :key="index"
                 :data="item"></seller-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import SellerItem from '@/components/SellerItem'
export default {
  name: 'seller-follow',
  props: [''],
  data () {
    return {
      SellerList: []

    }
  },

  components: {
    AppHeader,
    SellerItem
  },

  computed: {},
  created () {
    const uid = localStorage.getItem('uid')
    API.getFollowUserList({ uid }).then(res => {
      let data = res.data
      data.forEach(item => {
        item.userImg = 'http://www.deng.com' + item.userImg
      })
      this.SellerList = data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {}

}

</script>
<style lang='scss' scoped>
.seller-item-wapper {
}
</style>
