import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/views/Index'
const Search = () => import('@/views/Search')
const Car = () => import('@/views/Car')
const Home = () => import('@/views/home/Home')
const Login = () => import('@/views/Login')
const Register = () => import('@/views/Register')
const GoodsDetail = () => import('@/views/GoodsDetail')
const SearchList = () => import('@/views/SearchList')
// 个人中心
const Personal = () => import('@/views/home/personalInfo/PersonalInfo')
const ChangeName = () => import('@/views/home/personalInfo/ChangeName')
const ChangeAge = () => import('@/views/home/personalInfo/ChangeAge')
const MoreInfo = () => import('@/views/home/personalInfo/MoreInfo')
const MyAddress = () => import('@/views/home/personalInfo/MyAddress')
const AddressDetail = () => import('@/views/home/personalInfo/AddressDetail')
const MyPublish = () => import('@/views/home/manage/MyPublish')
const PublishEdit = () => import('@/views/home/manage/PublishEdit')
const MySell = () => import('@/views/home/manage/MySell')
const MyBuy = () => import('@/views/home/manage/MyBuy')
const Favorite = () => import('@/views/home/manage/Favorite')
const PersonalData = () => import('@/views/home/manage/PersonalData')
const ConfirmOrder = () => import('@/views/home/manage/ConfirmOrder')
const MyComment = () => import('@/views/home/content/MyComment')
const GoodsFollow = () => import('@/views/home/content/GoodsFollow')
const SellerFollow = () => import('@/views/home/content/SellerFollow')
const SeeHistory = () => import('@/views/home/content/SeeHistory')
const Activity = () => import('@/views/home/content/Activity')
const ServiceCenter = () => import('@/views/home/content/ServiceCenter')
const FeedBack = () => import('@/views/home/content/FeedBack')
const Rule = () => import('@/views/home/content/Rule')
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/search',
      name: 'search',
      component: Search
    },
    {
      path: '/car',
      name: 'car',
      component: Car
    },
    {
      path: '/home',
      name: 'home',
      component: Home
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/register',
      name: 'register',
      component: Register
    },
    {
      path: '/goodsdetail',
      name: 'goodsdetail',
      component: GoodsDetail
    },
    {
      path: '/searchlist',
      name: 'searchlist',
      component: SearchList
    },
    {
      path: '/personal',
      name: 'personal',
      component: Personal
    },
    {
      path: '/changename',
      name: 'changename',
      component: ChangeName
    },
    {
      path: '/changeage',
      name: 'changeage',
      component: ChangeAge
    },
    {
      path: '/moreinfo',
      name: 'moreinfo',
      component: MoreInfo
    },
    {
      path: '/myaddress',
      name: 'myaddress',
      component: MyAddress
    },
    {
      path: '/addressdetail',
      name: 'addressdetail',
      component: AddressDetail
    },
    {
      path: '/mypublish',
      name: 'mypublish',
      component: MyPublish
    },
    {
      path: '/publishedit',
      name: 'publishedit',
      component: PublishEdit
    },
    {
      path: '/mysell',
      name: 'mysell',
      component: MySell
    },
    {
      path: '/mybuy',
      name: 'mybuy',
      component: MyBuy
    },
    {
      path: '/favorite',
      name: 'favorite',
      component: Favorite
    },
    {
      path: '/personaldata',
      name: 'personaldata',
      component: PersonalData
    },
    {
      path: '/confirmorder',
      name: 'confirmorder',
      component: ConfirmOrder
    },
    {
      path: '/mycomment',
      name: 'mycomment',
      component: MyComment
    },
    {
      path: '/goodsfollow',
      name: 'goodsfollow',
      component: GoodsFollow
    },
    {
      path: '/sellerfollow',
      name: 'sellerfollow',
      component: SellerFollow
    },
    {
      path: '/seehistory',
      name: 'seehistory',
      component: SeeHistory
    },
    {
      path: '/activity',
      name: 'activity',
      component: Activity
    },
    {
      path: '/servicecenter',
      name: 'servicecenter',
      component: ServiceCenter
    },
    {
      path: '/feedback',
      name: 'feedback',
      component: FeedBack
    },
    {
      path: '/rule',
      name: 'rule',
      component: Rule
    }
  ]
})
