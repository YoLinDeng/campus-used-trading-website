/**
 * 时间格式化方法
 */
export const dateFormat = (date, fmt) => {
  if (!date) return ''
  if (date.constructor !== Date) {
    date = new Date(date)
  }
  const o = {
    'M+': date.getMonth() + 1, // 月份
    'd+': date.getDate(), // 日
    'h+': date.getHours(), // 小时
    'm+': date.getMinutes(), // 分
    's+': date.getSeconds(), // 秒
    'q+': Math.floor((date.getMonth() + 3) / 3), // 季度
    'S': date.getMilliseconds() // 毫秒
  }
  if (/(y+)/.test(fmt)) {
    fmt = fmt.replace(RegExp.$1, (date.getFullYear() + '').substr(4 - RegExp.$1.length))
  }
  for (let k in o) {
    if (new RegExp('(' + k + ')').test(fmt)) {
      fmt = fmt.replace(RegExp.$1, (RegExp.$1.length === 1) ? (o[k]) : (('00' + o[k]).substr(('' + o[k]).length)))
    }
  }
  return fmt
}

/**
 * 业务范围显示格式化
 */
export const dispRoleItemFormat = (item) => {
  const strList = item || ''
  let newList = strList.split('!')
  if (newList.length > 2) {
    newList.splice(1, newList.length - 2)
  }
  return newList.join('/.../')
}

export const dispRoleGroupFormat = (list) => {
  const newList = list || []
  return newList.map(item => {
    return dispRoleItemFormat(item)
  }).join('，')
}

export const dispRoleGroupFormat2LongName = map => {
  const newMap = map || {}
  return Object.values(newMap).toString().replace(/!/g, '/')
}

export const dispRoleGroupFormat2Name = map => {
  const newMap = map || {}
  const list = Object.values(newMap)
  return list.map(item => dispRoleItemFormat(item)).join('，')
}
export const textSubstr = str => {
  if (str.length > 20) {
    return str.substr(0, 19) + '...'
  } else {
    return str
  }
}
