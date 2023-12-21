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

                    <p>
                        <label for="show">Show:</label>
                        <select @change.prevent="setShow">
                            <option value="all">All</option>
                            <option value="upcoming">Upcoming</option>
                            <option value="past">Past</option>
                        </select>
                    </p>

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
                                <tr v-for="booking in client.bookings" :key="booking.id" v-if="shouldShowBooking(booking)">
                                    <td>{{ formatBookingTime(booking.start, booking.end) }}</td>
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

                    <p>
                        <a :href="`/clients/${client.id}/journals/create`" class="btn btn-primary">Add New Journal</a>
                    </p>

                    <template v-if="client.journals && client.journals.length > 0">
                        <table>
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="journal in client.journals" :key="journal.id">
                                <td>{{ journal.date }}</td>
                                <td>{{ journal.notes }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" @click.prevent="deleteJournal(client, journal)">Delete</button>
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
import moment from 'moment';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            show: 'all',
        }
    },

    mounted() {
        // set tab from url
        if (window.location.hash) {
            this.currentTab = window.location.hash.replace('#', '');
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        setShow(event) {
            this.show = event.target.value;
        },

        shouldShowBooking(booking) {
            if (this.show === 'all') {
                return true;
            }

            if (this.show === 'upcoming') {
                return moment(booking.start).isAfter(moment());
            }

            if (this.show === 'past') {
                return moment(booking.start).isBefore(moment());
            }
        },

        formatBookingTime(start, end) {
            // Format like: Monday 19 January 2020, 14:00 to 15:00
            return moment(start).format('dddd D MMMM YYYY, HH:mm') + ' to ' + moment(end).format('HH:mm');
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        deleteJournal(client, journal) {
            axios.delete(`/clients/${client.id}/journals/${journal.id}`)
                .then(function (response) {
                    window.location.href = `/clients/${client.id}`
                })
        }
    }
}
</script>
