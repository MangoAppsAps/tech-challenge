<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary">+ New Client</a>
        </h1>

        <table class="table">
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
                <tr v-for="(client, key) in dynamicClientList" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                        <button class="btn btn-danger btn-sm" @click="deleteClient(client, key)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',

    props: ['clients'],

    data() {

        return {
            /**
             * Creating dynamic property
             * (prop `clients` can not be dynamically changed
             * because of one-way-down binding)
             */
            dynamicClientList: this.clients
        }
    },

    methods: {
        deleteClient(client, key) {
            axios.delete(`/clients/${client.id}`)
                .then(() => {
                    this.dynamicClientList.splice(key, 1);
                });
        }
    }
}
</script>
