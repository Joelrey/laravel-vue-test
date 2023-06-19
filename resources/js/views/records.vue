<template>
<Layout>
    <div class="container">
        <h1 class=" my-2">Welcome {{ user.username }}!</h1>
        <div v-if="isAdmin">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div v-if="success_message" class="alert alert-success text-center">
                        <p class="m-0">{{ success_message }}</p>
                        
                        <button @click="resetAction" class="btn btn-success btn-sm m-1">OK</button>
                    </div>
                    <div v-if="!success_message && action" class="card mb-3">
                        <div class="card-header">
                            {{ action }} User
                            <button type="button" class="btn btn-sm btn-outline-light rounded-circle py-0 float-right" @click="action=''">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div v-if="errors.length>0" class="alert alert-danger">
                                <li v-for="error in errors">{{ error }}</li>
                            </div>
                            <div v-if="action=='Edit'">
                                <div class="form-group">
                                    <label class="mt-1" for="Email">Email</label>
                                    <input class="form-control" type="email" v-model="edit_user.email">
                                </div>
                                <div class="form-group">
                                    <label class="mt-1" for="Phone">Phone</label>
                                    <input class="form-control" type="text" v-model="edit_user.phone">
                                </div>
                                <div class="text-center">
                                    <button @click="saveUser" class="btn btn-primary btn-sm mt-3">Save</button>
                                </div>
                            </div>

                            <div v-if="action=='Delete'">
                                <p class="text-center">Do you really want to delete <b>{{ delete_user.username }}</b>?</p>
                                <div class="text-center">
                                    <button @click="action=''" class="btn btn-secondary btn-sm m-1">No</button>
                                    <button @click="deleteUser" class="btn btn-danger btn-sm m-1">Yes</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Registered Users
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user, index in users">
                                <td>{{ index+1 }}</td>
                                <td>{{ user.username }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.phone }}</td>
                                <td>{{ user.is_admin ? 'Admin' : 'User'}}</td>
                                <td><button class="btn btn-sm btn-warning" @click="editUser(user)">Edit</button>
                                    <button class="btn btn-sm btn-danger mx-1" @click="showDeleteUser(user)">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    </div>

</Layout>
</template>

<script>
import Layout from '../components/Layout.vue';

export default {
    name: 'records',
    components: {
    Layout,
},
    data() {
        return {
            isAdmin: false,
            loading: true,
            users: [],
            show_edit_user: false,
            action: '',
            edit_user: {},
            delete_user: {},
            errors: [],
            success_message: ''
        };
    },
    computed: {
        user() { return this.$store.getters.getAuthUser }
    },
    watch: {
        user(newUser) {
            this.isAdmin = newUser.is_admin
            if(this.isAdmin) {
                this.getUsers()
            }
        },
    },
    async mounted() { 

    },
    methods: {
        async getUsers(){
            this.loading = true
            await axios.get('/api/users')
                .then(response => {
                    this.users = response.data.data
                })
                .catch((error) => {
                    console.log(error)
                });
            this.loading = false
        },
        showDeleteUser(user) {
            this.delete_user = user
            this.action = 'Delete'
            this.errors = []
            this.success_message = ''
        },
        deleteUser(delete_user) {
            this.errors = []
            this.success_message = ''
            axios({url: '/api/users/'+this.delete_user.id, method: 'DELETE' })
            .then(response => {
                console.log(response.data)
                this.getUsers()
                this.success_message = response.data.message
            })
            .catch(error => {
                if(error.response.status === 422) {
                    this.errors = error.response.data.errors
                } else {
                    this.errors[0] = 'Something went wrong'
                }
            })
        },
        editUser(user) {
            this.edit_user.id = user.id
            this.edit_user.email = user.email
            this.edit_user.phone = user.phone
            this.action = 'Edit'
            this.errors = []
            this.success_message = ''
        },
        saveUser() {
            this.errors = []
            this.success_message = ''

            const data = { email: this.edit_user.email, phone: this.edit_user.phone }

            axios({url: '/api/users/'+this.edit_user.id, data: data, method: 'PUT' })
            .then(response => {
                console.log(response.data)
                this.getUsers()
                this.success_message = response.data.message
            })
            .catch(error => {
                if(error.response.status === 422) {
                    this.errors = error.response.data.errors
                } else {
                    this.errors[0] = 'Something went wrong'
                }
            })
        },
        resetAction() {
            this.errors = []
            this.success_message = ''
            this.action = ''
        }
    }
}
</script>

<style>
    .float-right {
        float:right;
    }
</style>
  
  
