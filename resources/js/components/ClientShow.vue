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

                    <select v-model="selectedBookingsFilter" class="bg-gray-50 border border-gray-300 rounded-lg w-full p-2.5 mb-4">
                        <option v-for="(text, value) in bookingsFilterOptions" :value="value">
                          {{ text }}
                        </option>
                    </select>

                    <template v-if="filteredBookings && filteredBookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in filteredBookings" :key="booking.id">
                                    <td>{{ booking | getBookingDisplayTime }}</td>
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

                    <p>(BONUS) TODO: implement this feature</p>
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
            bookingsFilterOptions: {
                all: 'All bookings',
                future: 'Future bookings only',
                past: 'Past bookings only',
            },
            selectedBookingsFilter: 'all',
            filteredBookings: null,
        }
    },
    mounted() {
        this.filterBookings();
    },
    watch: {
        selectedBookingsFilter() {
            this.filterBookings();
        }
    },
    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },
        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },
        filterBookings() {
            let now = moment().valueOf();
            if (this.selectedBookingsFilter == 'future') {
                this.filteredBookings = this.client.bookings.filter(b => {
                    return (now <= moment(b.start).valueOf());
                })
                return;
            }
            if (this.selectedBookingsFilter == 'past') {
                this.filteredBookings = this.client.bookings.filter(b => {
                    return (now > moment(b.end).valueOf());
                })
                return;
            }
            this.filteredBookings = this.client.bookings;
        }
    },
    filters: {
        getBookingDisplayTime: function(booking) {
            let start = moment(booking.start)
                .format('dddd D MMMM YYYY, H:mm');
            let end = moment(booking.end).format('H:mm')
            return start.concat(' to ', end)
        }
    }
}
</script>
