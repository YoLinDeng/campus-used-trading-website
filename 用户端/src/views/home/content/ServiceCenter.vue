<template>
  <div class='service-center-wapper'>
       <app-header title="客服电话" back>
    </app-header>
    <p class="content">如有任何关于产品的问题，欢迎致电客服热线400-666-6666</p>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
export default {
  name: 'service-center',
  props: [''],
  data () {
    return {

    }
  },

  components: {
    AppHeader
  },

  computed: {},

  methods: {}

}

</script>
<style lang='scss' scoped>
.service-center-wapper {
  .content {
    font-size: 0.43rem;
    width: 90%;
    margin: 10% auto;
    text-align: center;
  }

}
</style>
