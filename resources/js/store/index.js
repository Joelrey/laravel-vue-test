import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';


export default createStore({

    state: {
        authToken: '',
        authUser: {},
        authErrors: [],
    },

    getters: {
        isAuthenticated: state => state.authToken,
        getAuthUser: state => state.authUser,
        getAuthErrors: state => state.authErrors,
    },

    mutations: {
        setAuthToken(state, token) {
            state.authToken = token
        },
        setAuthUser(state, user) {
            state.authUser = user
        },
        setAuthErrors(state, errors) {
            state.authErrors = errors
        },
    },

    actions: {
        updateToken({ commit }, token) {
            commit('setAuthToken', token);
        },
        updateUser({ commit }, user) {
            commit('setAuthUser', user);
        },
        async register({ commit }, data) {
            await axios({ url: '/api/register', data: data, method: 'POST' })
                .then(response => {
                    commit('setAuthUser', response.data.user)
                    commit('setAuthToken', response.data.token)
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
                })
                .catch(error => {
                    commit('setAuthErrors', error.response.data.message)
                })
        },
        async login({ commit }, data) {
            await axios({ url: '/api/login', data: data, method: 'POST' })
                .then(response => {
                    commit('setAuthUser', response.data.user)
                    commit('setAuthToken', response.data.token)
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + response.data.token
                })
                .catch(error => {
                    commit('setAuthErrors', error.response.data.message)
                })
        },
    },
    plugins: [createPersistedState()],
})