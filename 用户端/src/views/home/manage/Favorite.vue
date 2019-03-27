<template>
  <div class="favorite-wrapper">
    <app-header title="收藏夹"
                back></app-header>
    <favorite-item v-for="(item,index) in favoriteList"
                   :key="index"
                   :data="item"
                   @event-delete="deleteItem(index,item.uid,item.goodsId)">
    </favorite-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import FavoriteItem from '@/components/FavoriteItem'
import { MessageBox } from 'mint-ui'
export default {
  components: {
    AppHeader,
    FavoriteItem
  },
  props: {},
  data () {
    return {
      favoriteList: []
    }
  },
  computed: {},
  created () {
    const uid = localStorage.getItem('uid')
    API.getFavoriteList({ uid }).then(res => {
      console.log(res)
      this.favoriteList = res.data
    }).catch(_ => {
      console.log(_)
    })
  },
  methods: {
    deleteItem (index, uid, goodsId) {
      MessageBox.confirm('确定要删除这条收藏吗?').then(action => {
        if (action === 'confirm') {
          API.deleteFavorite({ uid, goodsId }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log(_)
          })
          this.favoriteList.splice(index, 1)
        }
      }).catch(_ => {
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.favorite-wrapper {
}
</style>
