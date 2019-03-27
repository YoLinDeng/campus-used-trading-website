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
          <el-col :span="12">
            <el-form-item label="用户id">
              <el-input v-model="search.uid"
                        placeholder="用户id"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="商品id">
              <el-input v-model="search.goodsId"
                        placeholder="商品id"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="审核状态">
              <!--<el-dropdown trigger="click" @command="handleCommand">-->
              <!--<span class="el-dropdown-link">-->
              <!--审核状态<i class="el-icon-arrow-down el-icon&#45;&#45;right"></i>-->
              <!--</span>-->
              <!--<el-dropdown-menu slot="dropdown">-->
              <!--<el-dropdown-item command="1">等待审核</el-dropdown-item>-->
              <!--<el-dropdown-item command="2">审核通过</el-dropdown-item>-->
              <!--<el-dropdown-item command="3">审核拒绝</el-dropdown-item>-->
              <!--</el-dropdown-menu>-->
              <!--</el-dropdown>-->
              <el-select v-model="search.status"
                         placeholder="审核状态">
                <el-option label="未审核"
                           value="0"></el-option>
                <el-option label="审核通过"
                           value="1"></el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="24">
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
      <el-table-column property="goodsId"
                       label="商品编号"
                       width="200">
      </el-table-column>
      <el-table-column property="title"
                       label="商品标题"
                       width="120">
      </el-table-column>
      <el-table-column property="postTime"
                       label="发布时间">
      </el-table-column>
      <el-table-column property="status"
                       label="审核状态">
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button size="mini"
                     v-if="scope.row.status === '未审核'"
                     @click="handleEdit(scope.$index, scope.row)">审核通过</el-button>
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
    let uid = this.search.uid
    let goodsId = this.search.goodsId
    let status = this.search.status
    let page = this.listQuery.curPage
    let pageSize = this.listQuery.pageSize
    API.getAllGoods({ uid, goodsId, status, page, pageSize }).then(res => {
      let data = res.data
      data.forEach(item => {
        item.status = item.status === 0 ? '未审核' : '审核通过'
      })
      this.tableData = data
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
    handleEdit (index, row) {
      this.$confirm('确定审核通过该商品吗?', '提示', {
        type: 'warning'
      }).then(() => {
        API.confirmGoods({ goodsId: row.goodsId }).then(res => {
          let data = res.data
          data.forEach(item => {
            item.status = item.status === 0 ? '未审核' : '审核通过'
          })
          this.tableData = res.data
          this.total = this.tableData.length
          this.$message({
            type: 'success',
            message: '操作成功'
          })
        }).catch(res => {
          let data = res.data
          data.forEach(item => {
            item.status = item.status === 0 ? '未审核' : '审核通过'
          })
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
    getGoodsList () {
      let uid = this.search.uid
      let goodsId = this.search.goodsId
      let status = this.search.status
      let page = this.listQuery.curPage
      let pageSize = this.listQuery.pageSize
      API.getAllGoods({ uid, goodsId, status, page, pageSize }).then(res => {
        let data = res.data
        data.forEach(item => {
          item.status = item.status === 0 ? '未审核' : '审核通过'
        })
        this.tableData = data
        this.total = this.tableData.length
      }).catch(res => {
        this.tableData = res.data
        this.total = this.tableData.length
      })
    },
    searchList () {
      this.getGoodsList()
    },
    //操作分页
    handleSizeChange (val) {
      this.listQuery.pageSize = val;
      this.getGoodsList()
    },
    handleCurrentChange (val) {
      this.listQuery.curPage = val;
      let uid = this.search.uid
      let goodsId = this.search.goodsId
      let status = this.search.status
      let page = this.listQuery.curPage
      let pageSize = this.listQuery.pageSize
      API.getAllGoods({ uid, goodsId, status, page, pageSize }).then(res => {
        let data = res.data
        data.forEach(item => {
          item.status = item.status === 0 ? '未审核' : '审核通过'
        })
        this.tableData = data
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
