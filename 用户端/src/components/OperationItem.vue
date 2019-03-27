<template>
  <div class="operation-wrapper">
    <div class="item"
         @click="goToMyManage(data.type)">
      <div class="number">{{data.num}}</div>
      <div class="item-name">{{data.itemName}}</div>
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  props: {
    data: {
      type: Object,
      required: true
    }
  },
  data () {
    return {
    }
  },
  computed: {},
  methods: {
    goToMyManage (type) {
      if (type === 1) {
        this.$router.push({ path: '/mypublish' })
      } else if (type === 2) {
        this.$router.push({ path: '/mysell' })
      } else if (type === 3) {
        this.$router.push({ path: '/mybuy' })
      } else {
        this.$router.push({ path: '/favorite' })
      }
    }
  }
}
</script>
<style lang="scss" scoped>
.operation-wrapper {
  flex: 1;
  .item {
    text-align: center;
    padding-bottom: 0.3rem;
    color: #484848;
    .number {
      margin-top: 0.2rem;
      margin-bottom: 0.1rem;
    }
  }
}
</style>
