
<template>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h3 class="m-0"> {{ appName }}</h3>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <div v-if="isAuthenticated">
                        <button class="btn btn-sm btn-outline-light mx-1" @click="logout">Logout</button>
                    </div>
                    <div v-else>
                        <router-link v-if="currentRoute != 'register'" :to="{ name: 'register' }">
                            <button class="btn btn-sm btn-light mx-1"> Register </button>
                        </router-link>
                        <router-link v-if="currentRoute != 'login'" :to="{ name: 'login' }">
                            <button class="btn btn-sm btn-outline-light mx-1"> Login </button>
                        </router-link>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<main>
    
    <slot></slot>

</main>
<footer class="footer">
    <div class="container">
        <p class="text-center m-0">
            &copy; {{ currentYear }} Joelrey. All rights reserved.
        </p>
    </div>
</footer>
</template>
  
<script>
export default {
    name: 'Layout',
    computed: {
        appName() { return process.env.MIX_APP_NAME },
        currentYear() { return new Date().getFullYear() },
        currentRoute() { return this.$route.name },
        isAuthenticated() { return this.$store.getters.isAuthenticated }
    },
    data() {
        return {
            user: {name:""},
        }
    },
    mounted() {
        this.getUser()
    },
    methods: {
        async getUser(){
            await axios.get('/api/user')
                .then(response => {
                    this.user = response.data
                    this.$store.dispatch('updateUser', response.data);
                })
                .catch((error) => {
                    console.log(error)
                    this.$store.dispatch('updateToken', '');
                });
        },
        async logout() {
            await axios.post('/api/logout')
            .then(response => {
                console.log(response.message)
                this.$store.dispatch('updateToken', '');
            })
            .catch(error => {
                console.log(error)
            })
            this.$router.push('/')
        },
    }
};
</script>
  
<style>
    .card {
        border-color: #365685;
        
    }
    .card-header {
        background-color: #365685;
        color: #f7f4f4;
    }
    .btn-light{
        color: #365685;
    }
</style>

<style scoped>
  .footer {
    background-color: #365685;
    padding: 18px;
    color: #f7f4f4;
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
  }


  .header {
    background-color: #365685;
    padding: 18px;
    color: #f7f4f4;
    left: 0;
    top: 0;
    width: 100%;
  }
  
  /* .container {
    max-width: 1200px;
    margin: 0 auto;
  } */
  
  .text-center {
    text-align: center;
  }
</style>
  