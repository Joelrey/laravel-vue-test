<template>
    <div class="sticky-header">
      <header class="header bg-info">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h3 class="m-0"> {{ appName }}</h3>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-end">
                            <router-link :to="{ name: 'home' }">
                                <button class="btn btn-sm btn-dark">Home</button>
                            </router-link>
                            <button class="btn btn-sm btn-outline-dark mx-1" @click="logout">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
      </header>  
    </div>
    <div class="container">
        <div class="card" v-if="isAdmin">
            <div class="card-header">
                Registered Users
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user, index in users">
                            <td>{{ user.username }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>{{ user.is_admin ? 'Admin' : 'User'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-else class="row justify-content-center">
            <div v-if="loading" class="col-6 alert alert-info text-center">
                Loading...
            </div>
            <div v-else class="col-6 alert alert-danger text-center">
                User is not a admin!
            </div>
        </div>  
    </div>
    
  </template>

<script>
export default {
    data() {
        return {
            user: {},
            isAdmin: false,
            loading: false,
            users: [],
        };
    },
    computed: {
        appName() { return process.env.MIX_APP_NAME }
    },
    async mounted() { 
        await this.getUser()
        
        if(this.isAdmin) {
            this.getUsers()
        }
    },
    methods: {
        async getUser(){
            this.loading = true
            await axios.get('/api/user')
                .then(response => {
                    this.user = response.data
                    this.isAdmin = response.data.is_admin
                })
                .catch((error) => {
                    console.log(error)
                    this.$router.push("/")
                });
            this.loading = false
        },
        async getUsers(){
            this.loading = true
            await axios.get('/api/users')
                .then(response => {
                    this.users = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                    this.$router.push("/")
                });
            this.loading = false
        },
        async logout() {
            await axios.post('/api/logout')
            .then(response => {
                console.log(response.message)
                this.$store.dispatch('updateToken', '');
                this.getUser()
            })
            .catch(error => {
                console.log(error)
            })
        },
    }
    
}
</script>
  
  <style>
  .sticky-header {
    height: 6vh;
    overflow-y: auto;
  }
  
  .header {
    position: sticky;
    top: 0;
    background-color: #f2f2f2;
    padding: 10px;
  }
  </style>
  
