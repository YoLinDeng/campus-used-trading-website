<template>
  <div class="index"
       id="app">
    <el-container>
      <el-header>
        <div class="top">
          <div class="l">
            <img src="../assets/img/GDPU.jpg"
                 alt="">
            <span>欢迎您！管理员： {{name}}</span>
          </div>
          <div class="r">
            <el-dropdown>
              <span class="el-dropdown-link">
                语言<i class="el-icon-arrow-down el-icon--right"></i>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item>中文</el-dropdown-item>
                <el-dropdown-item>English</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
            <div class="exit">
              <router-link tag="i"
                           class="el-icon-mobile-phone"
                           to="luckywheel"></router-link>
              <i class="el-icon-circle-close"
                 @click="logout"></i>
            </div>
          </div>
        </div>
      </el-header>
      <el-container class="main">
        <el-aside width="200px">
          <el-menu :default-active="$route.path"
                   class="el-menu-vertical-demo"
                   @open="handleOpen"
                   @close="handleClose"
                   background-color="#545c64"
                   text-color="#fff"
                   active-text-color="#ffd04b"
                   router>
            <el-menu-item index="/home">
              <i class="el-icon-menu"></i>
              <span slot="title">管理员信息管理</span>
            </el-menu-item>
            <el-menu-item index="/usermanager">
              <i class="el-icon-mobile-phone"></i>
              <span slot="title">用户管理</span>
            </el-menu-item>
            <el-menu-item index="/merchantmanager">
              <i class="el-icon-goods"></i>
              <span slot="title">发布商品审核</span>
            </el-menu-item>
            <el-menu-item index="/trademanager">
              <i class="el-icon-sold-out"></i>
              <span slot="title">订单管理</span>
            </el-menu-item>
            <el-menu-item index="/reportmanager">
              <i class="el-icon-document"></i>
              <span slot="title">商品管理</span>
            </el-menu-item>
            <el-menu-item index="/settlemanager">
              <i class="el-icon-printer"></i>
              <span slot="title">评论管理</span>
            </el-menu-item>
          </el-menu>
        </el-aside>
        <el-main>
          <!--主窗口-->
          <router-view></router-view>
        </el-main>
      </el-container>
      <el-footer>
        <el-tag type="info">关于我们</el-tag>
        <el-tag type="info">联系我们</el-tag>
        <el-tag type="info">隐私政策</el-tag>
        <el-tag type="info">服务条款</el-tag>
      </el-footer>
    </el-container>

  </div>
</template>

<script>
export default {
  name: "index",
  data () {
    return {
      msg: 'hello',
      name: localStorage.getItem('name')

    }
  },
  methods: {
    handleOpen (key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose (key, keyPath) {
      console.log(key, keyPath);
    },
    //退出登录
    logout: function () {
      var _this = this;
      this.$confirm('确认退出吗?', '提示', {
        //type: 'warning'
      }).then(() => {
        localStorage.clear()
        _this.$router.push('/login');
      }).catch(() => {

      });
    },
  },
  components: {
  }
}
</script>

<style lang="scss">
.el-header {
  height: 60px !important;
  padding: 0;
  .top {
    background-color: #0091d7;
    height: 60px;
    padding: 0 40px;
    display: flex;
    justify-content: space-between;
    .l {
      line-height: 60px;
      img {
        width: 48px;
        height: 48px;
        vertical-align: middle;
        border-radius: 50%;
      }
      span {
        margin-left: 10px;
        color: #fff;
        font-size: 16px;
      }
    }
    .r {
      .el-dropdown {
        margin-top: 19px;
        color: white;
      }
      .exit {
        display: inline-block;
        line-height: 60px;
        margin-left: 20px;
        font-size: 24px;
        i {
          margin-right: 10px;
          cursor: pointer;
          color: white;
        }
      }
    }
  }
}

.main {
  width: 100%;
}

.pag {
  background-color: #f2f2f2;
  padding: 10px;
  margin: 10px 0px;
}

.panel .panel-title {
  color: #535351;
  height: 45px;
  line-height: 45px;
  font-size: 14px;
  font-weight: bold;
  text-transform: uppercase;
  border-bottom: 1px dotted rgba(0, 0, 0, 0.2);
}

.fl {
  float: left;
}
.fr {
  float: right;
}

.el-menu {
  background-color: #d3dce6;
  color: #48576a;
  .el-menu-item.is-active {
    border-right: 4px solid #20a0ff;
    color: #20a0ff;
  }
}

.el-aside {
  color: #333;
  line-height: 200px;
  background: rgb(84, 92, 100);
}

.el-main {
  background-color: #fff;
  color: #48576a;
  text-align: left;
}

.el-footer {
  width: 100%;
  margin-top: 190px;
  background-color: #fff;
  line-height: 60px;
  text-align: center;
}
</style>
