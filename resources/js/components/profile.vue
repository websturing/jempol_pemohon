<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li>
                  <a href="#" class="font-weight-bold">IDENTITAS DIRI {{perusahaan.fullname}}</a>
                </li>
              </ul>
              <ul class="quick-links ml-auto">
                <li>
                  <a href="#">Settings</a>
                </li>
                <li>
                  <a href="#">Analytics</a>
                </li>
                <li>
                  <a href="#">Watchlist</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <el-form :model="perusahaan" :label-position="'top'">
                <el-row>
                  <el-col :span="11">
                    <el-form-item label="NPWP">
                      <el-input
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
              </el-form>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body"></div>
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
        created_on: null
      },
      readonly: true,
      url: {
        assets: urlBase.asset
      },
      formInline: {
        user: "",
        region: ""
      }
    };
  },
  mounted() {
    this.GetPerusahaan();
  },
  methods: {
    GetPerusahaan() {
      axios
        .post(urlBase.urlWeb + "/master/perusahaan", {
          type: "perusahaanById"
        })
        .then(r => (this.perusahaan = r.data[0]));
    }
  }
};
</script>
<style scoped>
.itemDS {
  top: -20px !important;
  width: 100% !important;
}
.itemWarp {
  margin-top: -30px !important;
  font-size: 9px !important;
  font-weight: bold;
}
</style>