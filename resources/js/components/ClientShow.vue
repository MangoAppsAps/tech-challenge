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
                                <td>{{ client.address }}<br />{{ client.postcode + ' ' + client.city }}</td>
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
                <div v-if="currentTab == 'bookings'" class="bg-white rounded p-4">
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <h3>List of client bookings</h3>
                        </div>
                        <div>
                            <DrowdownComponent :id="'booking_list_filter'" label="Show" :name="'booking_list_filter'" :options="bookingShowOptions" @selected="onShowSelected" />
                        </div>
                    </div>

                    <template v-if="renderBookings && renderBookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in renderBookings" :key="booking.id">
                                    <td>{{ formatTime(booking.start, booking.end) }}</td>
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
                <div v-if="currentTab == 'journals'" class="bg-white rounded p-4">
                    <h3 class="mb-3">List of client journals</h3>

                    <p>(BONUS) TODO: implement this feature</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { humanizeDatetimeDuration } from '../utils/DateUtils';
import axios from 'axios';
import DrowdownComponent from './DrowdownComponent.vue';
import moment from 'moment';

const SHOW_ALL_VALUE = 1;
const SHOW_FUTURE_VALUE = 2;
const SHOW_PAST_VALUE = 3;

export default {
    name: "ClientShow",
    components: { DrowdownComponent },
    props: ["client"],
    data() {
        return {
            currentTab: "bookings",
            renderBookings: [],
            bookingShowOptions: [
                {value: SHOW_ALL_VALUE, text: 'All Bookings'}, 
                {value: SHOW_FUTURE_VALUE, text: 'Future Bookings'}, 
                {value: SHOW_PAST_VALUE, text: 'Past Bookings'}
            ]
        };
    },
    mounted() {
        this.renderBookings = this.client.bookings; 
    },
    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },
        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },
        /**
         * Formats the date duration for the "Time" column
         * @param {string} start 
         * @param {string} stop
         * @returns {string} 
         */
        formatTime(start, stop) {
            return humanizeDatetimeDuration(start, stop);
        },
        /**
         * Event listener listening for a change in the "Show" dropdown.
         * Filters the bookings according to the selected value.
         * 
         * TODO: The method filters the bookings received in the prop, which
         *       means that it expects all the client bookings to be part
         *       of the data. A better solution would be to filter the 
         *       bookings server side, as the current way will cause
         *       issues if pagination is introduced in the future.
         * 
         * @param {number} val
         * @return {void}
         */
        onShowSelected(val) {
            const now = moment();
            
            if (val === SHOW_FUTURE_VALUE) {
                this.renderBookings = this.client.bookings.filter((booking) => {
                    return moment(booking.start).isAfter(now);
                });
                return;
            }

            if (val === SHOW_PAST_VALUE) {
                this.renderBookings = this.client.bookings.filter((booking) => {
                    return moment(booking.end).isBefore(now);
                });
                return;
            } 

            this.renderBookings = this.client.bookings;

        }
    }
}
</script>
