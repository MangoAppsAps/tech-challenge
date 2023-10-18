<template>
    <div class="bg-white container p-0 border-l border-r border-b border-t border-ep-border-color">
        <div class="fixed right-6 bottom-6 group">
            <button @click="addClient" type="button" data-dial-toggle="speed-dial-menu-default" aria-controls="speed-dial-menu-default" aria-expanded="false" class="flex items-center justify-center text-white bg-blue-700 rounded-full w-14 h-14 hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:focus:ring-blue-800">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </button>
        </div>
        <div class="p-4 text-2xl text-gray-700">
            Clients
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Phone</th>
                    <th scope="col" class="px-6 py-3 text-center">Number of Bookings</th>
                    <th scope="col" class="px-6 py-3 text-center">Number of Journals</th>
                    <th scope="col" class="px-6 py-3 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="border-b hover:bg-gray-100 cursor-pointer" v-for="client in localClients"
                    :key="client.id" @click="viewClient(client.id)">
                    <td class="px-6 py-4">{{ client.name }}</td>
                    <td class="px-6 py-4">{{ client.email }}</td>
                    <td class="px-6 py-4">{{ client.phone }}</td>
                    <td class="px-6 py-4 text-center">{{ client.bookings_count }}</td>
                    <td class="px-6 py-4 text-center">{{ client.journals_count }}</td>
                    <td class="px-6 py-4 text-right">
                        <button @click="deleteClient(client)"
                                class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                            <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                            </svg>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientsList',

    props: ['clients'],
    data() {
        return {
            localClients: this.clients,
        };
    },
    methods: {
        deleteClient(client) {
            axios.delete(`/clients/${client.id}`).then(response => {
                this.localClients = response.data
            })
        },
        viewClient(clientId){
            window.location.href = `/clients/${clientId}`
        },
        addClient(){
            window.location.href = "/clients/create";
        }
    },

}
</script>
