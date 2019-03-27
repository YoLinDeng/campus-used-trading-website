<template>
  <div class="edit-wrapper">
    <app-header title="发布宝贝"
                back></app-header>
    <div class="top">
      <div class="add-img"
           @click="addImg">
        <img src="@/assets/images/add-img.png"
             alt="">
        <span>添加照片</span>
      </div>
      <input type="file"
             ref="file"
             :accept="accept"
             @change="fileChange">
      <img :src="goodsImg"
           alt=""
           class="img-item">
    </div>
    <div class="desc">
      <div class="title">
        <input type="text"
               placeholder="宝贝标题 品牌型号不可少"
               class="input-title"
               v-model="title">
      </div>
      <div class="desc-content">
        <textarea class="text-desc"
                  cols="30"
                  rows="10"
                  placeholder="在这里详细描述一下宝贝的转手原因、入手渠道、规格尺寸、新旧程度、和使用感受等吧。"
                  v-model="desc">
        </textarea>
        <mt-switch v-model="value"
                   class="switch">全新宝贝</mt-switch>
      </div>
    </div>
    <div class="bottom">
      <mt-cell title="分类"
               is-link
               v-model="classifyValue"
               class="classify"
               @click.native="selectClassify">
      </mt-cell>
      <mt-cell title="价格"
               is-link
               v-model="priceValue"
               class="price"
               @touchstart.native.stop="keyShow = true">
      </mt-cell>
    </div>
    <div class="picker-div"
         v-if="isShowPicker">
      <mt-picker :slots="slots"
                 @change="onValuesChange"
                 class="content"></mt-picker>
      <mt-button type="primary"
                 class="confirm"
                 @click.native="closePicker">确定</mt-button>
    </div>
    <!-- 键盘 -->
    <van-number-keyboard :show="keyShow"
                         extra-key="."
                         close-button-text="完成"
                         @blur="keyShow = false"
                         @input="onInput"
                         @delete="onDelete" />
    <div class="picker-model"
         v-if="isShowPicker"
         @click="closePicker">
    </div>
    <mt-button type="primary"
               class="publish"
               @click="publish">发布</mt-button>
  </div>
</template>

