<template>
  <div class="load-wrapper">
    <div class="text"
         v-show="data.code === -1">{{data.msg}}</div>
    <div class="text"
         v-show="data.code === 0">{{data.msg}}</div>
  </div>
</template>

<script>
export default {
  components: {},
  props: ['data'],
  data () {
    return {
    }
  },
  computed: {},
  methods: {},
}
</script>
<style lang="scss" scoped>
.load-wrapper {
  width: 100%;
  margin-top: 0.5rem;
  .text {
    font-size: 0.4rem;
    text-align: center;
  }
}
</style>