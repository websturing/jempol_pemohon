<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <el-form :model="form" ref="usersForm">
                        <div class="row">
                            <div class="col-md-4">
                                <el-form-item 
                                    prop="username"
                                    label="username"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                    <el-input
                                        placeholder="Username"
                                        v-model="form.username"
                                        :autofocus="true"
                                        :disabled="form.disabled"
                                        clearable>
                                    </el-input>
                                </el-form-item>
                            </div>
                            <div class="col-md-2">
                                <el-form-item 
                                    prop="aclGroup_id"
                                    label="Role"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'change' }">
                                    <el-select v-model="form.aclGroup_id" placeholder="Role Users" filterable  :disabled="form.disabled">
                                        <el-option
                                            v-for="item in aclGroup"
                                            :key="item.aclGroup_id"
                                            :label="item.nama"
                                            :value="item.aclGroup_id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </div>
                            <div class="col-md-3">
                                <el-form-item 
                                    prop="opd_id"
                                    label="Organisasi Perangkat Daerah"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'change' }">
                                    <el-select v-model="form.opd_id" placeholder="Organisasi Perangkat Daerah" filterable :disabled="form.disabled">
                                        <el-option
                                            v-for="item in opd"
                                            :key="item.opd_id"
                                            :label="item.opd"
                                            :value="item.opd_id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </div>
                            <div class="form-group col-md-2">
                                <br/>
                                    <label>Active</label> <br/>
                                    <el-tooltip :content="'Group active'" placement="top">
                                        <el-switch
                                            v-model="form.is_active"
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
                <div class="card-footer">
                    <el-button type="primary" :loading="buttonLoading" @click="formSubmit()">Simpan</el-button>
                    <el-button>Reset</el-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import urlBase from '@/js/url'
export default {
    
    data(){
        return{
            form:{
                user_id     : null,
                username    : null,
                aclGroup_id : null,
                opd_id      : null,
                is_active   : null,
                disabled    : false,
                opd_id      : null,
            },
            type : "insert",
            aclGroup:[],
            opd:[],
            buttonLoading : false,
        }
    },
    mounted() {
        console.log('Form User Data mounted.')
        this.GetModulGroup()
        this.GetOpd()
    },
    methods:{
        notif(s,m,type){
            this.$notify({
                title: s,
                message: m,
                type: type
            });
        },
        GetModulGroup(){
            axios
                .post(urlBase.urlWeb+'/master/aclGroup',{
                    type : "dataAll"
                })
                .then(r => (
                    this.aclGroup = r.data
                ));
        },
        GetOpd(){
            axios
                .post(urlBase.urlWeb+'/master/opd',{
                    type : "dataAll"
                })
                .then(r => (
                    this.opd = r.data
                ));
        },
        formSubmit(){
            
            this.$refs['usersForm'].validate((valid) => {
                if (valid) {
                    this.buttonLoading = true
                    this.form.disabled = true
                    axios
                        .post(urlBase.urlWeb+'/master/users',{
                            type    : this.type,
                            form    : this.form
                        })
                        .then(r => (
                            this.type = "insert",
                            this.buttonLoading = false,
                            this.form.disabled = false,
                            this.$emit('changeTabName', 'second'),
                            this.$emit('UpdateData', 'second'),
                            this.notif(r.data.title, r.data.message,r.data.type),
                            this.$refs['usersForm'].resetFields()
                        ));
                }
                else{
                     return false;
                }
            })
        },
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