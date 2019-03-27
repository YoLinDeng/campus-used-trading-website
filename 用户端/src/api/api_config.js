export default {
  // 登录接口
  login: {
    url: '/api/index.php/Index/index/login',
    method: 'post'
  },
  // 检验手机号唯一接口
  checkTelNum: {
    url: '/api/index.php/Index/index/checkTelNum',
    method: 'post'
  },
  // 注册接口
  register: {
    url: '/api/index.php/Index/index/register',
    method: 'post'
  },
  // 上传头像接口
  upload: {
    url: '/api/index.php/Index/index/uploadsImg',
    method: 'post'
  },
  // 通过手机查询用户信息接口
  getUserInfo: {
    url: '/api/index.php/Index/index/getUserInfoByTelNum',
    method: 'post'
  },
  // 修改用户信息接口
  changeUserInfo: {
    url: '/api/index.php/Index/index/changeUserInfo',
    method: 'post'
  },
  // 查询商品列表
  getGoodsList: {
    url: '/api/index.php/Index/index/getGoodsList',
    method: 'post'
  },
  // 查询订单列表
  getOrderList: {
    url: '/api/index.php/Index/index/getOrderList',
    method: 'post'
  },
  // 获取商品详情页面信息
  getGoodsDetailInfo: {
    url: '/api/index.php/Index/index/getGoodsDetailInfo',
    method: 'post'
  },
  // 删除发布商品
  deletePublicGoods: {
    url: '/api/index.php/Index/index/deletePublicGoods',
    method: 'post'
  },
  // 获取收藏夹数据
  getFavoriteList: {
    url: '/api/index.php/Index/index/getFavoriteList',
    method: 'post'
  },
  // 获取管理操作栏数目信息
  getManageNum: {
    url: '/api/index.php/Index/index/getManageNum',
    method: 'post'
  },
  // 删除收藏夹项
  deleteFavorite: {
    url: '/api/index.php/Index/index/deleteFavorite',
    method: 'post'
  },
  // 添加收藏夹
  addFavorite: {
    url: '/api/index.php/Index/index/addFavorite',
    method: 'post'
  },
  // 获取评论列表 
  getCommentList: {
    url: '/api/index.php/Index/index/getCommentList',
    method: 'post'
  },
  // 通过Id获取个人信息
  getUserInfoById: {
    url: '/api/index.php/Index/index/getUserInfoById',
    method: 'post'
  },
  // 关注用户
  followUser: {
    url: '/api/index.php/Index/index/followUser',
    method: 'post'
  },
  // 取消关注
  cancelFollowUser: {
    url: '/api/index.php/Index/index/cancelFollowUser',
    method: 'post'
  },
  // 获取关注用户列表
  getFollowUserList: {
    url: '/api/index.php/Index/index/getFollowUserList',
    method: 'post'
  },
  // 添加历史查看信息
  addHistoryLookList: {
    url: '/api/index.php/Index/index/addHistoryLookList',
    method: 'post'
  },
  // 获取历史查看列表
  getHistoryLookList: {
    url: '/api/index.php/Index/index/getHistoryLookList',
    method: 'post'
  },
  // 获取活动列表
  getActivityList: {
    url: '/api/index.php/Index/index/getActivityList',
    method: 'post'
  },
  // 加入购物车
  addCar: {
    url: '/api/index.php/Index/index/addCar',
    method: 'post'
  },
  // 获取购物车列表
  getCarList: {
    url: '/api/index.php/Index/index/getCarList',
    method: 'post'
  },
  // 删除购物车项
  deleteCarItem: {
    url: '/api/index.php/Index/index/deleteCarItem',
    method: 'post'
  },
  // 获取下单信息
  getConfirmOrderInfo: {
    url: '/api/index.php/Index/index/getConfirmOrderInfo',
    method: 'post'
  },
  // 添加订单信息
  addOrderInfo: {
    url: '/api/index.php/Index/index/addOrderInfo',
    method: 'post'
  },
  // 判断是否已经购买
  judgeBuy: {
    url: '/api/index.php/Index/index/judgeBuy',
    method: 'post'
  },
  // 删除发布信息
  deletePublishInfo: {
    url: '/api/index.php/Index/index/deletePublishInfo',
    method: 'post'
  },
  // 发布订单
  publishGoods: {
    url: '/api/index.php/Index/index/publishGoods',
    method: 'post'
  },
  // 添加评论 
  addComment: {
    url: '/api/index.php/Index/index/addComment',
    method: 'post'
  },
  // 查询商品列表 没有传type查全部，0 ：电脑数码  1：户外运动  2：服饰鞋包 3：文具书籍 4：日用品
  getAllGoodsListByType: {
    url: '/api/index.php/Index/index/getAllGoodsListByType',
    method: 'post'
  },
  // 关键词搜索
  searchByKey: {
    url: '/api/index.php/Index/index/searchByKey',
    method: 'post'
  },
  // 添加搜索历史
  addSearchHistory: {
    url: '/api/index.php/Index/index/addSearchHistory',
    method: 'post'
  },
  // 获取用户搜索历史
  getUserSearchHistory: {
    url: '/api/index.php/Index/index/getUserSearchHistory',
    method: 'post'
  },
  // 删除用户历史搜索
  deleteUserSearchHistory: {
    url: '/api/index.php/Index/index/deleteUserSearchHistory',
    method: 'post'
  }
}
