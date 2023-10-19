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

                    <div class="p-2 my-2 grid grid-cols-12 bg-gray-100 rounded">

                        <div class="col-span-3">
                            <select v-model="bookingFilter" class="py-2 px-2 w-full rounded border-white border-2 border-r-8">
                                <option value="all-bookings">All bookings</option>
                                <option value="future-bookings">Future bookings only</option>
                                <option value="past-bookings">Past bookings only</option>
                            </select>
                        </div>

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
                            <BookingTableRow
                                v-for="booking in filteredBookings"
                                :booking="booking"
                                :key="'booking' + booking.id"
                            ></BookingTableRow>
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
import BookingTableRow from './Booking/BookingTableRow.vue';

export default {
    name: 'ClientShow',

    components: {
        BookingTableRow
    },

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            bookingFilter: 'all-bookings'
        }
    },

    computed: {
        filteredBookings () {
            switch (this.bookingFilter) {
                case 'future-bookings':
                    return this.client.bookings.filter(b => new Date(b.start) > new Date())
                case 'past-bookings':
                    return this.client.bookings.filter(b => new Date(b.start) < new Date())
                default:
                    return this.client.bookings;
            }
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        }
    },
}
</script>
