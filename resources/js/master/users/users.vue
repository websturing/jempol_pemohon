<template>
    <div class="row">
        <div class="col-md-12">
             <el-tabs :tab-position="'top'" v-model="activeTabName">
                <el-tab-pane label="Tambah Users" name="first">
                    <UsersForm 
                        ref="formUsers"
                        v-on:changeTabName="changeTabName"
                        v-on:UpdateData="ChildDataUsers"
                        ></UsersForm>
                </el-tab-pane>
                <el-tab-pane label="Data Users" name="second">
                    <UsersData 
                        ref="dataUsers"
                        v-on:ChildFormUser="ChildFormUser"
                    ></UsersData>
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>
</template>

<script>
import urlBase from '@/js/url'
import UsersData from '@/js/master/users/data'
import UsersForm from '@/js/master/users/form'
export default {
    
    data(){
        return{
            show:{
                form : false,
                data : true
            },
            isLoading : false,
            filterText: '',
            activeTabName : "second" 

        }
    },
    mounted() {
        console.log('acl mounted.')
        this.$parent.$data.activeLink = 'master';
        this.$parent.$data.activeName = 'users';
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods:{
        changeTabName(i){
            this.activeTabName = i
        },
        ChildDataUsers(){
            this.$refs.dataUsers.GetData()
        },
        ChildFormUser(row){
            this.activeTabName ="first"
            this.$refs.formUsers.type = "update"

            this.$refs.formUsers.form.user_id = row.user_id
            this.$refs.formUsers.form.username = row.username
            this.$refs.formUsers.form.aclGroup_id = row.group_acl.aclGroup_id
            this.$refs.formUsers.form.opd_id = row.opd.opd_id
            this.$refs.formUsers.form.is_active = row.is_active
        }
    },
    components:{
        UsersData,
        UsersForm
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