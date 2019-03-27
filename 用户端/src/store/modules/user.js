import * as types from '../mutationType'
import API from '@/api/api.js'
const state = {
  userName: '', // 记录用户名
  acitveTelNum: '',
  activePassword: ''
}
const getters = {
  getUserName: state => state.userName,
  getActiveTelNum: state => state.acitveTelNum,
  getActivePassword: state => state.activePassword
}
const actions = {
  // 获取登录状态
  getUserNameAction ({ commit }, params) {
    API.login(params).then(res => {
      commit(types.UPDATE_USERNAME, res.data.userName)
    }).catch(_ => {
      console.log(_)
    })
  },
  // 提交注册信息
  setUserInfoAction ({ commit }, params) {
    API.register(params).then(res => {
      console.log(res)
    })
  }
}
const mutations = {
  [types.UPDATE_USERNAME] (state, src) {
    state.userName = src
  },
  [types.UPDATE_ACTIVE_TELNUM] (state, src) {
    state.acitveTelNum = src
  },
  [types.UPDATE_ACTIVE_PASSWORD] (state, src) {
    state.activePassword = src
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
