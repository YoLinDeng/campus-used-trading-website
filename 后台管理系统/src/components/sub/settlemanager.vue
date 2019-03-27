<template>
  <section class="merchant-manager">
    <!--搜索内容表单-->
    <el-form ref="form"
             :model="form"
             @submit.prevent="onSubmit"
             style="margin-top: 10px">
      <el-form :inline="true"
               :model="search"
               class="demo-form-inline">
        <el-row>
          <el-col :span="10">
            <el-form-item label="用户id">
              <el-input v-model="search.uid"
                        placeholder="用户id"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="10">
            <el-form-item label="商品id">
              <el-input v-model="search.goodsId"
                        placeholder="商品id"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="1">
            <el-form-item>
              <el-button type="primary"
                         @click="searchList"
                         icon="search">查询</el-button>
            </el-form-item>
          </el-col>
        </el-row>
      </el-form>
    </el-form>
    <!--单选表格-->
    <el-table ref="singleTable"
              :data="tableData"
              highlight-current-row
              @current-change="handleCurrentChange"
              style="width: 100%">
      <el-table-column property="id"
                       label="评论编号"
                       width="200">
      </el-table-column>
      <el-table-column property="userName"
                       label="用户名"
                       width="120">
      </el-table-column>
      <el-table-column property="time"
                       label="评论时间">
      </el-table-column>
      <el-table-column property="content"
                       label="评论内容">
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button size="mini"
                     type="danger"
                     @click="handleEdit(scope.$index, scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-col :span="24"
            class="pag">
      <el-pagination @size-change="handleSizeChange"
                     @current-change="handleCurrentChange"
                     :current-page.sync="listQuery.curPage"
                     :page-sizes="[10,20,30,50]"
                     :page-size="listQuery.pageSize"
                     layout="total, sizes, prev, pager, next, jumper"
                     :total="total"
                     style="float: right">
      </el-pagination>
    </el-col>
  </section>
</template>

<script>
export default {
  name: "merchantmanager",
  data () {
    return {
      tableData: [],
      form: {},
      search: {
        uid: '',
        goodsId: '',
        c_time: '',
        status: ''
      },
      currentRow: null,
      total: 0,
      listQuery: {
        curPage: 1,
        pageSize: 10,
        importance: undefined,
        title: undefined,
        type: undefined,
        sort: '+id'
      }
    }
  },
  created () {
    let page = this.listQuery.curPage
    let pageSize = this.listQuery.pageSize
    API.getComment({ page, pageSize }).then(res => {
      this.tableData = res.data
      this.total = res.total
    }).catch(res => {
      this.tableData = res.data
      this.total = this.tableData.length
    })
  },
  methods: {
    setCurrent (row) {
      this.$refs.singleTable.setCurrentRow(row);
    },
    handleCurrentChange (val) {
      this.currentRow = val;
      console.log(`currentRow:${JSON.stringify(this.currentRow)}`)
    },
    handleCommand (command) {
      this.$message('click on item ' + command);
    },
    // 删除操作
    handleEdit (index, row) {
      this.$confirm('确定删除该评论吗?', '提示', {
        type: 'warning'
      }).then(() => {
        API.deleteComment({ id: row.id }).then(res => {
          this.tableData = res.data
          this.total = this.tableData.length
          this.$message({
            type: 'success',
            message: '操作成功'
          })
        }).catch(res => {
          this.tableData = res.data
          this.total = this.tableData.length
          this.$message({
            type: 'info',
            message: '操作失败'
          })
        })
      }).catch(() => {
      });
    },
    // 获得商品列表
    getCommentList () {
      let uid = this.search.uid
      let goodsId = this.search.goodsId
      let page = this.listQuery.curPage
      let pageSize = this.listQuery.pageSize
      API.getComment({ uid, goodsId, page, pageSize }).then(res => {
        this.tableData = res.data
        this.total = this.tableData.length
      }).catch(res => {
        this.tableData = res.data
        this.total = this.tableData.length
      })
    },
    searchList () {
      this.getCommentList()
    },
    //操作分页
    handleSizeChange (val) {
      this.listQuery.pageSize = val;
      this.getCommentList()
    },
    handleCurrentChange (val) {
      this.listQuery.curPage = val;
      let uid = this.search.uid
      let goodsId = this.search.goodsId
      let page = this.listQuery.curPage
      let pageSize = this.listQuery.pageSize
      API.getCommentList({ uid, goodsId, page, pageSize }).then(res => {
        this.tableData = res.data
        this.total = res.total
      }).catch(res => {
        this.tableData = res.data
        this.total = this.tableData.length
      })
    }
  }
}
</script>

<style scoped>
.el-dropdown {
  box-sizing: border-box;
  border-radius: 4px;
  border: 1px solid #dcdfe6;
  padding: 0 15px;
}
</style>
