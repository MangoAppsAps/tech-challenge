<template>
    <div>
        <h1>
            Clients
            <a href="/clients/create" class="float-right btn btn-primary">+ New Client</a>
        </h1>

        <template v-if="success">
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Success!</span> {{ success }}
            </div>
        </template>

        <template v-if="error">
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Ooops!</span> {{ error }}
            </div>
        </template>

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
                <tr v-for="client in clients" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                        <button class="btn btn-danger btn-sm" :disabled="isDeletingClient(client)" @click.prevent="deleteClient(client)">
                            {{ isDeletingClient(client) ? 'Deleting...' : 'Delete' }}
                        </button>
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

    props: {
        clients: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            processing: false,
            deletingClientId: null,
            error: null,
            success: null
        }
    },

    mounted() {
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const error = urlParams.get('error');

        if (success) {
            this.success = success;
        }

        if (error) {
            this.error = error;
        }
    },

    methods: {
        isDeletingClient(client) {
            return this.processing && this.deletingClientId === client.id
        },

        deleteClient(client) {
            this.processing = true
            this.deletingClientId = client.id

            axios.delete(`/clients/${client.id}`)
                .then(function (response) {
                    window.location.href = '/clients?success=Client+deleted'
                })
        }
    }
}
</script>
