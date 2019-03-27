<template>
  <div class="app-header">
    <mt-header fixed
               :title="title">
      <!-- 自定义插槽 -->
      <div slot="left"
           v-if="back">
        <mt-button @click.native="routerBack"
                   icon="back">
          返回
        </mt-button>
      </div>
      <div slot="right"
           v-if="right">
        <mt-button class="right"
                   @click.native="$emit('right-click')">
          {{ right }}
        </mt-button>
      </div>
    </mt-header>
  </div>
</template>

<script>
import Vue from 'vue'
import { Header } from 'mint-ui'

Vue.component(Header.name, Header)

export default {
  props: {
    title: String,
    back: Boolean,
    right: String
  },
  data () {
    return {
    }
  },
  methods: {
    routerBack () {
      this.$router.go(-1)
    }
  }

}
</script>

<style scoped lang="scss">
.app-header {
  height: 1rem;
  .right {
    width: 1.2rem;
    height: 0.7rem;
    background: #00cd00;
    color: #fff;
    font-size: 0.36rem;
    font-weight: 500;
  }
  .right-icon {
    height: 20px;
  }
}
.mint-header {
  background-color: #f5f5f5;
  color: black;
}
.mint-button::after {
  background: #f5f5f5;
}
</style>
