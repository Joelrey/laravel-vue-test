<template>
    <Layout>
        <div class="container"> 
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h5 class="m-0">Login</h5>
                        </div>
                        <div class="card-body">
                        <form @submit.prevent="login">
                            <div class="alert alert-danger" v-if="errors.length>0">
                            <li v-for="error in errors">{{ error }}</li>
                            </div>
                            <div class="form-group">
                            <label class="mt-1" for="username">Username</label>
                            <input class="form-control" type="text"  v-model="username">
                            </div>
                            <div class="form-group">
                            <label class="mt-1" for="password">Password</label>
                            <input class="form-control" v-model="password" :type="showPassword ? 'text' : 'password'">
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
                                {{processing ? 'Logging in' : 'Login'}}
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
        password: '',
        showPassword: false,
        processing: false,
        errors:[]
    };
},
computed: {
    user() { return this.$store.getters.getAuthUser }
},
async mounted() { 
    
    if(this.$store.getters.isAuthenticated) {
    this.$router.push("/welcome")
    }

},
methods: {
    togglePasswordVisibility() {
    if(this.showPassword) {
        this.showPassword = false;
    } else {
        this.showPassword = true;
    }
    },
    async login(){    
        this.errors = []  
        this.processing = true
        const data = { username: this.username, password: this.password }

        axios({url: '/api/login', data: data, method: 'POST' })
        .then(response => {
            // console.log(response.data)
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
            this.$store.dispatch('updateToken', response.data.token);
            this.$router.push('/welcome')
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
</style>
  