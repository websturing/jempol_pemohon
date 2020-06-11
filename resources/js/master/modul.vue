<template>
    <div class="row">
     <div class="col-md-12">
        <el-tabs v-model="tabs.activeName">
            <el-tab-pane label="DATA MODUL" name="first">         
                <el-table
                    ref="table_modul"
                    v-loading="table.isLoading"
                    :data="table.data.filter(data => !table.search || data.nama.toLowerCase().includes(table.search.toLowerCase()))"
                    row-key="modul_id"
                    border
                    default-expand-all
                    style="width: 100%">
                    <el-table-column type="index" width="50"></el-table-column>
                    <el-table-column label="nama"prop="nama"></el-table-column>
                    <el-table-column label="url"prop="url"></el-table-column>
                    <el-table-column label="type"prop="type">
                        <template slot-scope="scope">
                            <el-tag
                            :type="scope.row.type === 'parent' ? 'primary' : 'success'"
                            disable-transitions>{{scope.row.type}}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column label="icon"prop="icon">
                            <template slot-scope="scope">
                                <i :class="scope.row.icon"></i>
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
                        <el-button size="mini" @click="editmodul(scope.$index, scope.row)">Ubah</el-button>
                        <el-popover
                            placement="top"
                            width="auto">
                            <p>Yakin Menghapus modul ini?</p>
                            <div style="text-align: right; margin: 0">
                                <el-button type="primary" size="mini" @click="DeleteTable(scope.$index, scope.row, 'delete')">ok</el-button>
                            </div>
                            <el-button slot="reference" size="mini" type="danger">Hapus</el-button>
                        </el-popover>
                    </template>
                    </el-table-column>
                </el-table>
            </el-tab-pane>
            <el-tab-pane label="TAMBAH MODUL" name="second">
                <div class="card"  v-loading="isLoading">
                    <div class="card-body">
                    <el-form :model="modul" ref="modul">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label>Nama Modul</label>
                                <el-form-item :error="error.nama.message" 
                                    prop="nama"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                    <el-input
                                        placeholder="Nama Modul"
                                        v-model="modul.nama"
                                        @blur="GetmodulByname()"
                                        clearable>
                                    </el-input>
                                </el-form-item>
                                
                            </div>
                            <div class="form-group col-md-3">
                                <label>Url</label>
                                <el-form-item
                                    prop="url"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                        <el-input
                                            placeholder="url Modul"
                                            v-model="modul.url"
                                            clearable>
                                        </el-input>
                                </el-form-item>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Icon</label>
                                <el-form-item
                                    prop="icon"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                        <el-input
                                            placeholder="icon Modul"
                                            v-model="modul.icon"
                                            clearable>
                                        </el-input>
                                </el-form-item>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Type</label>
                                <el-form-item
                                    prop="type"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                        <el-select v-model="modul.type" clearable placeholder="Type Modul" @change="typeSelect()">
                                            <el-option
                                                v-for="item in select.type"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                </el-form-item>
                            </div>
                            <div class="form-group col-md-2" v-show="show.select.parent">
                                <label>Parent</label>
                                <el-form-item
                                    prop="parent_id"
                                    :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }">
                                        <el-select v-model="modul.parent_id" clearable placeholder="Type Modul">
                                            <el-option
                                                v-for="item in select.parent"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                </el-form-item>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="form-group col-md-2">
                                <label for="">Active Modul</label>
                                <el-tooltip :content="'modul active'" placement="top">
                                    <el-switch
                                        v-model="modul.is_active"
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
                        <button type="button" class="btn btn-xs btn-primary" @click="submitForm('modul',submitType)">Simpan</button>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
     </div> 
    </div>
</template>

<script>
import urlBase from '@/js/url'
export default {
    
    data(){
        return{
            submitType : "insert",
            isLoading : false,
            modul:{
                modul_id    : null,
                nama        : null,
                url         : null,
                is_active   : false,
                type        : null,
                parent_id   : null,
                icon        : null,
            },
            error:{
                nama : {
                    message  : null,
                    validasi : true,
                },
            },
            tabs:{
                activeName : "first"
            },
            table:{
                data :[],
                search: '',
                isLoading: false
            },
            select:{
                type:[
                    {value : 'main', label : 'main'},
                    {value : 'parent', label : 'parent'},
                    {value : 'child', label : 'child'},
                ],
                parent:[]
            },
            show:{
                select :{
                    parent : false
                }
            }
        }
    },
    mounted() {
        console.log('Modul mounted.')
        this.$parent.$data.activeLink = 'master';
        this.$parent.$data.activeName = 'Modul';
        this.GetModul();
    },
    methods:{
        notif(s,m,type){
            this.$notify({
                title: s,
                message: m,
                type: type
            });
        },
        GetModul(){
            this.table.isLoading = true
            this.table.data = []
            axios
                .post(urlBase.urlWeb+'/master/modul',{
                    type : "dataAll"
                })
                .then(r => (
                    this.table.data = r.data,
                    this.table.isLoading = false,
                    this.SetParentSelect()
                ));
        },
        SetParentSelect(){
            let modul = this.table.data
            for(let i =0; i < modul.length; i++){
                this.select.parent.push({
                    value : modul[i].modul_id, label : modul[i].nama
                });
            }
        },
        typeSelect(){
            if(this.modul.type == 'main' || this.modul.type == 'parent'){
                this.modul.parent_id = 0
                this.show.select.parent = false
            }
            else{
                this.modul.parent_id = null
                this.show.select.parent = true
            }
        },
        GetmodulByname(){
             axios
                .post(urlBase.urlWeb+'/master/modul',{
                    type : "modulByname",
                    nama : this.modul.nama
                })
                .then(r => (
                   this.error.nama.validasi = r.data,
                   console.log(this.error.nama.validasi),
                   this.validasinamamodul()
                ));
        },
        validasinamamodul(){
            if(this.error.nama.validasi === false){
                this.error.nama.message = "Nama Modul Telah Digunakan"
                
            }
            else{
                this.error.nama.message = null
            }
            console.log(this.error.nama)
        },
        submitForm(formName,type){
          
            this.$refs[formName].validate((valid) => {
                if (valid) {
                   this.isLoading = true,
                   axios
                    .post(urlBase.urlWeb+'/master/modul',{
                        type : type,
                        data : this.modul
                    })
                    .then(r => (
                       this.$refs[formName].resetFields(),

                       this.isLoading = false,
                       this.notif(r.data.title,r.data.message,r.data.type),
                       this.tabs.activeName = "first",
                       this.GetModul(),
                       this.submitType = "insert"
                    ));
                } else {
                    return false;
                }
          });
        },
        editmodul(index,row){
            this.tabs.activeName = "second"
            this.submitType = "update"

            this.modul.modul_id     = row.modul_id
            this.modul.nama         = row.nama
            this.modul.url          = row.url
            this.modul.is_active    = row.is_active
            this.modul.type         = row.type
            this.modul.parent_id    = row.parent_id
            this.modul.icon         = row.icon

            if(row.parent_id != 0){
                this.show.select.parent = true
            }
            else{
                this.show.select.parent = false
            }
            console.log(row.parent_id, this.show.select.parent)
        },
        DeleteTable(index,row,type){
             this.table.isLoading = true
             axios
                .post(urlBase.urlWeb+'/master/modul',{
                    type : type,
                    data : row
                })
                .then(r => (
                    this.table.isLoading = false,
                    this.notif(r.data.title,r.data.message,r.data.type),
                    this.GetModul()
                ));
        }
    },
}
</script>
