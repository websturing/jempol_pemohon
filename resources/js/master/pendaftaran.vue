<template>
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
      <div class="row w-100">
        <div class="col-lg-12 mx-auto">
          <div class="auto-form-wrapper">
            <el-row :gutter="5">
              <el-col :md="2">
                <center>
                  <el-image
                    style="width: 75px; height: 100px"
                    :src="url.publicImages+'/logo.png'"
                    :fit="'fill'"
                  ></el-image>
                </center>
              </el-col>
              <el-col :md="10">
                DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU PROVINSI KEPULAUAN RIAU
                <div class="font-size-sm text-muted">Pendaftaran Online Perizinan dan Nonperizinan</div>
              </el-col>
            </el-row>
            <el-steps :active="steps.active" finish-status="success">
              <el-step title="Step 1" description="Identitas Perusahaan"></el-step>
              <el-step title="Step 2" description="Berkas keabasahaan Perusahaan"></el-step>
              <el-step title="Step 3" description="Selesai"></el-step>
            </el-steps>
            <el-form :model="perusahaan" :label-position="'top'" style="min-height:350px">
              <div v-show="steps.body[0]">
                <el-row>
                  <el-col :span="11">
                    <el-form-item label="NPWP">
                      <el-input
                        size="small"
                        v-model="perusahaan.npwp"
                        placeholder="NPWP"
                        class="itemDS"
                        :disabled="readonly"
                      ></el-input>
                    </el-form-item>
                  </el-col>
                </el-row>
                <el-row :gutter="10">
                  <el-col :md="3">
                    <el-form-item label="KATEGORI" class="itemWarp">
                      <el-input
                        size="small"
                        v-model="perusahaan.kategori"
                        placeholder="NPWP"
                        style="width: 100%;"
                        class="itemDS"
                        :disabled="readonly"
                      ></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :md="11">
                    <el-form-item label="NAMA" class="itemWarp">
                      <el-input
                        size="small"
                        v-model="perusahaan.nama"
                        placeholder="Nama Perusahaan"
                        class="itemDS"
                        style="width: 100% !important;"
                        :disabled="readonly"
                      ></el-input>
                    </el-form-item>
                  </el-col>
                </el-row>
                <el-row :gutter="10">
                  <el-col :md="9">
                    <el-form-item label="EMAIL" class="itemWarp">
                      <el-input
                        size="small"
                        v-model="perusahaan.email"
                        placeholder="xxxxx@xxx.com"
                        class="itemDS"
                        style="width: 100% !important;"
                        :disabled="readonly"
                      ></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :md="5">
                    <el-form-item label="Hp" class="itemWarp">
                      <el-input
                        size="small"
                        v-model="perusahaan.contact"
                        placeholder="xxxx.xxxx.xxxx"
                        class="itemDS"
                        style="width: 100% !important;"
                        :disabled="readonly"
                      ></el-input>
                    </el-form-item>
                  </el-col>
                </el-row>
                <el-row :gutter="10">
                  <el-col :md="18">
                    <el-form-item label="ALAMAT" class="itemWarp">
                      <el-input
                        size="small"
                        type="textarea"
                        v-model="perusahaan.alamat"
                        placeholder="xxxxx@xxx.com"
                        class="itemDS"
                        style="width: 100% !important;"
                        :disabled="readonly"
                      ></el-input>
                    </el-form-item>
                  </el-col>
                </el-row>
              </div>
              <div v-show="steps.body[1]" style="margin-top:20px">
                <el-row :gutter="20">
                  <el-col :md="6" v-for="(u, Uindex) in upload" :key="Uindex">
                    <div></div>
                    <label :for="u.id" class="custom-file-upload" :class="u.css">
                      <i class="fa fa-cloud-upload"></i>
                      <div>{{u.praname}}</div>
                      <el-button
                        type="primary"
                        size="mini"
                        v-if="u.button"
                        @click="pratinjau(Uindex)"
                      >Pratinjau</el-button>
                    </label>
                    <input
                      type="file"
                      :id="u.id"
                      @change="changeFile(Uindex, $event)"
                      :accept="accepts"
                    />
                  </el-col>
                </el-row>
              </div>
              <div v-show="steps.body[2]" style="margin-top:30px">
                <el-row :gutter="5">
                  <el-col :md="2">NPWP</el-col>
                  <el-col :md="22">{{perusahaan.npwp}}</el-col>
                  <el-col :md="2">Nama</el-col>
                  <el-col :md="22">{{perusahaan.fullname}}</el-col>
                  <el-col :md="2">Email / Hp</el-col>
                  <el-col :md="22">{{perusahaan.email}} / {{perusahaan.contact}}</el-col>
                  <el-col :md="2">Alamat</el-col>
                  <el-col :md="22">{{perusahaan.alamat}}</el-col>
                </el-row>
                <el-divider content-position="left">Berkas keabasahaan Perusahaan</el-divider>
                <el-table :data="upload" border style="width: 100%">
                  <el-table-column prop="name" label="Nama"></el-table-column>
                  <el-table-column prop="nameFile" label="Nama Berkas"></el-table-column>
                  <el-table-column label=" " width="120">
                    <template slot-scope="scope">
                      <el-button
                        @click="pratinjau(scope.$index, $event)"
                        type="primary"
                        size="small"
                      >Pratinjau</el-button>
                    </template>
                  </el-table-column>
                </el-table>
              </div>
            </el-form>
            <hr />
            <el-button
              type="danger"
              @click="stepButtonPrevious"
              v-if="this.steps.active > 1"
            >Sebelumnya</el-button>
            <el-button type="primary" @click="nextStep">{{steps.button}}</el-button>
          </div>
          <ul class="auth-footer">
            <li>
              <a href="#">Conditions</a>
            </li>
            <li>
              <a href="#">Help</a>
            </li>
            <li>
              <a href="#">Terms</a>
            </li>
          </ul>
          <p class="footer-text text-center">copyright © 2020 DPMPMTSP KEPRI. All rights reserved.</p>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <div id="myNav" class="overlay-popup" :style="{width: widthPratinjau}">
      <a href="javascript:void(0)" class="closebtn" @click="pratinjauClose()">&times;</a>
      <div class="overlay-popup-content">
        <iframe :src="objectURL"></iframe>
      </div>
    </div>

    <!-- TERM AND CONDITION -->
    <div
      class="modal fade"
      id="TermAndCondition"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">...</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import urlBase from "@/js/url";
