<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li>
                  <!-- <a href="#">{{perusahaan.fullname}}</a> -->
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
        <div class="row">
          <div class="col-md-9">
            <el-select
              v-model="sort.type"
              placeholder="Sortir Berita Berdasarkan.."
              @change="SortType()"
            >
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
            </el-select>
            <span class="byDate" v-if="show.tanggal">
              <el-date-picker
                v-model="today"
                @change="GetData(today)"
                type="date"
                value-format="dd-MM-yyyy"
                format="dd-MM-yyyy"
                placeholder="Pick a day"
              ></el-date-picker>
            </span>

            <span class="byRange" v-if="show.range">
              <el-date-picker
                v-model="range"
                @change="GetDataByDateRange(range)"
                type="daterange"
                range-separator="/"
                format="dd-MM-yyyy"
                :picker-options="pickerOptions"
                start-placeholder="Start date"
                end-placeholder="End date"
              ></el-date-picker>
            </span>
            <br />
            <br />
          </div>
          <div class="col-md-3 offset-md-6 text-right"></div>
          <div class="col-md-12">
            <el-table
              v-loading="table.isLoading"
              :data="table.data.filter(data => !table.search 
                  || data.permohonan_code.toLowerCase().includes(table.search.toLowerCase())
                  || data.perusahaan.fullname.toLowerCase().includes(table.search.toLowerCase())
                  || data.izin.nama_izin.toLowerCase().includes(table.search.toLowerCase())
                  || data.opd.opd.toLowerCase().includes(table.search.toLowerCase())
                )"
              style="width: 100%"
            >
              <el-table-column type="index" width="50"></el-table-column>
              <el-table-column label="Identitas Izin" align="center">
                <el-table-column
                  prop="perusahaan.fullname"
                  label="Perusahaan"
                  header-align="center"
                ></el-table-column>
                <el-table-column prop="izin.nama_izin" label="Nama Izin" header-align="center"></el-table-column>
              </el-table-column>
              <el-table-column label="Waktu Permohonan" align="center">
                <el-table-column prop="created_at" label="Tanggal" align="center" width="100"></el-table-column>
                <el-table-column prop="jam" label="jam" align="center" width="60"></el-table-column>
              </el-table-column>
              <el-table-column align="right">
                <template slot="header" slot-scope="scope">
                  <!-- <el-input v-model="table.search" size="mini" placeholder="Type to search" /> -->
                </template>
                <template slot-scope="scope">
                  <el-button size="mini" @click="edit(scope.$index, scope.row)">Step 2</el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>
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
      url: {
        pdf: urlBase.urlWeb + "/PDF",
      },
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
        .post(urlBase.urlWeb + "/perizinan/permohonan", {
          type: "permohnanTertunda",
          date: date,
        })
        .then(
          (r) => (
            (this.table.data = r.data),
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
      window.location.href =
        urlBase.urlWeb + "/permohonan/detail/" + row.permohonan_id;
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
