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
              <div class="d-flex justify-content-between">
                <h4 class="card-title mb-0">Data</h4>
                <a href="#">
                  <small>Show All</small>
                </a>
              </div>
              <p>Data Pengajuan Permohonan Perizinan / Nonperizinan DPMPTSP Provinsi Kepri</p>
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Permohonan Code</th>
                      <th>Izin / Nonizin</th>
                      <th>Sektor</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>INV-87239</td>
                      <td>Viola Ford</td>
                      <td>Paid</td>
                      <td>20 Jan 2019</td>
                      <td>$755</td>
                    </tr>
                    <tr>
                      <td>INV-87239</td>
                      <td>Dylan Waters</td>
                      <td>Unpaid</td>
                      <td>23 Feb 2019</td>
                      <td>$800</td>
                    </tr>
                    <tr>
                      <td>INV-87239</td>
                      <td>Louis Poole</td>
                      <td>Unpaid</td>
                      <td>25 Mar 2019</td>
                      <td>$463</td>
                    </tr>
                    <tr>
                      <td>INV-87239</td>
                      <td>Vera Howell</td>
                      <td>Paid</td>
                      <td>27 Mar 2019</td>
                      <td>$235</td>
                    </tr>
                    <tr>
                      <td>INV-87239</td>
                      <td>Allie Goodman</td>
                      <td>Unpaid</td>
                      <td>1 Apr 2019</td>
                      <td>$657</td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
        assets: urlBase.asset
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
