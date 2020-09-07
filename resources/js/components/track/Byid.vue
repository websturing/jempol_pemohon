<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              asdas
              <ul class="quick-links">
                <li>
                  <!-- <a href="#">{{perusahaan.fullname}}</a> -->
                </li>
              </ul>
              <ul class="quick-links ml-auto">
                <li>
                  <a href="#">TRACKING BERKAS</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="block">
            <el-timeline>
              <el-timeline-item
                v-for="(activity, index) in table.data"
                :key="index"
                :timestamp="activity.stepKet"
                :color="activity.color"
                placement="top"
              >
                <el-card>
                  <h6>{{activity.pesan}}</h6>
                  <p>{{activity.activityTime}}</p>
                  <p>
                    {{activity.kategori}}
                    <span v-if="activity.kategori">: {{activity.user.username}}</span>
                  </p>
                </el-card>
              </el-timeline-item>
            </el-timeline>
          </div>
        </div>
        <div class="col-md-6">
          <el-image :src="url.alur">
            <div slot="placeholder" class="image-slot">
              Loading
              <span class="dot">...</span>
            </div>
          </el-image>
        </div>
        <div class="col-md-12" v-if="tolak.length > 0">
          <el-card>
            <div slot="header" class="clearfix">
              <span>DATA PENOLAKAN BERKAS</span>
              <!-- <el-button style="float: right" type="primary">KONSULTASI</el-button> -->
            </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>Persyaratan</th>
                  <th>status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(t, tIndex) in tolak" :key="tIndex">
                  <td>{{tIndex+1}}</td>
                  <td>{{t.persyaratan}}</td>
                  <td>{{t.status}}</td>
                  <td>{{t.catatan}}</td>
                </tr>
              </tbody>
            </table>
            <br />
            <span
              style="color:red"
            >Apabila data persyaratan telah lengkap, silahkan mengajukan permohonan ulang</span>
          </el-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import urlBase from "@/js/url";
import moment from "moment";

export default {
  data() {
    return {
      id: this.$route.params.id,
      track: [],
      url: {
        pdf: urlBase.urlWeb + "/PDF",
        alur: urlBase.assets + "/alur2.jpg",
      },
      tolak: [],
      today: moment().format("DD-MM-YYYY"),
      range: null,
      table: {
        isLoading: false,
        data: [],
        search: null,
      },
      show: {
        tanggal: false,
        range: false,
      },
      sort: {
        type: null,
        data: null,
      },
      options: [
        {
          value: "range",
          label: "Range Tanggal",
        },
        {
          value: "Tanggal",
          label: "Tanggal",
        },
      ],
      pickerOptions: {
        shortcuts: [
          {
            text: "Minggu Lalu",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit("pick", [start, end]);
            },
          },
          {
            text: "Bulan Lalu",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit("pick", [start, end]);
            },
          },
          {
            text: "3 Bulan Terakhir",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit("pick", [start, end]);
            },
          },
        ],
      },
    };
  },
  mounted() {
    this.GetData(this.today);
  },
  methods: {
    SortType() {
      if (this.sort.type == "Tanggal") {
        this.show.tanggal = true;
        this.show.range = false;
      }
      if (this.sort.type == "range") {
        this.show.tanggal = false;
        this.show.range = true;
      }
    },
    moment(arg) {
      moment.locale("id");
      return moment(arg);
    },
    GetData(date) {
      this.table.isLoading = true;
      this.table.data = [];
      axios
        .post(urlBase.urlWeb + "/track", {
          type: "trackById",
          permohonan_id: this.id,
        })
        .then(
          (r) => (
            (this.table.data = r.data.track),
            (this.tolak = r.data.persyaratan),
            (this.table.isLoading = false),
            console.log(r.data)
          )
        );
    },
    GetDataByDateRange(date) {
      this.table.isLoading = true;
      axios
        .post(urlBase.urlWeb + "/perizinan/permohonan", {
          type: "dataByRange",
          date: date,
        })
        .then(
          (r) => (
            console.log(r.data),
            (this.table.data = r.data),
            (this.table.isLoading = false)
          )
        );
    },
    edit(index, row) {
      window.location.href = urlBase.urlWeb + "/track/" + row.permohonan_id;
    },
    deleteTable(index, row) {
      this.$confirm("hapus Data ini ?", "Warning", {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "warning",
      })
        .then(() => {
          axios
            .post(urlBase.urlWeb + "/master/aclGroup", {
              type: "hapus",
              aclId: row.aclGroup_id,
            })
            .then((r) => this.GetModulGroup());
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "Delete canceled",
          });
        });
    },
  },
};
</script>
