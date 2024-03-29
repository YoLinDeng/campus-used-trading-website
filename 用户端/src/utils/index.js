export const getUrlParam = (name, url) => {
  if (!url) {
    url = window.location.href
  }

  const reg = new RegExp('[\\[\\]]', 'g')
  name = name.replace(reg, '\\$&')
  const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)')
  const results = regex.exec(url)
  if (!results) return ''
  if (!results[2]) return ''
  return decodeURIComponent(results[2].replace(/\+/g, ' '))
}
export const changeNode = (obj) => {
  if (!obj || !obj.length) { return }
  for (var i = 0; i < obj.length; i++) {
    obj[i].originName = obj[i].name
    if (getLength(obj[i].name) > 40) {
      let name = obj[i].name
      obj[i].name = obj[i].name.substr(0, 20) + '...'
      obj[i].originName = name
    }
    var item = obj[i]
    if (item.hasOwnProperty('children') && item.children.length > 0) {
      changeNode(item.children)
    }
  }
}
const getLength = (str) => {
  let len = 0
  for (let i = 0; i < str.length; i++) {
    var c = str.charCodeAt(i)
    if ((c >= 0x0001 && c <= 0x007e) || (c >= 0xff60 && c <= 0xff9f)) {
      len++
    } else {
      len += 2
    }
  }
  return len
}

/**
 * 转义html为安全文本
 * @returns {String}
 */
export const htmlEncode = str => {
  if (typeof str !== 'string') return ''

  str = str.replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#39;')
    .replace(/ /g, '&nbsp;')
  return str
}
/**
 * encode的逆函数
 * @returns {String}
 */
export const htmlDecode = text => {
  if (typeof text !== 'string') return ''
  const htmlDecodes = {
    '&amp;': '&',
    '&quot;': '"',
    '&lt;': '<',
    '&gt;': '>',
    '&nbsp;': ' ',
    '&#39;': "'"
  }
  const map = htmlDecodes
  return text.replace(/(&quot;|&lt;|&gt;|&amp;|&nbsp;|&#39;)/g, function (str, item) {
    return map[item]
  })
}
