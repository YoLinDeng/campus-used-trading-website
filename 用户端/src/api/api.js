import apiConfig from './api_config.js'
import axios from 'axios'

/**
 * api.login({
 *     username: 'qwe',
 *     password: 123456
 * }).then((res) => {
 *     console.log(res)
 * })
 */
const obj = {}

for (let i in apiConfig) {
  let config = apiConfig[i]
  obj[i] = function (params) {
    return new Promise((resolve, reject) => {
      let opt = {
        method: config.method || 'get',
        url: config.url
      }
      if (config.method === 'post') {
        opt.data = params
      } else {
        opt.params = params
      }
      axios(opt)
        .then(res => {
          if (res.data.code === 1) {
            resolve(res.data)
          } else {
            console.log(res.data.msg)
            reject(res.data)
          }
        })
        .catch(error => {
          console.log(error)
          // alert('网络遇到问题，请稍后再试')
        })
    })
  }
}
export default obj
