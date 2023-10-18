<template>
    <div class="bg-white container p-4">
        <select v-model="selectedFilter" id="filter" class="w-full px-4 py-2 border rounded-md mt-2 mb-4">
            <option value="all">All Bookings</option>
            <option value="past">Past Bookings Only</option>
            <option value="future">Future Bookings Only</option>
        </select>

        <div v-if="client.bookings && client.bookings.length > 0">
            <div v-for="booking in filteredBookings">
                <div class="block p-3 mb-2 border border-ep-border-color rounded-md">
                    <div class="flex justify-between">
                        <div class="text-lg text-gray-700 mb-1">
                            {{ booking.formattedRange }}
                        </div>
                        <div>
                            <button @click="deleteBooking(booking)"
                                    class="bg-red-500 text-white rounded-full p-2 hover:bg-red-600">
                                <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="text-gray-600 w-11/12">{{ booking.notes }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default ({
    name: "BookingIndex",
    props: [
        'client'
    ],
    data() {
        return {
            selectedFilter: 'all',
        }
    },
    computed: {
        filteredBookings() {
            if (this.selectedFilter === 'all') {
                return this.client.bookings;
            } else if (this.selectedFilter === 'past') {
                return this.client.bookings.filter(booking => new Date(booking.start) < new Date());
            } else if (this.selectedFilter === 'future') {
                return this.client.bookings.filter(booking => new Date(booking.start) >= new Date());
            }
            return [];
        },
    },
    methods: {
        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },
    }
})
</script>

<style scoped>

</style>
