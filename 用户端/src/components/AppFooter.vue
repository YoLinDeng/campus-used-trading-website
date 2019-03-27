<template>
  <div class="app-footer">
    <van-tabbar v-model="active"
                active-color="#00cd00">
      <van-tabbar-item v-for="(item, index) in itemList"
                       :to="{ name: item.name }"
                       :key="index">
        <span>{{ item.desc }}</span>
        <img slot="icon"
             slot-scope="props"
             :src="props.active ? item.icon.active : item.icon.normal">
      </van-tabbar-item>
    </van-tabbar>
  </div>
</template>
<script>
import Vue from 'vue'
import { Tabbar, TabbarItem } from 'vant'
Vue.use(Tabbar).use(TabbarItem)
export default {
  name: 'app-footer',
  data () {
    return {
      itemList: [
        {
          name: 'index',
          desc: '首页',
          icon: {
            normal: require('@/assets/images/index.png'),
            active: require('@/assets/images/check-index.png')
          }
        },
        {
          name: 'search',
          desc: '搜索',
          icon: {
            normal: require('@/assets/images/search.png'),
            active: require('@/assets/images/check-search.png')
          }
        },
        {
          name: 'publishedit',
          desc: '发布商品',
          icon: {
            normal: require('@/assets/images/publish.png'),
            active: require('@/assets/images/check-publish.png')
          }
        },
        {
          name: 'car',
          desc: '购物车',
          icon: {
            normal: require('@/assets/images/car.png'),
            active: require('@/assets/images/check-car.png')
          }
        },
        {
          name: 'home',
          desc: '个人中心',
          icon: {
            normal: require('@/assets/images/my.png'),
            active: require('@/assets/images/check-my.png')
          }

        }
      ]
    }
  },
  computed: {
    active: {
      get () {
        return this.itemList.findIndex(val => {
          return this.$route.name === val.name
        })
      },
      set () {

      }
    }
  },
  methods: {
  }
}
</script>
<style lang="scss" scoped>
.app-footer {
  width: 100%;
  position: fixed;
  bottom: 0;
  left: 0;
  background: #fff;
}
.van-tabbar {
  height: 1.5rem;
}
.van-tabbar-item {
  font-size: 0.38rem;
  color: #000;
  img {
    width: 7vw;
    height: 7vw;
  }
}
</style>
