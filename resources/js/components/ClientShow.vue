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
                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}">
                        Bookings
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <span class="dropdown-item cursor-pointer" @click="setList('bookings', 'all')">All Bookings</span>
                        <span class="dropdown-item cursor-pointer" @click="setList('bookings', 'future')">Future bookings only</span>
                        <span class="dropdown-item cursor-pointer" @click="setList('bookings', 'past')">Past bookings only</span>
                    </div>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>

                    <template v-if="visibleBookings && visibleBookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in visibleBookings" :key="booking.id">
                                    <td>{{`${convertDate(booking.start)}, ${convertTime(booking.start)} to ${convertTime(booking.end)}`}}</td>
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

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            allBookings: this.client.bookings,
            visibleBookings: [],
        }
    },

    mounted() {
        this.visibleBookings = this.allBookings
    },

    methods: {
        setList(tab, type = null) {
            this.switchTab(tab);
            if (tab == 'bookings') this.filterBookings(type);
        },
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        filterBookings(type) {
            console.log('filterBookings', type)
            switch (type) {
                case 'past':
                    this.visibleBookings = this.allBookings.filter(b => new Date(b.start) < new Date());
                    break;
                case 'future':
                    this.visibleBookings = this.allBookings.filter(b => new Date(b.end) > new Date());
                    break;

                default: this.visibleBookings = this.allBookings; break;
            }
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        convertDate(dateTime) {
            return new Date(dateTime).toLocaleString('en-gb', {
                year: 'numeric',
                month: 'long',
                day: '2-digit',
                weekday: 'long'
            }).replace(',', '');
        },

        convertTime(dateTime) {
            return new Date(dateTime).toLocaleString('en-gb', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },
    }
}
</script>