<script>
import Vue from 'vue'
import AppHeader from '@/components/AppHeader'
import { Picker, Cell, Button, MessageBox, Toast, Switch } from 'mint-ui'
import { NumberKeyboard } from 'vant'
Vue.component(Picker.name, Picker)
Vue.component(Switch.name, Switch)
export default {
  components: {
    AppHeader,
    Cell,
    Button,
    Toast,
    NumberKeyboard
  },
  props: {},
  data () {
    return {
      goodsImg: '',
      title: '',
      desc: '',
      slots: [
        {
          flex: 1,
          values: ['电脑数码', '运动户外', '服饰鞋包', '书籍', '日用品'],
          className: 'slot1',
          textAlign: 'center'
        }
      ],
      isShowPicker: false,
      classifyValue: '电脑数码',
      priceValue: '￥',
      accept: 'image/*',
      maxSize: 3000000, // (单位:b = 字节, 1mb = 1024000b)
      value: false,
      keyShow: false
    }
  },
  computed: {},
  created () {
    let uid = localStorage.getItem('uid')
    if (!uid) {
      MessageBox.alert('登录后才能发布商品哦~').then(action => {
        this.$router.push({ path: '/login' })
      })

    }
  },
  methods: {
    onValuesChange (picker, values) {
      this.classifyValue = picker.getValues()[0]
      console.log(this.classifyValue)
    },
    selectClassify () {
      this.isShowPicker = true
    },
    closePicker () {
      this.isShowPicker = false
    },
    writePrice () {
      MessageBox.prompt('请填写宝贝价格').then(({ value, action }) => {
        let reg = /^[0-9]*$/
        console.log(value)
        if (action === 'confirm') {
          if (reg.test(value)) {
            this.priceValue = '￥' + value
          } else {
            Toast('请输入数字')
          }
        }
      })
    },
    publish () {
      MessageBox.confirm('确定要发布吗?').then(action => {
        const uid = localStorage.getItem('uid')
        const type = this.switchType()
        const title = this.title
        const status = 0
        const price = this.priceValue.substr(1)
        const imgUrl = this.goodsImg
        const desc = this.desc
        const newLevel = this.value === false ? 1 : 0
        const lookNum = 0
        const likeNum = 0
        const params = {
          uid,
          type,
          title,
          price,
          status,
          imgUrl,
          desc,
          newLevel,
          lookNum,
          likeNum
        }
        if (action === 'confirm') {
          API.publishGoods(params).then(res => {
            Toast('发布成功,请耐心等待审核')
          }).catch(_ => {
            Toast('发布失败')
          })
          this.$router.push({ path: '/home' })
        }
      }).catch(_ => {
      })
    },
    // 转换类型
    switchType () {
      let type = this.classifyValue
      if (type === '电脑数码') {
        return 1
      }
      if (type === '运动户外') {
        return 2
      }
      if (type === '服饰鞋包') {
        return 3
      }
      if (type === '书籍') {
        return 4
      }
      if (type === '日用品') {
        return 5
      }
    },
    addImg () {
      this.$refs.file.click()
    },
    fileChange (e) {
      let file = e.target.files[0]
      if (file.size > this.maxSize) {
        MessageBox('提示', '图片太大了噢')
      } else {
        let formData = new FormData()
        formData.append('img', file)
        API.upload(formData).then(res => {
          console.log(res)
          let host = 'http://www.deng.com'
          this.goodsImg = host + res.path
        })
      }
    },
    onInput (value) {
      this.priceValue = this.priceValue + value
      Toast('价格为' + this.priceValue)
    },
    onDelete () {
      if (this.priceValue !== '￥') {
        this.priceValue = this.priceValue.substring(0, this.priceValue.length - 1)
      }

      Toast('价格为' + this.priceValue)
    }
  }
}
</script>
<style lang="scss" scoped>
.edit-wrapper {
  position: relative;
  .top {
    height: 2.5rem;
    background: #fff;
    border: 1px solid transparent;
    .add-img {
      width: 20vw;
      height: 20vw;
      background: #d1d1d1;
      border-radius: 0.1rem;
      margin-left: 0.3rem;
      margin-top: 0.25rem;
      position: relative;
      display: inline-block;
      span {
        font-size: 0.4rem;
        position: absolute;
        left: 12%;
        top: 66%;
      }
      img {
        width: 15vw;
        height: 15vw;
        display: block;
        margin: 0 auto;
      }
    }
    .img-item {
      width: 20vw;
      height: 20vw;
      border-radius: 0.1rem;
      margin-left: 0.3rem;
      margin-top: 0.25rem;
      display: inline-block;
    }
  }
  .desc {
    background: #fff;
    margin-top: 0.3rem;
    border: 1px solid transparent;
    .title {
      font-size: 0.45rem;
      font-weight: bold;
      margin-left: 0.5rem;
      margin-top: 0.3rem;
      margin-bottom: 0.1rem;
      .input-title {
        border: none;
        outline: none;
        font-size: 0.45rem;
      }
    }
    .desc-content {
      position: relative;
      height: 6rem;
      .text-desc {
        border: none;
        outline: none;
        width: 90%;
        height: 4rem;
        display: block;
        margin: 0 auto;
        font-size: 0.4rem;
      }
      .switch {
        position: absolute;
        right: 2%;
        bottom: 1%;
        font-size: 0.4rem;
        font-weight: bold;
      }
    }
  }
  .bottom {
    margin-top: 0.3rem;
    background: #fff;
  }
}
.picker-div {
  width: 100%;
  position: absolute;
  left: 0;
  top: 50%;
  .content {
    width: 80%;
    margin-left: 10%;
    background: #fff;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
  }
  .confirm {
    width: 80%;
    position: absolute;
    left: 10%;
    bottom: 0;
    z-index: 1;
  }
}

.picker-model {
  position: fixed;
  left: 0;
  top: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.3);
}
.publish {
  position: fixed;
  bottom: 0;
  width: 100%;
  display: inline-block;
  z-index: -1;
}
input[type="file"] {
  display: none;
}
</style>