export default {
  data() {
    return {
      widthPratinjau: "0%",
      objectURL: null,
      accepts: ["image/*", "application/pdf"].join(","),
      perusahaan: {
        perusahaan_id: null,
        perusahaan_code: null,
        npwp: null,
        kategori: null,
        nama: null,
        alamat: null,
        email: null,
        contact: null,
        aktif: null,
        created_on: null,
        fullname: null
      },
      upload: [
        {
          name: "Nomor Induk Kependudukan",
          nameFile: "Unggah Berkas NPWP",
          praname: "Unggah Berkas NPWP",
          type: null,
          size: 0,
          objectURL: null,
          id: "npwp",
          button: false,
          files: null,
          css: null,
          fileTemp: null
        },
        {
          name: "Akta Pendirian / Perubahan",
          nameFile: "Unggah Berkas Akta",
          praname: "Unggah Berkas Akta",
          type: null,
          size: 0,
          objectURL: null,
          id: "akta",
          button: false,
          files: null,
          css: null,
          fileTemp: null
        },
        {
          name: "NIB OSS",
          nameFile: "Unggah Berkas NIB",
          praname: "Unggah Berkas NIB",
          type: null,
          size: 0,
          objectURL: null,
          id: "nib",
          button: false,
          files: null,
          css: null,
          fileTemp: null
        },
        {
          name: "Izin Usaha / KBLI",
          nameFile: "Unggah Berkas Izin Usaha / KBLI",
          praname: "Unggah Berkas Izin Usaha / KBLI",
          type: null,
          size: 0,
          objectURL: null,
          id: "kbli",
          button: false,
          files: null,
          css: null,
          fileTemp: null
        }
      ],
      steps: {
        active: 1,
        button: "selanjutnya",
        body: [true, false, false]
      },
      readonly: false,
      isLoading: false,
      login: {
        username: null,
        password: null
      },
      url: {
        pendaftaran: urlBase.urlWeb + "/pendaftaran",
        publicImages: urlBase.urlWeb + "/public/images"
      },
      empty: []
    };
  },
  mounted() {},
  methods: {
    term() {
      $("#TermAndCondition").modal("show");
    },
    GetPerusahaan() {
      axios
        .post(urlBase.urlWeb + "/master/perusahaan", {
          type: "perusahaanById"
        })
        .then(r => (this.perusahaan = r.data[0]));
    },
    notif(s, m, type) {
      this.$notify({
        title: s,
        message: m,
        type: type
      });
    },
    redirect() {
      window.location.href = urlBase.urlWeb + "/dashboard";
    },
    Submit() {
      axios
        .post(urlBase.urlWeb + "/pendaftaran/form", {
          type: "daftar",
          perusahaan: this.perusahaan,
          upload: this.upload
        })
        .then(r => console.log(r));

      // this.$refs["login"].validate(valid => {
      //   if (valid) {
      //     this.isLoading = true;
      //     axios
      //       .post(urlBase.urlWeb + "/login/loginSubmit", {
      //         login: this.login
      //       })
      //       .then(r => {
      //         console.log(r);
      //         (this.isLoading = false),
      //           r.data.code === "500"
      //             ? this.notif(r.data.title, r.data.message, r.data.type)
      //             : this.redirect();
      //       });
      //   } else {
      //     console.log("error submit!!");
      //     return false;
      //   }
      // });
    },
    nextStep() {
      let next = this.steps.active;
      if (next == 2) {
        this.CheckUpload();
      } else if (next == 1) {
        // this.Submit();
        this.term();
      } else {
        this.stepButton();
      }
    },
    stepButton() {
      let next = this.steps.active;

      this.steps.body = [false, false, false];
      this.steps.active++;
      this.steps.body[next] = true;
      if (next == 2) {
        this.steps.button = "Daftar";
      }
    },
    stepButtonPrevious() {
      this.steps.body = [false, false, false];

      if (this.steps.active >= 1) {
        this.steps.active--;
      }
      this.steps.body[this.steps.active - 1] = true;
      console.log(this.steps.active);
      if (this.steps.active > 2) {
        this.steps.button = "Daftar";
      } else {
        this.steps.button = "Selanjutnya";
      }
    },
    changeFile(i, event) {
      if (this.objectURL) {
        URL.revokeObjectURL(this.objectURL);
      }

      const file = event.target.files[0];

      this.upload[i].nameFile = file.name;
      this.upload[i].type = file.type;
      this.upload[i].size = file.size;
      this.upload[i].fileTemp = file;
      this.upload[i].objectURL = URL.createObjectURL(file);
      this.upload[i].button = true;
      this.upload[i].praname = this.upload[i].nameFile.substring(0, 60) + "...";
      this.upload[i].css = "custom-file-upload-success";

      let fileReader = new FileReader();
      fileReader.readAsDataURL(event.target.files[0]);
      fileReader.onload = e => {
        this.upload[i].files = e.target.result;
      };
    },
    pratinjau(i) {
      this.widthPratinjau = "100%";
      this.objectURL = URL.createObjectURL(this.upload[i].fileTemp);
    },
    pratinjauClose() {
      this.widthPratinjau = "0%";
    },
    UploadFIle(i) {
      axios
        .post(urlBase.urlWeb + "/pendaftaran/form", {
          type: "UploadFileKeabsahan",
          upload: this.upload,
          perusahaan: this.perusahaan
        })
        .then(r => console.log(r.data));
    },
    CheckUpload() {
      this.empty = [];
      for (var i = 0; i < this.upload.length; i++) {
        if (this.upload[i].files == null) {
          this.empty.push(i);
          this.upload[i].css = "custom-file-upload-error";
        }
      }
      if (!this.empty.length) {
        this.stepButton();
      }
    }
  }
};
</script>
<style scoped>
.itemDS {
  top: -30px !important;
  width: 100% !important;
}
.itemWarp {
  margin-top: -40px !important;
  font-size: 9px !important;
}

