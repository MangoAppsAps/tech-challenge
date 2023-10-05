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
                    <h3 class="mb-3">
                        List of client bookings

                        <select v-model="bookingFilter" class="float-right text-lg">
                            <option value="all">All bookings</option>
                            <option value="past">Past bookings only</option>
                            <option value="future">Future bookings only</option>
                        </select>
                    </h3>

                    <template v-if="filterBookings().length > 0">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in filterBookings().sort((a, b) => new Date(b.start) - new Date(a.start))" :key="booking.id">
                                    <td>{{ formatBookingInterval(booking) }}</td>
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
                    <h3 class="mb-3">
                        List of client journals
                        <button class="float-right btn btn-primary" @click="addJournalVisible = true">+ New Journal</button>
                    </h3>

                    <template v-if="journals.length > 0">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Content</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="journal in journals.sort((a, b) => new Date(b.date) - new Date(a.date))" :key="journal.id">
                                <td>{{ formatJournalDate(journal) }}</td>
                                <td>{{ journal.text }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-if="!journals.length && !addJournalVisible">
                        <p class="text-center">The client has no journals.</p>
                    </template>

                    <template v-if="addJournalVisible">
                        <div class="max-w-lg mx-auto">
                            <div class="form-group">
                                <label for="name">Date</label>
                                <input type="date" id="date" class="form-control" v-model="journal.date">
                            </div>
                            <div class="form-group">
                                <label for="name">Content</label>
                                <textarea id="text" class="form-control" v-model="journal.text" rows="3" required></textarea>
                            </div>

                            <div class="text-right">
                                <button @click="addJournalVisible = false" class="btn btn-default">Cancel</button>
                                <button @click="storeJournal" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            bookingFilter: 'all',
            currentTab: 'bookings',
            bookings: this.client.bookings,
            journals: [],
            journalsInitialized: false,
            addJournalVisible: false,
            journal: {
                date: moment().format('YYYY-MM-DD'),
                text: '',
            },
        }
    },

    methods: {
        filterBookings() {
            switch (this.bookingFilter) {
                case 'past':
                    return this.bookings.filter(booking => moment.parseZone(booking.start).isBefore(moment()));
                case 'future':
                    return this.bookings.filter(booking => moment.parseZone(booking.start).isAfter(moment()));
                default:
                    return this.bookings;
            }
        },

        switchTab(newTab) {
            this.currentTab = newTab;

            if (!this.journalsInitialized && newTab === 'journals') {
                this.getClientJournals(this.client);
            }
        },

        deleteBooking(booking) {
            axios.delete(`/clients/${this.client.id}/bookings/${booking.id}`)
                .then(() => {
                    this.bookings.splice(this.bookings.indexOf(booking), 1);
                });
        },

        formatBookingInterval(booking) {
            const start = moment.parseZone(booking.start);
            const end = moment.parseZone(booking.end);
            const result = start.format('dddd D MMMM YYYY, H:mm') + ' to ';

            if (start.isSame(end, 'day')) {
                return result + end.format('H:mm');
            }

            return result + end.format('dddd D MMMM YYYY, H:mm');
        },

        formatJournalDate(journal) {
            return moment.parseZone(journal.date).format('dddd D MMMM YYYY');
        },

        getClientJournals(client) {
            axios.get(`/clients/${client.id}/journals`)
                .then(response => {
                    this.journals = response.data.data;
                })
                .finally(() => {
                    this.journalsInitialized = true;
                });
        },

        storeJournal() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then(response => {
                    this.journals.push(response.data.data);
                    this.addJournalVisible = false;
                }).finally(() => {
                    this.journal = {
                        date: moment().format('YYYY-MM-DD'),
                        text: '',
                    }
                });
        },

        deleteJournal(journal) {
            axios.delete(`/clients/${this.client.id}/journals/${journal.id}`)
                .then(() => {
                    this.journals.splice(this.journals.indexOf(journal), 1);
                })
        },
    }
}
</script>
