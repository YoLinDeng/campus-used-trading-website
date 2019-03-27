<template>
  <div class="my-publish-wrapper">
    <app-header title="我的发布"
                back></app-header>
    <my-publish-item v-for="(item,index) in publishList"
                     :key="index"
                     :data="item"
                     @event-click-delete="clickDelete(index,item.goodsId)"
                     @event-click-edit="clickEdit(item.goodsId,item.uid)"></my-publish-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import MyPublishItem from '@/components/MyPublishItem'
import { MessageBox, Toast } from 'mint-ui'
export default {
  components: {
    AppHeader,
    MyPublishItem,
    MessageBox
  },
  props: {},
  data () {
    return {
      publishList: []
    }
  },
  computed: {},
  created () {
    const uid = localStorage.getItem('uid')
    const status = 1
    API.getGoodsList({ uid, status }).then(res => {
      console.log(res)
      let data = res.data
      data.forEach((item) => {
        item.postTime = item.postTime.split(' ')[0].replace(/-/g, '/')
      })
      this.publishList = res.data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    clickDelete (index, goodsId) {
      MessageBox.confirm('确定要删除这个发布的物品吗?').then(action => {
        if (action === 'confirm') {
          this.publishList.splice(index, 1)
          API.deletePublicGoods({ goodsId }).then(res => {
            Toast('删除成功');
          }).catch(_ => {
            Toast('删除失败');
          })
        }
      }).catch(_ => {
        console.log(_)
      })
    },
    clickEdit (goodsid, uid) {
      this.$router.push({ path: '/goodsDetail', query: { goodsid, uid } })
    }
  }
}
</script>
<style lang="scss" scoped>
.my-publish-wrapper {
}
</style>
