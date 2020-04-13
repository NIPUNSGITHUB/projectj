<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card" style="background-color:transparent;border:none;">
            <h2 class="text-center">Account Registration</h2>

            <div class="card-body">
              <!-- <form method="POST" action="/user/register">
              <input type="hidden" id="_token" name="_token" :value="this.$csrftoken" />-->
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                <div class="col-md-6">
                  <input
                    id="name"
                    type="text"
                    placeholder="Enter your name"
                    class="form-control"
                    name="name"
                    v-model="name"
                    required
                    autocomplete="name"
                    autofocus
                  />
                  <span v-if="errors.name">
                    <p class="text-danger">{{errors.name[0]}}</p>
                  </span>
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                <div class="col-md-6">
                  <input
                    id="email"
                    type="email"
                    placeholder="Enter your email"
                    class="form-control"
                    name="email"
                    v-model="email"
                    required
                    autocomplete="email"
                  />
                  <span v-if="errors.email">
                    <p class="text-danger">{{errors.email[0]}}</p>
                  </span>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Contact No.</label>

                <div class="col-md-6">
                  <input
                    type="number"
                    placeholder="Enter contact number"
                    class="form-control"
                    v-model="tele_no"
                    required
                  />
                  <span v-if="errors.contact_no">
                    <p class="text-danger">{{errors.contact_no[0]}}</p>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">User Type</label>
                <div class="col-md-6">
                  <div class="form-group">
                    <select required class="form-control" v-model="user_type">
                    <option style="display:none;" selected>Select language</option>
                      <option value="Customer">Customer</option>
                      <option value="Supplier">Supplier</option>
                    </select>
                  </div>
                  <span v-if="errors.user_type">
                    <p class="text-danger">{{errors.user_type[0]}}</p>
                  </span>
                </div>
              </div>

              <div v-if="user_type == 'Supplier'" class="form-group row">
                <label class="col-md-4 col-form-label text-md-right">Area</label>

                <input type="hidden" name="selectedAreas" :value="selectedAreas" />
                <div class="col-md-6">
                  <div class="form-group">
                    <multiselect
                      v-model="selectedAreas"
                      :options="areas"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :preserve-search="true"
                      placeholder="Pick some"
                      label="name"
                      track-by="id"
                      :preselect-first="true"
                    ></multiselect>
                  </div>
                  <span v-if="errors.areas">
                    <p class="text-danger">{{errors.areas[0]}}</p>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    placeholder="Password"
                    type="password"
                    class="form-control"
                    name="password"
                    v-model="password"
                    required
                    autocomplete="new-password"
                  />
                  <span v-if="errors.password">
                    <p class="text-danger">{{errors.password[0]}}</p>
                  </span>
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password-confirm"
                  class="col-md-4 col-form-label text-md-right"
                >Confirm Password</label>

                <div class="col-md-6">
                  <input
                    id="password-confirm"
                    placeholder="Confirm Password"
                    type="password"
                    class="form-control"
                    name="password_confirmation"
                    v-model="confirmPassword"
                    required
                    autocomplete="new-password"
                  />
                  <span v-if="errors.confirmPassword">
                    <p class="text-danger">{{errors.confirmPassword[0]}}</p>
                  </span>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="button" class="btn btn-primary" @click="registerUser">Register</button>
                  <a
                    type="button"
                    href="/login"
                    class="btn btn-success"
                    rel="noopener noreferrer"
                  >Login</a>
                </div>
              </div>
              <!-- </form> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
export default {
  props: ["arealist"],
  components: {
    Multiselect
  },
  mounted() {
    //   console.log(this.$csrftoken)
    this.areas = JSON.parse(this.arealist);
  },
  data() {
    return {
      selectedAreas: "",
      name: null,
      email: null,
      tele_no: null,
      user_type: null,
      password: null,
      confirmPassword: null,
      areas: [],
      errors: []
    };
  },
  methods: {
    registerUser() {
      var config = {
        headers: { _token: this.$csrftoken }
      };
      axios
        .post(
          "/user/register",
          {
            name: this.name,
            email: this.email,
            contact_no: this.tele_no,
            user_type: this.user_type,
            password: this.password,
            confirmPassword: this.confirmPassword,
            areas: this.selectedAreas
          },
          config
        )
        .then(res => {
          if (res.data == 1) this.login();
          //window.location.href = "/login";
        })
        .catch(err => {
          if (err.response.status == 422)
            this.errors = err.response.data.errors;

          console.log(this.errors);
        });
    },

    login() {
      var config = {
        headers: { _token: this.$csrftoken }
      };
      axios
        .post(
          "/login",
          {
            email: this.email,
            password: this.password
          },
          config
        )
        .then(() => {
          window.location.href = "/";
        });
    }
  }
};
</script>