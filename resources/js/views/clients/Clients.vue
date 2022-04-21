<template>
    <div class="container">
        <clients-list :clients="clients" v-on:refreshData="getClients"></clients-list>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import ClientsList from '../../components/ClientsList.vue'

export default {
    components: {
        ClientsList
    },
    data() {
        return {
            clients: {}
        }
    },
    beforeMount() {
        this.getClients()
    },
    methods: {
        ...mapActions({
            CLIENTS_GET_HANDLE: 'clients/CLIENTS_GET_HANDLE',
            CLIENTS_DESTROY_HANDLE: 'clients/CLIENTS_DESTROY_HANDLE',
        }),
        getClients() {
            this.CLIENTS_GET_HANDLE().then(res => {
                this.clients = res.data.data
            }).catch(err => {
                this.displayErrors(err)
            })
        }
    }
}
</script>

