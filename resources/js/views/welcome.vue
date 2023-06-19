<template>
<Layout>
    <div class="container">
        <div>
            <h2 class="my-2">Welcome {{ user.username }}!</h2>
            <router-link v-if="user.is_admin"  :to="{ name: 'records' }">
                <button class="btn btn-sm btn-primary my-2">View Records</button>
            </router-link>
            <button v-else class="btn btn-sm btn-primary my-2">Unsubscribe</button>
            <hr>
            <h5>Lorem Ipsum</h5>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet asperiores ea magni, sed quibusdam eos culpa a alias itaque beatae hic nihil minus earum soluta repellat porro quo voluptates sint.</p>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magni, quibusdam? Similique iste fugiat incidunt eligendi aliquam. Sint, nam est ullam, debitis inventore, laudantium consequuntur aut sapiente quae accusantium fugit fugiat.</p>
        </div>
    </div>
</Layout>
</template>

<script>
import Layout from '../components/Layout.vue';

export default {
    name: 'welcome',
    components: {
        Layout
    },
    data() {
        return {
            
        };
    },
    computed: {
        user() { return this.$store.getters.getAuthUser }
    },
    mounted() { 
        
    },
    methods: {
       
    }
}
</script>
  
<style scoped>

</style>
  
