<template>
    <div>
        <breadcrumbs>Clients -> {{ client.name }}</breadcrumbs>

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
                        <table class="w-full min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Time</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Notes</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
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
                <div class="w-full bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <div class="flex justify-content-between align-items-center">
                        <h3 class="mb-3">List of client journals</h3>
                        <a :href="`/clients/${this.client.id}/journals/create`" class="btn btn-primary btn-sm">+ New Journal</a>
                    </div>

                    <template v-if="journals && journals.length > 0">

                        <table class="w-full min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <JournalTableRow
                                    v-for="journal in journals"
                                    :journal="journal"
                                    :client="client"
                                    :key="'journal' + journal.id"
                                ></JournalTableRow>
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
import BookingTableRow from '../Booking/TableRow.vue';
import JournalTableRow from '../Journal/TableRow.vue';

export default {
    name: 'ClientShow',

    components: {
        BookingTableRow,
        JournalTableRow
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
        },

        journals() {
            return this.client.journals;
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        }
    },

    mounted() {
        let params = new URLSearchParams(document.location.search);
        if (params.has('current_tab')) {
            this.currentTab = params.get('current_tab')
        }
    }
}
</script>
