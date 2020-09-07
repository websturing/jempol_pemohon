<template>
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
      <div class="row w-100">
        <div class="col-lg-4 mx-auto">
          <div class="auto-form-wrapper">
            <center>DPMPTSP PROVINSI KEPRI</center>
            <hr />

            <el-form :model="login" ref="login">
              <el-form-item
                prop="username"
                :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }"
              >
                <el-input
                  placeholder="Email Perusahaan"
                  prefix-icon="mdi mdi-account"
                  v-model="login.username"
                  :autofocus="true"
                  @keyup.enter.native="Submit()"
                ></el-input>
              </el-form-item>

              <el-form-item
                prop="password"
                :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }"
              >
                <el-input
                  placeholder="password"
                  prefix-icon="mdi mdi-lock"
                  v-model="login.password"
                  type="password"
                  @keyup.enter.native="Submit()"
                ></el-input>
              </el-form-item>

              <div class="form-group">
                <button
                  class="btn btn-primary submit-btn btn-block"
                  type="button"
                  @click="Submit()"
                >Login</button>
              </div>
              <div class="form-group d-flex justify-content-between">
                <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
              </div>
              <div class="text-block text-center my-3">
                <span class="text-small font-weight-semibold">Not a member ?</span>
                <a :href="url.pendaftaran" class="text-black text-small">Create new account</a>
              </div>
            </el-form>
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
  </div>
</template>

<script>
import urlBase from "@/js/url";
export default {
  data() {
    return {
      isLoading: false,
      login: {
        username: null,
        password: null,
      },
      url: {
        pendaftaran: urlBase.urlWeb + "/pendaftaran",
      },
    };
  },
  mounted() {
    window.history.forward(1);
  },
  methods: {
    notif(s, m, type) {
      this.$notify({
        title: s,
        message: m,
        type: type,
      });
    },
    redirect() {
      window.location.href = urlBase.urlWeb + "/dashboard";
    },
    Submit() {
      this.$refs["login"].validate((valid) => {
        if (valid) {
          this.isLoading = true;
          axios
            .post(urlBase.urlWeb + "/login/loginSubmit", {
              login: this.login,
            })
            .then((r) => {
              console.log(r);
              (this.isLoading = false),
                r.data.code === "500"
                  ? this.notif(r.data.title, r.data.message, r.data.type)
                  : this.redirect();
            });
        } else {
          console.log("error submit!!");
          return false;
        }
      });
    },
  },
};
</script>
