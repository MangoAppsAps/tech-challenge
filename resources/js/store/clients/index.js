export default {
    namespaced: true,
    actions: {
        CLIENTS_GET_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get('/api/clients').then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
        CLIENTS_STORE_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/clients', payload).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
        CLIENTS_SHOW_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/clients/${payload.id}?filter=${payload.filter}`).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
        CLIENTS_UPDATE_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.put(`/api/clients/${payload.id}`, payload).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
        CLIENTS_DESTROY_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/clients/${payload}`).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },

        // Bookings actions
        BOOKINGS_DESTROY_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/clients/delete_booking/${payload}`).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },

        // Journals actions
        JOURNALS_STORE_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/clients/create_journal', payload).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
        JOURNALS_DESTROY_HANDLE({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/clients/delete_journal/${payload}`).then(res => {
                    resolve(res)
                }, err => {
                    reject(err)
                })
            })
        },
    }
}
