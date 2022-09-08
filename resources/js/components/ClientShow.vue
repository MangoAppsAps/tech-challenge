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
                    <button class="btn" :class="{'btn-primary': currentTab === 'bookings', 'btn-default': currentTab !=='bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab === 'journals', 'btn-default': currentTab !== 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab === 'bookings'">
                    <div class="flex justify-between mb-3">
                        <h3>List of client bookings</h3>
                        <select class="rounded bg-white border" v-model="selectedBookingFilter">
                            <option v-for="option in bookingFilterOptions" :value="option.value">
                                {{ option.text }}
                            </option>
                        </select>
                        <a :href="`/clients/${client.id}/bookings/create`" class="btn btn-primary">+ New Booking</a>
                    </div>

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
                                <tr v-for="booking in filteredBookings" :key="booking.id">
                                    <td>{{ formatBookingDate(booking.start, booking.end) }}</td>
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
                <div class="bg-white rounded p-4" v-if="currentTab === 'journals'">
                    <h3 class="mb-3">List of client journals</h3>

                    <p>(BONUS) TODO: implement this feature</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { DateTime } from 'luxon';

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            bookingFilterOptions: [
                { text: 'All bookings', value: 'all' },
                { text: 'Future bookings only', value: 'future' },
                { text: 'Past bookings only', value: 'past' }
            ],
            selectedBookingFilter: 'all',
        }
    },

    computed: {
        filteredBookings() {
            const bookings = this.client.bookings;

            switch (this.selectedBookingFilter) {
                case 'all':
                    return bookings;
                case 'future':
                    return bookings.filter(({ start }) => DateTime.fromISO(start) > DateTime.now());
                case 'past':
                    return bookings.filter(({ start }) => DateTime.fromISO(start) < DateTime.now());
                default:
                    return bookings;
            }
        },
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        formatBookingDate(startDate, endDate) {
            startDate = DateTime.fromISO(startDate).setLocale('en-gb');
            endDate = DateTime.fromISO(endDate).setLocale('en-gb');

            const formattedDate = startDate.toLocaleString(DateTime.DATE_HUGE);
            const startTime = startDate.toLocaleString(DateTime.TIME_SIMPLE);
            const endTime = endDate.toLocaleString(DateTime.TIME_SIMPLE);

            return `${formattedDate}, ${startTime} to ${endTime}`
        },

        deleteBooking(booking) {
            axios.delete(`/clients/${this.client.id}/bookings/${booking.id}`)
                .then(() => window.location.reload());
        },
    }
}
</script>
