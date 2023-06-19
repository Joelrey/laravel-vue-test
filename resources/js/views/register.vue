<template>
    <Layout>
        <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4">
            <div class="card mt-5">
                <div class="card-header">
                <h5 class="m-0">Register</h5>
                </div>
                <div class="card-body">
                <div class="alert alert-success" v-if="success">
                    <p class="m-0">{{ success_message }}</p>
                </div>
                <form @submit.prevent="register">
                    <div class="alert alert-danger" v-if="errors.length>0">
                    <li v-for="error in errors">{{ error }}</li>
                    </div>
                    <div class="form-group">
                    <label class="mt-1" for="username">Username</label>
                    <input class="form-control" type="text"  v-model="username">
                    </div>
                    <div class="form-group">
                    <label class="mt-1" for="email">Email address</label>
                    <input class="form-control" type="email"  v-model="email">
                    </div>
                    <div class="form-group">
                    <label class="mt-1" for="phone">Phone number</label>
                    <input class="form-control" type="phone"  v-model="phone">
                    </div>
                    <div class="form-group">
                    <label class="mt-1" for="password">Password</label>
                    <input class="form-control"  v-model="password" :type="showPassword ? 'text' : 'password'">
                    </div>
                    <div class="form-group">
                    <label class="mt-1" for="confirmPassword">Confirm password</label>
                    <input class="form-control"  v-model="password_confirmation " :type="showPassword ? 'text' : 'password'">
                    </div>
                    
                    <div class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" value="" id="ShowPassword" @click="togglePasswordVisibility" :checked="showPassword">
                    <label class="form-check-label" for="ShowPassword">
                        Show password
                    </label>
                    </div>
                    <br>
                    <div class="text-center">
                    <button :disabled="processing" class="btn btn-primary w-100"> 
                        <span v-if="processing" class="spinner-border mr-2" role="status" aria-hidden="true" style="width: 1rem; height: 1rem;"></span>
                        {{processing ? 'Processing' : 'Register'}}
                    </button>
                    </div>
                </form>             
                </div>
            </div>
            </div>
        </div>
        </div>
    </Layout>
  </template>
  
  <script>
  import Layout from '../components/Layout.vue';
  export default {
    components: {
        Layout,
    },
    data() {
      return {
        username: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: '',
        showPassword: false,
        processing: false,
        errors:[],
        success: false,
        success_message: ''
      };
    },
    computed: {
  
    },
    methods: {
      togglePasswordVisibility() {
        if(this.showPassword) {
          this.showPassword = false;
        } else {
          this.showPassword = true;
        }
      },
      async register(){    
        this.errors = []  
        this.processing = true
        const data = { 
          username: this.username,
          email: this.email,
          phone: this.phone,
          password: this.password,
          password_confirmation : this.password_confirmation ,
         }
  
        axios({url: '/api/register', data: data, method: 'POST' })
        .then(response => {
            this.success = true
            this.success_message = response.data.message
            this.username = ''
            this.email = ''
            this.phone = ''
            this.password = ''
            this.password_confirmation = ''
        })
        .catch(error => {
            if(error.response.status === 422) {
              this.errors = error.response.data.errors
            } else {
              this.errors[0] = 'Something went wrong'
            }
        })
  
        this.processing = false
      }
    }
  };
  </script>
  
  <style scoped>
  .align-right {
    float: right;
  }
  .form-check-label{
    font-size: 14px;
  }
  </style>
  