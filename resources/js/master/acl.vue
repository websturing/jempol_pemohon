<template>
    <div class="row">
        <div class="col-md-12">
            <button type="button" @click="Form()">Tambah Data</button>
            <aclGroup v-show="show.data"></aclGroup>

            <div class="formD" v-show="show.form">
                <div class="card">
                    <div class="card-body">
                        <el-form :model="aclGroup" ref="modul">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Nama Modul</label>
                                    <el-form-item 
                                        prop="nama"
                                        :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                        <el-input
                                            placeholder="Nama Modul"
                                            v-model="aclGroup.nama"
                                            clearable>
                                        </el-input>
                                    </el-form-item>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Active Modul</label> <br/>
                                    <el-tooltip :content="'Group active'" placement="top">
                                        <el-switch
                                            v-model="aclGroup.is_active"
                                            active-color="#13ce66"
                                            inactive-color="#ff4949"
                                            active-value="true"
                                            inactive-value="false">
                                        </el-switch>
                                    </el-tooltip>
                                </div>
                            </div>
                        </el-form>
                    </div>
                </div>
                <div class="card" v-loading="isLoading">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Access Control List</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <el-input
                                    placeholder="Cari data Modul"
                                    v-model="filterText">
                                </el-input>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="custom-tree-container">
                            <div class="block">
                                <el-tree
                                    :data="data" :props="defaultProps" @node-click="handleNodeClick"
                                    @check-change="handleNodeClick"
                                    :filter-node-method="filterNode"
                                    show-checkbox
                                    node-key="id"
                                    ref="tree"
                                    default-expand-all
                                    :expand-on-click-node="false">

                                    <span class="custom-tree-node" slot-scope="{ node, data }">
                                            <span>{{ node.label }}</span>

                                            <span v-show="data.type != 'parent'">
                                                    <el-checkbox v-model="data.crud.create">Create</el-checkbox>
                                                    <el-checkbox v-model="data.crud.read">Read</el-checkbox>
                                                    <el-checkbox v-model="data.crud.update">Update</el-checkbox>
                                                    <el-checkbox v-model="data.crud.delete">Delete</el-checkbox>
                                            </span>
                                    </span>
                                </el-tree>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-xs btn-primary" @click="Insert()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import urlBase from '@/js/url'
import aclGroup from '@/js/master/aclGroup'
export default {
    
    data(){
        return{
            show:{
                form : false,
                data : true
            },
            isLoading : false,
            filterText: '',
            data: [],
            defaultProps: {
                children: 'children',
                label: 'nama'
            },
            aclGroup:{
                nama : null,
                is_active : false,
                aclGroup_id : null

            }
        }
    },
    mounted() {
        console.log('acl mounted.')
        this.$parent.$data.activeLink = 'master';
        this.$parent.$data.activeName = 'Access Control List';
        this.GetModul()
    },
    watch: {
      filterText(val) {
        this.$refs.tree.filter(val);
      }
    },
    methods:{
        Form(){
            this.show.data = false,
            this.show.form = true

            this.aclGroup.aclGroup_id = null,
            this.aclGroup.nama = null,
            this.aclGroup.is_active = false
        },
        notif(s,m,type){
            this.$notify({
                title: s,
                message: m,
                type: type
            });
        },
        handleNodeClick(data) {
            console.log(data);
        },
        GetModul(){
            this.isLoading = true
            this.data = []
            axios
                .post(urlBase.urlWeb+'/master/acl',{
                    type : "AclData",
                    aclGroup : this.aclGroup
                })
                .then(r => (
                    this.data = r.data,
                    this.isLoading = false
                ));
        },
        filterNode(value, data) {
            if (!value) return true;
            return data.nama.indexOf(value) !== -1;
        },

        Insert(){
            // this.isLoading = true
            axios
                .post(urlBase.urlWeb+'/master/acl',{
                    type : "insert",
                    data : this.data,
                    aclGroup : this.aclGroup
                })
                .then(r => (
                    console.log(r.data),
                    this.isLoading = false,
                    this.GetModul(),
                    this.show.data = true,
                    this.show.form = false,

                    this.aclGroup.nama = null,
                    this.aclGroup.aclGroup_id = null,
                    this.aclGroup.is_active = false
                ));
        },

    },
    components:{
        aclGroup
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