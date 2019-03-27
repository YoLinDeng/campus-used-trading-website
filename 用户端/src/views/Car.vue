<template>
  <div class="car">
    <car-item v-for="(item,index) in favoriteList"
              :key="index"
              :data="item"
              @event-delete="deleteItem(index,item.goodsId)">
    </car-item>
    <div class="noList"
         v-if="isNoList">还没有心仪的宝贝哦~赶紧去添加购物车吧</div>
    <app-footer></app-footer>
  </div>
</template>
<script>
import AppFooter from '@/components/AppFooter'
import CarItem from '@/components/CarItem'
import { MessageBox } from 'mint-ui'
export default {
  name: 'car',
  components: {
    AppFooter,
    CarItem
  },
  data () {
    return {
      favoriteList: [],
      isNoList: false
    }
  },
  created () {
    const uid = localStorage.getItem('uid')
    if (!uid) {
      MessageBox.alert('登录后才能查看购物车哦~').then(action => {
        this.$router.push({ path: '/login' })
      })
    }
    API.getCarList({ uid }).then(res => {
      this.favoriteList = res.data
      if (this.favoriteList.length === 0) {
        this.isNoList = true;
      }
    }).catch(_ => {
      this.isNoList = true;
      console.log(_)
    })
    console.log(this.isNoList)
  },
  methods: {
    deleteItem (index, goodsId) {
      MessageBox.confirm('确定要删除这条收藏吗?').then(action => {
        if (action === 'confirm') {
          const uid = localStorage.getItem('uid')
          API.deleteCarItem({ uid, goodsId }).then(res => {
            console.log(res)
          }).catch(_ => {
            console.log(_)
          })
          this.favoriteList.splice(index, 1)
        }
      }).catch(_ => {
        console.log('')
      })
    }
  }
}
</script>
<style lang="scss" scoped>
.noList {
  position: absolute;
  top: 5rem;
  width: 100%;
  text-align: center;
  font-size: 0.4rem;
}
</style>
