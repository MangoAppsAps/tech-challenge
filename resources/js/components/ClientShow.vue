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
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <div class="flex justify-between">
                        <h3 class="mb-3">List of client bookings</h3>
                        <select v-model="timeRange">
                            <option value="all">All bookings</option>
                            <option value="future">Future bookings only</option>
                            <option value="past">Past bookings only</option>
                        </select>
                    </div>
                    <template v-if="bookings && bookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(booking, key) in bookings" :key="booking.id">
                                    <td>{{ booking.time_range }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking, key)">Delete</button>
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
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals
                        <a :href="client.id + '/journals/create'" class="float-right btn btn-primary">+ New Journal</a></h3>
                    <template v-if="journals && journals.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Text</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(journal, key) in journals" :key="journal.id">
                                <td>{{ journal.text }}</td>
                                <td>{{ journal.date }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteJournal(journal, key)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no Journals.</p>
                    </template>
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
            bookings: {},
            journals: {},
            currentTab: 'bookings',
            timeRange: 'all' // possible values: all, past, future
        }
    },

    mounted() {
       this.getBookings();
    },

    watch: {
        timeRange(newTimeRange, oldTimeRange) {
            this.getBookings();
        }
    },

    methods: {
        switchTab(newTab) {
            if (newTab === 'journals' && Object.keys(this.journals).length === 0) {
                this.getJournals();
            }
            this.currentTab = newTab;
        },
        getBookings() {
            this.bookings = {};

            axios.get(`/clients/${this.client.id}/bookings`, {
                params: {
                    'time_range': this.timeRange
                }
            }).then((data) => {
                this.bookings = data.data.bookings;
            }).catch((errors) => {
                if (errors.response.status === 422) {
                    this.errors = errors.response.data.errors
                } else {
                    alert('Something unpredictable happened. Please, kick developer.')
                }
            });
        },
        deleteBooking(booking, key) {
            axios.delete(`/clients/${this.client.id}/bookings/${booking.id}`)
                .then(() => {
                    this.bookings.splice(key, 1);
                }).catch((errors) => {
                if (errors.response.status === 422) {
                    this.errors = errors.response.data.errors
                } else {
                    alert('Something unpredictable happened. Please, kick developer.')
                }
            });
        },
        getJournals() {
            this.journals = {};

            axios.get(`/clients/${this.client.id}/journals`)
                .then((data) => {
                    this.journals = data.data.journals;
                }).catch((errors) => {
                if (errors.response.status === 422) {
                    this.errors = errors.response.data.errors
                } else {
                    alert('Something unpredictable happened. Please, kick developer.')
                }
            });
        },
        deleteJournal(journal, key) {
            axios.delete(`/clients/${this.client.id}/journals/${journal.id}`)
                .then(() => {
                    this.journals.splice(key, 1);
                }).catch((errors) => {
                if (errors.response.status === 422) {
                    this.errors = errors.response.data.errors
                } else {
                    alert('Something unpredictable happened. Please, kick developer.')
                }
            });
        }
    }
}
</script>
