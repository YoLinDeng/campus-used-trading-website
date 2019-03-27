<template>
  <div class="address-wrapper">
    <app-header back
                title="我的地址">
    </app-header>
    <div class="address-item"
         @click="goToAddressDetail">
      <div class="item-title">
        {{ nameAndPhone }}
      </div>
      <div class="item-detail">
        {{ detailInfo }}
      </div>
    </div>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
export default {
  name: 'my-address',
  components: {
    AppHeader
  },
  props: {},
  data () {
    return {
      nameAndPhone: '',
      detailInfo: ''
    }
  },
  computed: {},
  created () {
    const telNum = localStorage.getItem('telNum')
    API.getUserInfo({ telNum }).then(res => {
      this.nameAndPhone = res.data.userName + ',' + res.data.telNum
      this.detailInfo = res.data.address
    })
  },
  methods: {
    goToAddressDetail () {
      this.$router.push({ path: '/addressdetail' })
    }
  }
}
</script>
<style lang="scss" scoped>
.address-wrapper {
  .address-item {
    height: 2rem;
    border-bottom: 1px solid #d8d8d8;
    background: #fff;
    padding-left: 0.3rem;
    padding-top: 0.3rem;
    box-sizing: border-box;
    &:active {
      background: #d8d8d8;
    }
    &:focus {
      background: #d8d8d8;
    }
    .item-title {
      font-size: 0.45rem;
    }
    .item-detail {
      font-size: 0.38rem;
      color: #888;
      margin-top: 0.1rem;
    }
  }
}
</style>
