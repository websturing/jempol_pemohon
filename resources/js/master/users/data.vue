<template>
    <div class="row">
        <div class="col-md-12">
            <el-table v-loading="table.isLoading"
                :data="table.data.filter(data => 
                        !table.search || data.username.toLowerCase().includes(table.search.toLowerCase()) 
                        || data.group_acl.nama.toLowerCase().includes(table.search.toLowerCase())
                        || data.opd.opd.toLowerCase().includes(table.search.toLowerCase())
                        )"
                style="width: 100%">
                 <el-table-column type="index" width="50"></el-table-column>
                <el-table-column prop="username" label="Username" width="140"></el-table-column>
                <el-table-column prop="group_acl.nama" label="Role" width="120"></el-table-column>
                <el-table-column prop="opd.opd" label="Organisasi Perangkat Daerah"></el-table-column>
                <el-table-column prop="is_active" label="Active" width="100">
                    <template slot-scope="scope">
                        <el-tag
                        :type="scope.row.is_active === 'true' ? 'success' : 'danger'"
                        disable-transitions>{{scope.row.is_active}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column  width="200"
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
        }
    },
    mounted() {
        console.log('User Data mounted.')
        this.GetData()
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods:{
        notif(s,m,type){
            this.$notify({
                title: s,
                message: m,
                type: type
            });
        },
        GetData(){
            this.table.isLoading = true
            this.table.data = []
            axios
                .post(urlBase.urlWeb+'/master/users',{
                    type : "dataAll"
                })
                .then(r => (
                    this.table.data = r.data,
                    this.table.isLoading = false,
                    console.log(this.table.data)
                ));
        },
        edit(index,row){
             axios
                .post(urlBase.urlWeb+'/master/aclGroup',{
                    type : "putsession",
                    aclGroup_id : row.aclGroup_id
                })
                .then(r => (
                    this.$emit('ChildFormUser',row)
                ));
        },
        deleteTable(index,row) {
            this.$confirm('hapus Data ini ?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning'
            }).then(() => {
                axios
                .post(urlBase.urlWeb+'/master/users',{
                    type : "hapus",
                    id : row.user_id
                })
                .then(r => (
                    this.GetData(),
                    this.notif(r.data.title, r.data.message,r.data.type)
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