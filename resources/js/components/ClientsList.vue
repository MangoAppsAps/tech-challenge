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
            <tr v-for="(client,index) in allClients" :key="client.id">
                <td>{{ client.name }}</td>
                <td>{{ client.email }}</td>
                <td>{{ client.phone }}</td>
                <td>{{ client.bookings_count }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" :href="`/clients/${client.id}`">View</a>
                    <button class="btn btn-danger btn-sm" @click="deleteClient(client,index)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" v-show="clients.prev_page_url !== null" :href="clients.prev_page_url">Previous</a></li>

                <li class="page-item" :class="{active:clients.current_page ===number }" v-for="number in clients.last_page"><a class="page-link"  :href="'/clients?page='+number">{{ number }}</a></li>
                <li class="page-item"><a class="page-link" v-show="clients.next_page_url !== null" :href="clients.next_page_url">Next</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',
    props: ['clients'],
    data() {
        return {
            allClients: this.clients.data
        }
    },

    methods: {
        deleteClient(client,index) {
            axios.delete(`/clients/${client.id}`).then(() => {
                    this.allClients.splice(index, 1);
                    alert('You have deleted a client successfully');
            });
        }
    }
}
</script>
