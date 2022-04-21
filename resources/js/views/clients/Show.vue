<template>
    <div class="container-fluid">
        <client-show :client="client" v-on:refreshData="getClient"></client-show>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import ClientShow from '../../components/ClientShow.vue'

export default {
    components: {
        ClientShow
    },
    data() {
        return {
            client: {}
        }
    },
    beforeMount() {
        this.getClient()
    },
    methods: {
        ...mapActions({
            CLIENTS_SHOW_HANDLE: 'clients/CLIENTS_SHOW_HANDLE'
        }),
        getClient(filter) {
            if (!filter) filter = 'all'

            this.CLIENTS_SHOW_HANDLE({id: this.$route.params.id, filter: filter}).then(res => {
                this.client = res.data.data
            }).catch(err => {
                this.$router.push({name: 'clients'})

                this.displayErrors(err)
            })
        }
    }
}
</script>
