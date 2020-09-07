<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <h3 class="font-weight-bold no-margin no-padding">{{izin.nama_izin}}</h3>
                <h6 class="text-muted no-margin no-padding">{{opd.opd}}</h6>
            </div>
            <div class="col-md-2">
                <span class="text-primary font-size-xs">Tanggal Permohonan Masuk</span><br/>
                <span class="font-weight-bold">{{permohonan.created_at}} -  {{permohonan.jam}}</span>
            </div>
            <div class="col-md-2">
                <div class="row">
                    <div class="pull-right">
                        <a :href="url.pdf+'?type=routingSlip&id='+scope.row.permohonan_id" class="btn btn-sm btn-success" target="_blank">Routing Slip</a>
                        <button type="button" class="btn btn-primary">Download</button>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <perusahaan v-bind:npwp="perusahaan.npwp" v-bind:rincian="false" v-if="show.perusahaan"></perusahaan>
            </div>
            <div class="col-md-12">
                <el-tabs type="border-card">
                    <el-tab-pane label="Peryaratan">

                         <el-table v-loading="table.isLoading"
                            :data="table.data.filter(data => !table.search 
                            || data.persyaratan.toLowerCase().includes(table.search.toLowerCase())
                            )"
                            style="width: 100%">
                            <el-table-column type="index" width="50"></el-table-column>
                            <el-table-column prop="persyaratan" label="Persyaratan" header-align="center"></el-table-column>
                            <el-table-column prop="catatan" label="Catatan" header-align="center" align="right"></el-table-column>
                            <el-table-column
                                    align="right">
                                    <template slot="header" slot-scope="scope">
                                        <el-input
                                        v-model="table.search"
                                        size="mini"
                                        placeholder="Cari Data Persyaratan"/>
                                    </template>
                                <template slot-scope="scope">
                                     <a  class="btn btn-xs btn-primary" v-if="scope.row.statusUpload.download"
                                        :href="url.file+'/storage/app/permohonan/'+permohonan.permohonan_code+'/persyaratan/'+scope.row.file" target="_blank">
                                        Unduh File
                                    </a>
                                    <input type="file" @change="onFilesChange($event, scope.$index)" v-if="scope.row.statusUpload.upload">
                                </template>
                                </el-table-column>
                        </el-table>
                        <br/>
                        <button type="button" class="btn btn-primary" @click="checkUpload(),openModal('show')" :disabled="!show.modal">Upload</button>
                    </el-tab-pane>
                    <el-tab-pane label="Rekomendasi Teknis">
                        <rekomendasi v-bind:permohonan="permohonan"></rekomendasi>
                    </el-tab-pane>
                    <el-tab-pane label="Surat Keputusan">Surat Keputusan</el-tab-pane>
                    <el-tab-pane label="Tracking Berkas">tracking Berkas</el-tab-pane>
                </el-tabs>
            </div>
        </div>
        <div id="modalUpload" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">STATUS UPLOAD</h5>
                        <button type="button" class="close" data-dismiss="modal" :disabled="show.modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-striped">
                            <tr v-for="p, Index in progress">
                                <td>{{p.persyaratan.persyaratan}}</td>
                                <td width="300">
                                    <div class="progress" v-if="!p.persyaratan.statusUpload.progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%">
                                                <span style="margin-top:20px">Uploading File</span>>
                                            </div>
                                        </div>
                                        <el-progress :percentage="100" status="success" v-if="!p.persyaratan.statusUpload.upload"></el-progress>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal" :disabled="show.modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import urlBase from '@/js/url';
import moment from 'moment';
import perusahaan from '@/js/components/perizinan/perusahaan/detail';
import rekomendasi from '@/js/components/perizinan/permohonan/rekomendasi';

export default {
  data () {
    return {
       url :{
        pdf : urlBase.urlWeb+'/PDF',
      },
      id : this.$route.params.id,
      url:{
          file : urlBase.urlWeb
      },
      show : {
          modal : true,
          perusahaan : false
      },
      today : moment().format('DD-MM-YYYY'),
      table:{
        isLoading : false,
        data :[],
        search: null,
      },
      permohonan : [],
      izin : {},
      perusahaan :{
          npwp : null
      },
      opd : {},
      queue:[],
      progress :[]
    }
  },
  props:['rekomendasi'],
  mounted() {
    console.log("permohonan Data")
    this.$parent.$data.activeLink = 'perizinan';
    this.$parent.$data.activeName = 'Permohonan Data'; 
  },
  created(){
      this.GetData(this.id)
  },
  components:{
      perusahaan,
      rekomendasi
  },
  methods:{
        openModal(type){
            $("#modalUpload").modal(type)
        },
       checkUpload(){
            let que = this.queue
            let length = this.queue.length
            // console.log(que.length)
            if(length > 0){
                this.UploadFIle(que[0])
            }
            else{
                this.show.modal = false
            }
            
       },
       moment(arg) {
             moment.locale('id');
             return moment(arg);
        },
        GetData(id){
            this.table.isLoading = true
            this.table.data = [],
            axios
                .post(urlBase.urlWeb+'/perizinan/permohonan',{
                    type : "dataById",
                    id   : id
                })
                .then(r => (
                    this.table.data = r.data[0].persyaratan,
                    this.perusahaan = r.data[0].perusahaan,
                    this.permohonan = r.data[0],
                    this.izin = r.data[0].izin,
                    this.opd = r.data[0].opd,
                    this.table.isLoading = false,
                    this.show.perusahaan = true
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
        },

        onFilesChange(event, r){
                    this.queue.push(r)
                     this.progress.push({
                        index : r,
                        persyaratan : this.table.data[r]
                    })
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(event.target.files[0]);
                    fileReader.onload = (e) =>{
                        this.table.data[r].file = e.target.result
                    }
            },
            UploadFIle(i){
                axios
                    .post(urlBase.urlWeb+'/perizinan/permohonan',{
                        kategori : "persyaratan",
                        type : "uploadSingle",
                        persyaratan : this.table.data[i],
                        permohonanCode : this.permohonan.permohonan_code,
                        permohonan_id : this.permohonan.permohonan_id
                    })
                    .then(r => (
                        this.table.data[i].statusUpload.download = true,
                        this.table.data[i].statusUpload.upload = false,
                        this.table.data[i].file = r.data,
                        this.progress[i].persyaratan.statusUpload.progress = true,
                        this.progress[i].persyaratan.statusUpload.upload = false,
                        this.$delete(this.queue, 0),
                        this.checkUpload()
                       
                    ));
            },
    }
}
</script>
<style>
  .transition-box {
    margin-bottom: 10px;
    width: 200px;
    height: 100px;
    border-radius: 4px;
    background-color: #409EFF;
    text-align: center;
    color: #fff;
    padding: 40px 20px;
    box-sizing: border-box;
    margin-right: 20px;
    
  }
  .fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>