<template>
    <div class="row">
        <div class="col-md-12">
            <el-table v-loading="table.isLoading"
                :data="table.data.filter(data => !table.search || data.nama.toLowerCase().includes(table.search.toLowerCase()))"
                style="width: 100%">
                 <el-table-column type="index" width="50"></el-table-column>
                <el-table-column prop="nama" label="Nama Role"></el-table-column>
                <el-table-column prop="is_active" label="Active">
                    <template slot-scope="scope">
                        <el-tag
                        :type="scope.row.is_active === 'true' ? 'success' : 'danger'"
                        disable-transitions>{{scope.row.is_active}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column
                        align="right">
                        <template slot="header" slot-scope="scope">
                            <el-input
                            v-model="table.search"
                            size="mini"
                            placeholder="Type to search"/>
                        </template>
                    <template slot-scope="scope">
                        <el-button size="mini" @click="edit(scope.$index, scope.row)">Ubah</el-button>
                        <el-button type="danger" size="mini" @click="deleteTable(scope.$index, scope.row)">Hapus</el-button>
                    </template>
                    </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
import urlBase from '@/js/url'
export default {
    
    data(){
        return{
            table :{
                data:[],
                isLoading : false,
                search : null
            },


            tableData: [{
            date: '2016-05-03',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }, {
            date: '2016-05-02',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }, {
            date: '2016-05-04',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }, {
            date: '2016-05-01',
            name: 'Tom',
            address: 'No. 189, Grove St, Los Angeles'
          }]
        }
    },
    mounted() {
        console.log('acl Group mounted.')
        this.GetModulGroup()
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods:{
        GetModulGroup(){
            this.table.isLoading = true
            this.table.data = []
            axios
                .post(urlBase.urlWeb+'/master/aclGroup',{
                    type : "dataAll"
                })
                .then(r => (
                    this.table.data = r.data,
                    this.table.isLoading = false
                ));
        },
        edit(index,row){
             axios
                .post(urlBase.urlWeb+'/master/aclGroup',{
                    type : "putsession",
                    aclGroup_id : row.aclGroup_id
                })
                .then(r => (
                    this.$parent.$data.aclGroup.nama = row.nama,
                    this.$parent.$data.aclGroup.is_active = row.is_active,
                    this.$parent.$data.aclGroup.aclGroup_id = row.aclGroup_id,
                    
                    this.$parent.$data.show.form = true,
                    this.$parent.$data.show.data = false,

                    this.GetModulGroup()
                ));
        },
        deleteTable(index,row) {
            this.$confirm('hapus Data ini ?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning'
            }).then(() => {
                axios
                .post(urlBase.urlWeb+'/master/aclGroup',{
                    type : "hapus",
                    aclId : row.aclGroup_id
                })
                .then(r => (
                    this.GetModulGroup()
                ));
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: 'Delete canceled'
                });          
            });
      }
    }
}
</script>
<style>
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 8px;
  }
</style>