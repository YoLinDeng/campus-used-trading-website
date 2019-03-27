<template>
  <section class="user-manager">
    <el-table :data="tableData"
              style="width: 100%">
      <!--展开行-->
      <el-table-column type="expand">
        <template slot-scope="props">
          <el-form label-position="left"
                   inline
                   class="demo-table-expand">
            <el-form-item label="用户ID">
              <span>{{ props.row.uid }}</span>
            </el-form-item>
            <el-form-item label="用户昵称">
              <span>{{ props.row.userName }}</span>
            </el-form-item>
            <el-form-item label="用户邮箱">
              <span>{{ props.row.email }}</span>
            </el-form-item>
            <el-form-item label="联系方式">
              <span>{{ props.row.telNum }}</span>
            </el-form-item>
            <el-form-item label="年龄">
              <span>{{ props.row.age }}</span>
            </el-form-item>
            <el-form-item label="注册时间">
              <span>{{ props.row.regTime }}</span>
            </el-form-item>
            <el-form-item label="粉丝数">
              <span>{{ props.row.fansNum }}</span>
            </el-form-item>
            <el-form-item label="关注数">
              <span>{{ props.row.followNum }}</span>
            </el-form-item>
          </el-form>
        </template>
      </el-table-column>
      <el-table-column label="用户ID"
                       prop="uid">
      </el-table-column>
      <el-table-column label="用户昵称"
                       prop="userName">
      </el-table-column>
      <el-table-column label="创建时间"
                       prop="regTime">
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="props">
          <el-button size="mini"
                     @click="handleEdit(props.$index, props.row)">编辑
          </el-button>
          <el-button size="mini"
                     type="danger"
                     @click="handleDelete(props.$index, props.row)">删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <!--工具条-->
    <el-col :span="24"
            class="pag">
      <el-pagination @size-change="handleSizeChange"
                     @current-change="handleCurrentChange"
                     :current-page.sync="listQuery.curPage"
                     :page-sizes="[10,20,30,50]"
                     :page-size="listQuery.pageSize"
                     layout="total, sizes, prev, pager, next, jumper"
                     :total="total"
                     style="float: right;">
      </el-pagination>
    </el-col>
    <!--编辑-->
    <el-dialog title="编辑用户信息"
               :visible.sync="dialogFormVisible">
      <el-form :model="editForm"
               ref="editForm">
        <el-form-item label="用户昵称"
                      :label-width="formLabelWidth">
          <el-input v-model="editForm.userName"
                    autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="联系方式"
                      :label-width="formLabelWidth">
          <el-input v-model="editForm.telNum"
                    autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="邮箱地址"
                      :label-width="formLabelWidth">
          <el-input v-model="editForm.email"
                    autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer"
           class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary"
                   @click="editSubmit"
                   :loading="loading">确 定</el-button>
      </div>
    </el-dialog>
  </section>
</template>

<script>
export default {
  name: "usermanager",
  data () {
    return {
      tableData: [],
      dialogFormVisible: false,
      editForm: {
        userName: '',
        telNum: '',
        email: '',
        uid: ''
      },
      formLabelWidth: '100px',
      loading: false,
      total: 0,
      listQuery: {
        curPage: 1,
        pageSize: 10,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: '+id'
      },
    }
  },
  created () {
    let page = this.listQuery.curPage
    let pageSize = this.listQuery.pageSize
    API.getAllUserInfo({ page, pageSize }).then(res => {
      console.log(res)
      this.tableData = res.data
      this.total = res.total
    }).catch(_ => {
      console.log(_)
    })

  },
  methods: {
    handleEdit (index, row) {
      this.dialogFormVisible = true;
      this.editForm = Object.assign({}, row);
    },
    handleDelete (index, row) {
      this.$confirm('确定删除该用户, 是否继续?', '提示', {
        type: 'warning'
      }).then(() => {
        API.deleteUser({ uid: row.uid }).then(res => {
          console.log(res)
          this.tableData = res.data
          this.total = this.tableData.length;
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        }).catch(_ => {
          this.tableData = res.data
          this.$message({
            type: 'success',
            message: '删除失败!'
          });
        })
      }).catch(() => {
      });
    },
    editSubmit () {
      this.$refs.editForm.validate((valid) => {
        if (valid) {
          this.$confirm('确认提交吗？', '提示', {}).then(() => {
            this.loading = true
            let userName = this.editForm.userName
            let telNum = this.editForm.telNum
            let email = this.editForm.email
            let uid = this.editForm.uid
            API.updateUserInfo({ userName, telNum, email, uid }).then(res => {
              console.log(res)
              setTimeout(() => {
                this.loading = false
                this.$message({
                  message: '提交成功',
                  type: 'success'
                });
                this.dialogFormVisible = false;
              }, 1000)
            }).catch(_ => {
              console.log(_)
            })

          });
        } else {
          console.log('error submit')
          return false;
        }
      })
    },
    //操作分页
    handleSizeChange (val) {
      this.listQuery.pageSize = val;
      let page = this.listQuery.curPage
      let pageSize = val
      API.getAllUserInfo({ page, pageSize }).then(res => {
        this.tableData = res.data
      }).catch(_ => {
        console.log(_)
      })
    },
    handleCurrentChange (val) {
      this.listQuery.curPage = val;
      let page = val
      let pageSize = this.listQuery.pageSize
      API.getAllUserInfo({ page, pageSize }).then(res => {
        this.tableData = res.data
      }).catch(_ => {
        console.log(_)
      })
    }
  }
}
</script>

<style scoped>
.demo-table-expand {
  font-size: 0;
}

.demo-table-expand label {
  width: 90px;
  color: #99a9bf;
}

.demo-table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 50%;
}
</style>
