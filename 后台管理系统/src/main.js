// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
// import Mock from './mock'
import API from './api/api.js'
// Mock.bootstrap()
window.API = API

import elmentUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(elmentUI)

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  //components: { App },
  render: h => h(App)
})
