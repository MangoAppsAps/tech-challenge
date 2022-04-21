export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: null
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        },
    },
    mutations: {
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_USER (state, value) {
            state.user = value
        }
    },
    actions: {
        async LOGIN_HANDLE({dispatch}, payload) {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login', payload)

            return dispatch('me')
        },
        async LOGOUT_HANDLE ({dispatch}) {
            await axios.post('/logout')

            return dispatch('me')
        },
        me({commit}) {
            return axios.get('/api/user').then((res) => {
                commit('SET_AUTHENTICATED', true)
                commit('SET_USER', res.data)
            }).catch(() => {
                commit('SET_AUTHENTICATED', false)
                commit('SET_USER', null)
            })
        },
        REGISTER_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/register', payload).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
    }
}
