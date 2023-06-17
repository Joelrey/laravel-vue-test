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
                            <router-link v-if="user.is_admin"  :to="{ name: 'records' }">
                                <button class="btn btn-sm btn-dark mx-1">View Records</button>
                            </router-link>
                            <button v-else class="btn btn-sm btn-dark mx-1">Unsubscribe</button>
                            <button class="btn btn-sm btn-outline-dark mx-1" @click="logout">Logout</button>

                        </div>
                    </div>
                </div>
            </div>
      </header>  
    </div>
    <div class="container">
        <div class="card text-center p-4">
            Welcome {{ user.username }}!
        </div>
    </div>
    
  </template>

<script>
export default {
    data() {
        return {
            user: {},
        };
    },
    computed: {
        appName() { return process.env.MIX_APP_NAME }
    },
    mounted() { 
        this.getUser()
    },
    methods: {
        async getUser(){
            await axios.get('/api/user')
                .then(response => {
                    this.user = response.data
                })
                .catch((error) => {
                    console.log(error)
                    this.$router.push("/")
                });
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
  
