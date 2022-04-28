<template>
    <div>
        <h1 class="mb-6">Clients -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>Client Info</h2>
                    <table>
                        <tbody>
                        <tr>
                            <th class="text-gray-600 pr-3">Name</th>
                            <td>{{ client.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Email</th>
                            <td>{{ client.email }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Phone</th>
                            <td>{{ client.phone }}</td>
                        </tr>
                        <tr>
                            <th class="text-gray-600 pr-3">Address</th>
                            <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn"
                            :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}"
                            @click="switchTab('bookings')">Bookings
                    </button>
                    <button class="btn"
                            :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}"
                            @click="switchTab('journals')">Journals
                    </button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">

                    <h3 class="mb-3 d-inline-block">List of client bookings</h3>

                    <select v-model="selectedValue" class="ml-5" style="border: 1px solid black"
                            @change="filterBookings">
                        <option value="all" selected>All bookings</option>
                        <option value="future">Future bookings only</option>
                        <option value="past">Past bookings only</option>

                    </select>


                    <template v-if="client.bookings && client.bookings.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(booking,index) in bookings" :key="booking.id">
                                <td style="width: 350px;">{{ booking.time }}</td>
                                <td>{{ booking.notes }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteBooking(booking.id,index)">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4 container" v-if="currentTab == 'journals'">
                    <h3 class="mb-3 d-inline-block">List of client journals</h3>
                    <a class="btn btn-primary btn-sm d-inline-block ml-5"
                       :href="'/clients/'+this.client.id+'/create/journal'">Create Journal</a>


                    <table class="table table-striped table-dark">
                        <thead>
                        <tr>
                            <th>Text</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(journal,index) in journals">
                            <td class="w-50">{{ journal.text }}</td>
                            <td class="w-25">{{ journal.date }}</td>
                            <td class="w-25">
                                <button class="btn btn-danger btn-sm" @click="deleteJournal(journal.id,index)">Delete
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',
    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            selectedValue: '',
            bookings: this.client.bookings,
            journals: this.client.journals

        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(id, index) {
            axios.delete(`/bookings/` + id).then(() => {
                this.bookings.splice(index, 1);
            })
        },


        filterBookings() {
            let form = new FormData();
            form.append('query', this.selectedValue);
            form.append('client_id', this.client.id);
            axios.post('/clients/bookings/filter', form).then((data) => {
                this.bookings = data.data
            })
        },
        deleteJournal(id, index) {
            axios.delete('/clients/journal/' + id).then(() => {
                this.journals.splice(index, 1);
            }).catch(() => {
                alert('error cant delete')
            })

        }
    },
}

</script>
