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

                    <label for="filter-bookings">Booking filters</label>
                    <select id="filter-bookings" v-model="selectedFilter" @change="filterBookings">
                        <option value="allBookings">All bookings</option>
                        <option value="futureBookings">Future bookings only</option>
                        <option value="pastBookings">Past bookings only</option>
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
                                    <td>{{ booking.readable_start_date }} to {{ booking.readable_end_date }}</td>
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
                    <div class="d-flex justify-content-between align-items-start">
                        <h3 class="mb-3">List of client journals</h3>
                        <a :href="`/clients/${client.id}/journals/create`" class="float-right btn btn-primary">+ New Journal</a>
                    </div>

                    <template v-if="journalsCopy && journalsCopy.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Content</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="journal in journalsCopy" :key="journal.id">
                                    <td>{{ journal.date }}</td>
                                    <td>{{ journal.content }}</td>  
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
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

export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            allBookings: [],
            filteredBookings: [],
            selectedFilter: 'allBookings',
            journalsCopy: []
        }
    },

    created() {
        this.allBookings = this.client.bookings || [];
        this.filteredBookings = this.allBookings;
        this.journalsCopy = [...this.client.journals];
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        async deleteJournal(journal) {
            const response = await axios.delete(`/clients/${this.client.id}/journals/${journal.id}`);

            if(response.status == 200 && response.data == "Deleted") {
                this.journalsCopy = this.journalsCopy.filter(j => j.id !== journal.id);
            }
        },

        filterBookings() {
            const currentDate = new Date();

            if(this.selectedFilter == 'allBookings') {
                this.filteredBookings = this.allBookings;
            } else if (this.selectedFilter === 'futureBookings') {
                this.filteredBookings = this.allBookings.filter(booking => new Date(booking.start) >= currentDate);
            } else if (this.selectedFilter === 'pastBookings') {
                this.filteredBookings = this.allBookings.filter(booking => new Date(booking.start) < currentDate);
            }
        },
    }
}
</script>
