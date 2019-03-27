export default {
  // 登录接口
  login: {
    url: '/api/index.php/Index/index/managelogin',
    method: 'post'
  },
  // 查询所有用户信息接口
  getAllUserInfo: {
    url: '/api/index.php/Index/index/getAllUserInfo',
    method: 'post'
  },
  // 修改用户信息
  updateUserInfo:{
    url: '/api/index.php/Index/index/updateUserInfo',
    method: 'post'
  },
  // 删除用户
  deleteUser: {
    url: '/api/index.php/Index/index/deleteUser',
    method: 'post'
  },
  // 查询所有商品
  getAllGoods: {
    url: '/api/index.php/Index/index/getAllGoods',
    method: 'post'
  },
  // 审核商品
  confirmGoods: {
    url: '/api/index.php/Index/index/confirmGoods',
    method: 'post'
  },
  // 获取订单列表
  orderList: {
    url: '/api/index.php/Index/index/orderList',
    method: 'post'
  },
  // 删除订单
  deleteOrder: {
    url: '/api/index.php/Index/index/deleteOrder',
    method: 'post'
  },
  // 批量删除商品
  batchDeleteGoods: {
    url: '/api/index.php/Index/index/batchDeleteGoods',
    method: 'post'
  },
  // 获取所有评论,条件查询（通过用户id，通过商品id）
  getComment: {
    url: '/api/index.php/Index/index/getComment',
    method: 'post'
  },
  // 删除评论
  deleteComment: {
    url: '/api/index.php/Index/index/deleteComment',
    method: 'post'
  },
  // 管理员信息查询
  getManagerInfo: {
    url: '/api/index.php/Index/index/getManagerInfo',
    method: 'post'
  },
  // 修改管理员信息
  updateManagerInfo: {
    url: '/api/index.php/Index/index/updateManagerInfo',
    method: 'post'
  },
  // 新增管理员
  addManager: {
    url: '/api/index.php/Index/index/addManager',
    method: 'post'
  },
  // 删除管理员
  deleteManager: {
    url: '/api/index.php/Index/index/deleteManager',
    method: 'post'
  }

}
 