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
                <tr v-for="client in clientsList" :key="client.id">
                    <td>{{ client.name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.bookings_count }}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                        <button class="btn btn-danger btn-sm" @click="deleteClient(client)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <Toast
            v-if="toast.show"
            :message="toast.message"
            :type="toast.type"
            @closeToast="closeToast"
        />

    </div>
</template>

<script>
import axios from 'axios';
import Toast from "../components/Toast";
import toast from "../mixins/toast";

export default {
    name: 'ClientsList',

    props: {
        clients: Array
    },

    mixins: [toast],

    components: {
        Toast,
    },

    data() {
        return {
            toast: {
                show: false,
                success: true,
                message: ''
            },
            clientsList: []
        };
    },

    mounted() {
        this.clientsList = [ ...this.clients ];
    },

    methods: {
        async deleteClient(client) {
            try {
                await axios.delete(`/clients/${client.id}`);

                this.clientsList = this.clientsList.filter(c => c.id !== client.id);

                this.showToast('Client deleted!', 'success');
            } catch(error) {
                const message = error?.response?.data?.error ?? error.message;

                this.showToast(message, 'error');
            }
        }
    }
}
</script>
