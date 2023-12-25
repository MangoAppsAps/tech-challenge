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
                    <h3 class="mb-3">List of client bookings</h3>

                    <div class="form-group">
                        <label for="booking-filter">Filter bookings</label>
                        <select class="form-control" id="booking-filter" @change="filterBookings">
                            <option selected value="all">All bookings</option>
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
                                <tr v-for="booking in bookings" :key="booking.id">
                                    <td>{{ formatDate(booking.start, 'dddd D MMMM YYYY, HH:mm') }} to {{ formatDate(booking.end, 'HH:mm') }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
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
                    <h3 class="mb-3">List of client journals</h3>
                    <button @click="showJournalForm = true"
                        class="btn btn-danger btn-sm mb-4" >Create journal</button>

                    <template>
                        <JournalForm v-if="showJournalForm" @submit="createJournal"></JournalForm>
                    </template>

                    <template v-if="journals && journals.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Journal text</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="journal in journals" :key="journal.id">
                                <td>{{ formatDate(journal.time, 'dddd D MMMM YYYY') }}</td>
                                <td>{{ journal.text }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" @click="deleteJournal(journal)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no journals.</p>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from "moment";
import JournalForm from "./JournalForm";

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            bookings: [],
            journals: [],
            showJournalForm: false,
        }
    },

    mounted() {
        this.bookings = [ ...this.client.bookings ];
        this.journals = [ ...this.client.journals ];
    },

    components: {
        JournalForm,
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        createJournal(journal) {
            console.log(journal)
            axios.post(`/clients/${this.client.id}/journals`, journal);
            this.showJournalForm = false;
        },

        deleteJournal(journal) {
            axios.delete(`/clients/${this.client.id}/journals/${journal.id}`);
        },

        formatDate(date, format) {
            return moment(date).format(format);
        },

        filterBookings(event) {
            const filter = event.target.value;
            if (filter === 'all') {
                this.bookings = { ...this.client.bookings }
            }

            const now = moment();
            if (filter === 'future') {
                this.bookings = this.client.bookings.filter(booking => moment(booking.start) > now);
            }
            if (filter === 'past') {
                this.bookings = this.client.bookings.filter(booking => moment(booking.start) < now);
            }
        }
    }
}
</script>
