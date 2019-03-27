<template>
  <div class="my-comment-wapper">
    <app-header title="我的评论"
                back></app-header>
    <comment-item v-for="(item,index) in commentList"
                  :key="index"
                  :data="item"
                  @click.native="goToGoodsDetail(item.publicUid,item.goodsId)"></comment-item>
  </div>
</template>

<script>
import AppHeader from '@/components/AppHeader'
import CommentItem from '@/components/CommentItem'
export default {
  name: 'my-comment',
  props: [''],
  data () {
    return {
      commentList: []
    }
  },

  components: {
    AppHeader,
    CommentItem
  },

  computed: {},
  created () {
    const uid = localStorage.getItem('uid');
    API.getCommentList({ uid }).then(res => {
      console.log(res)
      let data = res.data
      let host = 'http://www.deng.com'
      data.forEach(item => {
        item.goodsImg = host + item.goodsImg
        item.userImg = host + item.userImg
      })
      this.commentList = data
    }).catch(_ => { })
  },
  methods: {
    goToGoodsDetail (uid, goodsid) {
      this.$router.push({ path: '/goodsdetail', query: { uid, goodsid } })
    }
  }

}

</script>
<style lang='scss' scoped>
.my-comment-wapper {
}
</style>
