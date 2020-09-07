<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li>
                  <a href="#">{{perusahaan.fullname}}</a>
                </li>
              </ul>
              <!-- <ul class="quick-links ml-auto">
                <li>
                  <a href="#">Settings</a>
                </li>
                <li>
                  <a href="#">Analytics</a>
                </li>
                <li>
                  <a href="#">Watchlist</a>
                </li>
              </ul>-->
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <!-- <h4 class="card-title mb-0">Data</h4>
                <a href="#">
                  <small>Show All</small>
                </a>-->
              </div>
              <el-row>
                <el-col :span="24">
                  <div class="sub-title">Cari Jenis Layanan</div>
                  <br />
                  <el-autocomplete
                    class="wide-dropdown"
                    v-model="state2"
                    :fetch-suggestions="querySearch"
                    placeholder="Please Input"
                    :trigger-on-focus="false"
                    @select="handleSelect"
                  ></el-autocomplete>
                </el-col>
              </el-row>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <p class="mb-n1 font-weight-semibold">{{perusahaan.nama}}</p>
                  <small>{{perusahaan.alamat}}</small>
                </div>
              </div>
            </div>
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="d-flex align-items-center pb-2">
                        <div class="dot-indicator bg-danger mr-2"></div>
                        <p class="mb-0">Proses</p>
                      </div>
                      <h4 class="font-weight-semibold">0</h4>
                      <div class="progress progress-md">
                        <div
                          class="progress-bar bg-danger"
                          role="progressbar"
                          style="width: 78%"
                          aria-valuenow="78"
                          aria-valuemin="0"
                          aria-valuemax="78"
                        ></div>
                      </div>
                    </div>
                    <div class="col-md-6 mt-4 mt-md-0">
                      <div class="d-flex align-items-center pb-2">
                        <div class="dot-indicator bg-success mr-2"></div>
                        <p class="mb-0">Selesai</p>
                      </div>
                      <h4 class="font-weight-semibold">0</h4>
                      <div class="progress progress-md">
                        <div
                          class="progress-bar bg-success"
                          role="progressbar"
                          style="width: 45%"
                          aria-valuenow="45"
                          aria-valuemin="0"
                          aria-valuemax="45"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
      perusahaan: {},
      url: {
        assets: urlBase.asset,
        link: urlBase.urlWeb,
      },
      state2: "",
      links: "",
    };
  },
  mounted() {
    this.GetPerusahaan();
    this.GetNamaizin();
  },
  methods: {
    GetPerusahaan() {
      axios
        .post(urlBase.urlWeb + "/master/perusahaan", {
          type: "perusahaanById",
        })
        .then((r) => (this.perusahaan = r.data[0]));
    },
    querySearch(queryString, cb) {
      var links = this.links;
      var results = queryString
        ? links.filter(this.createFilter(queryString))
        : links;
      // call callback function to return suggestions
      cb(results);
    },
    createFilter(queryString) {
      return (a) => {
        return a.value.toLowerCase().indexOf(queryString.toLowerCase()) > -1;
      };
    },
    GetNamaizin() {
      axios
        .post(urlBase.urlWeb + "/opd/izin", {
          type: "namaIzin",
        })
        .then(
          (r) =>
            // console.log(r.data),
            (this.links = r.data)
        );
    },
    handleSelect(item) {
      this.$router.push({
        name: "permohonan-pengajuan",
        params: { id: item.Crypt },
      });
    },
  },
};
</script>
<style scoped>
.wide-dropdown {
  width: 600px !important;
}
</style>