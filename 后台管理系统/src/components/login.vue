<template>
  <div class="login">
    <header class="header">
      <div class="logo">
        <img src="../assets/img/GDPU.jpg"
             alt="logo">
        <span>{{logo_title}}</span>
      </div>
    </header>
    <!--container布局容器-->
    <el-container>
      <el-main>
        <div class="login-part">
          <el-form :model="ruleForm"
                   :rules="rules"
                   ref="ruleForm">
            <h4>管理员登录</h4>
            <el-form-item label=""
                          prop="name">
              <el-input v-model="ruleForm.name"
                        placeholder="您的登录名"></el-input>
            </el-form-item>
            <el-form-item label=""
                          prop="pwd">
              <el-input v-model="ruleForm.pwd"
                        placeholder="请输入登录密码"
                        type="password"></el-input>
            </el-form-item>
            <el-form-item label=""
                          class="remember-me">
              <el-checkbox v-model="ruleForm.rememberMe">记住我</el-checkbox>
            </el-form-item>
            <el-form-item>
              <el-button type="primary large"
                         @click="submitForm('ruleForm')"
                         class="login-btn"
                         :loading="loading">登录</el-button>
            </el-form-item>
          </el-form>
        </div>
      </el-main>
    </el-container>
  </div>
</template>

<script>
export default {
  name: 'login',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App',
      loading: false,
      logo_title: '校园二手交易网站后台管理系统',
      ruleForm: {
        name: '',
        pwd: '',
        rememberMe: false
      },
      rules: {
        name: [
          { required: true, message: '请输入您的登录名', trigger: 'blur' },
          { min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur' }
        ],
        pwd: [
          { required: true, message: '请输入登录密码', trigger: 'blur' },
          { min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur' }
        ],
      },
    }
  },
  methods: {
    // 登录验证
    submitForm (formName) {
      this.$refs[formName].validate((valid) => {
        this.loading = true;
        setTimeout(() => {
          this.loading = false;
          if (valid) {
            let name = this.ruleForm.name
            let password = this.ruleForm.pwd
            // 登录接口
            API.login({ name, password }).then(res => {
              this.$router.push({ path: '/home' })
              localStorage.setItem('name', name)
            }).catch(_ => {
              this.$message({
                type: 'info',
                message: '账号或密码错误'
              });
            })
          } else {
            console.log('error submit')
            return false;
          }
        }, 800);
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
.header {
  width: 100%;
  height: 95px;
  display: flex;
  padding: 5px;
  margin: 0 auto;
  justify-content: space-between;
  .logo {
    line-height: 95px;
    margin-left: 5%;
    img {
      vertical-align: middle;
      width: 100px;
    }
    span {
      margin-left: 10px;
      color: #0091d7;
      font-size: 20px;
    }
  }
  .language {
    .el-dropdown {
      margin-top: 39px;
    }
  }
}

.el-header {
  background-color: #0091d7;
}

.el-main {
  position: relative;
  width: 100%;
  margin: 0 auto;
  height: 600px;
  background: url(../assets/img/login_pic.png) no-repeat;
  background-size: cover;
  .login-part {
    position: absolute;
    left: 50%;
    top: 35%;
    margin: -193px 0 0 -143px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 5px;
    padding: 20px 30px;
    h4 {
      font-size: 18px;
      color: #696969;
    }
    .remember-me {
      margin-bottom: 0;
    }
    .login-btn {
      width: 240px;
    }
  }
}
</style>
