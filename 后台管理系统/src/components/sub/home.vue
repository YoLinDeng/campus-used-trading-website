<template>
  <section class="user-manager">
    <el-button type="primary"
               @click="addManager"
               icon="search">新增管理员</el-button>
    <el-table :data="tableData"
              style="width: 100%">
      <el-table-column label="管理员ID"
                       prop="mid">
      </el-table-column>
      <el-table-column label="管理员昵称"
                       prop="name">
      </el-table-column>
      <el-table-column label="密码"
                       prop="password">
      </el-table-column>
      <el-table-column label="创建时间"
                       prop="creTime">
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
        <el-form-item label="管理员昵称"
                      :label-width="formLabelWidth">
          <el-input v-model="editForm.name"
                    autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="管理员密码"
                      :label-width="formLabelWidth">
          <el-input v-model="editForm.password"
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
    <!--新建管理员-->
    <el-dialog title="添加管理信息"
               :visible.sync="dialogFormVisible1">
      <el-form ref="editForm">
        <el-form-item label="管理员昵称"
                      :label-width="formLabelWidth">
          <el-input v-model="name"
                    autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="管理员密码"
                      :label-width="formLabelWidth">
          <el-input v-model="password"
                    autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer"
           class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary"
                   @click="editSubmit1"
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
      dialogFormVisible1: false,
      editForm: {},
      formLabelWidth: '100px',
      loading: false,
      total: 0,
      name: '',
      password: '',
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
    API.getManagerInfo({ page, pageSize }).then(res => {
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
        let page = this.listQuery.curPage
        let pageSize = this.listQuery.pageSize
        let mid = row.mid
        API.deleteManager({ mid, page, pageSize }).then(res => {
          console.log(res)
          this.tableData = res.data
          this.total = res.total
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        }).catch(_ => {
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
            let page = this.listQuery.curPage
            let pageSize = this.listQuery.pageSize
            let name = this.editForm.name
            let password = this.editForm.password
            let mid = this.editForm.mid
            API.updateManagerInfo({ page, pageSize, name, password, mid }).then(res => {
              this.tableData = res.data
              this.total = this.tableData.length
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
      API.getManagerInfo({ page, pageSize }).then(res => {
        this.tableData = res.data
      }).catch(_ => {
        console.log(_)
      })
    },
    handleCurrentChange (val) {
      this.listQuery.curPage = val;
      let page = val
      let pageSize = this.listQuery.pageSize
      API.getManagerInfo({ page, pageSize }).then(res => {
        this.tableData = res.data
      }).catch(_ => {
        console.log(_)
      })
    },
    // 添加管理员
    addManager () {
      this.dialogFormVisible1 = true;
    },
    editSubmit1 () {
      if (this.name === '' || this.password === '') {
        this.$message({
          message: '管理员名和密码不能为空',
          type: 'info'
        })
      } else {
        let page = this.listQuery.curPage
        let pageSize = this.listQuery.pageSize
        let name = this.name
        let password = this.password
        API.addManager({ page, pageSize, name, password }).then(res => {
          this.tableData = res.data
          this.total = res.total
          this.$message({
            message: '添加成功',
            type: 'success'
          })
          this.dialogFormVisible1 = false;
        }).catch(_ => {
          this.$message({
            message: '添加失败',
            type: 'info'
          })
          this.dialogFormVisible1 = false;
        })
      }

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