input[type="file"] {
  display: none;
}
.custom-file-upload {
  border: 3px dashed #ccc;
  display: inline-block;
  padding: 80px 20px 20px 20px;
  cursor: pointer;
  width: 100%;
  text-align: center;
  vertical-align: middle;
  min-height: 220px;
}

.custom-file-upload-error {
  border: 3px dashed red;
}
.custom-file-upload-success {
  border: 3px dashed green;
}
.overlay-popup {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.9);
  overflow-x: hidden;
  transition: 0.5s;
}

.overlay-popup-content {
  position: relative;
  top: 15%;
  width: 100%;
  text-align: center;
  margin-top: 5px;
  padding: 10px 50px 10px 50px;
}

.overlay-popup a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.overlay-popup a:hover,
.overlay-popup a:focus {
  color: #f1f1f1;
}

.overlay-popup .closebtn {
  position: absolute;
  top: 20px;
  right: 45px;
  font-size: 60px;
}

@media screen and (max-height: 450px) {
  .overlay-popup a {
    font-size: 20px;
  }
  .overlay-popup .closebtn {
    font-size: 40px;
    top: 15px;
    right: 35px;
  }
}
@media screen and (max-width: 450px) {
  object,
  iframe {
    border: 3px solid #cecece;
    background: #e9e9e9;
    width: 100%;
    height: 100px;
    overflow: scroll;
  }
}
object,
iframe {
  border: 3px solid #cecece;
  background: #e9e9e9;
  width: 100%;
  height: 600px;
  overflow: scroll;
}
</style>