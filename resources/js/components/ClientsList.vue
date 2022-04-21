<template>
    <div>
        <h1>
            {{ 'Clients' }}
            <router-link :to="{name: 'clients-create'}" v-slot="{ href, navigate }" custom>
                <a :href="href" @click="navigate" class="float-right btn btn-primary">{{ '+ New Client' }}</a>
            </router-link>
        </h1>

        <table class="table" v-if="notEmptyObject(clients) > 0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Number of Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <router-link :to="'/clients/show/'+client.id" v-slot="{ href, navigate }" custom>
                            <a :href="href" @click="navigate" class="btn btn-primary btn-sm">{{ 'View' }}</a>
                        </router-link>
                        <button class="btn btn-danger btn-sm" @click="deleteClient(client.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <template v-else>
            <p class="text-center">{{ 'The user has no clients.' }}</p>
        </template>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'ClientsList',
    props: ['clients'],
    methods: {
        ...mapActions({
            CLIENTS_DESTROY_HANDLE: 'clients/CLIENTS_DESTROY_HANDLE'
        }),
        deleteClient(id) {
            this.CLIENTS_DESTROY_HANDLE(id).then(res => {
                this.$toasted.success(res.data.message)

                this.$emit('refreshData')
            }).catch(err => {
                this.displayErrors(err)
            })
        }
    }
}
</script>
