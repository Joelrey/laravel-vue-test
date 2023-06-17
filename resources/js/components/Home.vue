<template>
    <header class="header bg-info">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h3 class="m-0"> {{ appName }}</h3>
                </div>
                <div class="col-6">
                    <div class="d-flex justify-content-end">
                        <router-link :to="{ name: 'register' }">
                            <button class="btn btn-sm btn-dark mx-1"> Register </button>
                        </router-link>
                        <router-link :to="{ name: 'login' }">
                            <button class="btn btn-sm btn-outline-dark mx-1"> Login </button>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </header>  
    <div class="container">
        <div class="card p-4 my-4">
            <h5>Lorem Ipsum</h5>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet asperiores ea magni, sed quibusdam eos culpa a alias itaque beatae hic nihil minus earum soluta repellat porro quo voluptates sint.</p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, quibusdam? Similique iste fugiat incidunt eligendi aliquam. Sint, nam est ullam, debitis inventore, laudantium consequuntur aut sapiente quae accusantium fugit fugiat.</p>
        </div>
    </div>
    
  </template>

<script>
export default {
    data() {
        return {

        };
    },
    computed: {
        appName() { return process.env.MIX_APP_NAME }
    },
    mounted() { 
        if(this.$store.getters.isAuthenticated) {
            this.$router.push("/welcome")
        }
    },
    methods: {
    
    }
    
}
</script>
  
<style>
 
</style>
  
