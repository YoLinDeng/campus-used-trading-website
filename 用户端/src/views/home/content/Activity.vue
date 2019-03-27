<template>
  <div class='activity-wapper'>
    <app-header title="活动"
                back></app-header>
    <activity-item v-for="(item, index) in activityList"
                   :key="index"
                   :data="item"></activity-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import ActivityItem from '@/components/ActivityItem'
export default {
  name: 'activity',
  props: [''],
  data () {
    return {
      activityList: []
    }
  },

  components: {
    AppHeader,
    ActivityItem
  },

  computed: {},
  created () {
    API.getActivityList().then(res => {
      let data = res.data
      data.forEach(item => {
        item.img = 'http://www.deng.com' + item.img
      })
      this.activityList = data
    })
  },
  methods: {}

}

</script>
<style lang='scss' scoped>
</style>
