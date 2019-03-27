<template>
  <div class='see-history-wapper'>
    <app-header title="浏览记录"
                back></app-header>
    <history-item v-for="(item, index) in historyList"
                  :key="index"
                  :data="item"></history-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import HistoryItem from '@/components/HistoryItem'
export default {
  name: 'see-history',
  props: [''],
  data () {
    return {
      historyList: []
    }
  },

  components: {
    AppHeader,
    HistoryItem
  },

  computed: {

  },
  created () {
    const uid = localStorage.getItem('uid')
    API.getHistoryLookList({ uid }).then(res => {
      let data = res.data
      const host = 'http://www.deng.com'
      data.forEach(item => {
        item.goodsImg = host + item.goodsImg
        item.pubUimg = host + item.pubUimg
      })
      this.historyList = data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {}

}

</script>
<style lang='scss' scoped>
.see-history-wapper {
}
</style>
