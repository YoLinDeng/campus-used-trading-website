
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import MintUI from 'mint-ui'
import 'mint-ui/lib/style.css'
import Vant from 'vant'
import 'vant/lib/index.css'
import API from '@/api/api.js'
window.API = API
Vue.use(Vant)
Vue.use(MintUI)

Vue.config.productionTip = false

function setFontSize () {
  let deviceWidth = document.documentElement.clientWidth
  document.documentElement.style.fontSize = deviceWidth / 10 + 'px'
}
window.addEventListener('pageshow', function () {
  setFontSize()
})
var a
window.addEventListener('resize', function () {
  clearTimeout(a)
  a = setTimeout(setFontSize, 300)
})

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  components: { App },
  template: '<App/>'
})
