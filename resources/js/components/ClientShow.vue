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

                    <template v-if="client.bookings && client.bookings.length > 0">
                        <div>
                            <select id="dropdown" v-model="selectedOption">
                            <option value="">Select Booking Range</option>
                            <option v-for="option in options" :value="option" :key="option">{{ option }}</option>
                            </select>

                            <table>
                                <tbody>
                                    <div v-if="selectedOption === 'All Bookings'">
                                         <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Notes</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tr v-for="booking in client.bookings" :key="booking.id">
                                            <td>{{ booking.formatted_time_range }}</td>
                                            <td>{{ booking.notes }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                                            </td>
                                        </tr>
                                    </div>
                                    <div v-else-if="selectedOption == 'Future bookings only'">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Notes</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tr v-for="booking in future_bookings" :key="booking.id">
                                            <td>{{ booking.formatted_time_range }}</td>
                                            <td>{{ booking.notes }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                                            </td>
                                        </tr>
                                    </div>
                                    <div v-else-if="selectedOption == 'Past bookings only'">
                                        <thead>
                                            <tr>
                                                <th>Time</th>
                                                <th>Notes</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tr v-for="booking in past_bookings" :key="booking.id">
                                            <td>{{ booking.formatted_time_range }}</td>
                                            <td>{{ booking.notes }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
                                            </td>
                                        </tr>
                                    </div>
                                    </tbody>
                                </table>
                        </div>
                    </template>

                    <template v-else>
                        <p class="text-center">The client has no bookings.</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">List of client journals</h3>

                    <a @click="pathCreate" class="btn btn-primary">+ New Journal</a>

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
                                        <button class="btn btn-danger btn-sm" @click="deleteJournal(client, journal)">Delete</button>
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
            options: ["All Bookings", "Future bookings only", "Past bookings only"],
            selectedOption: "All Bookings",
            future_bookings: [],
            past_bookings: []
        }
    },

    watch: {
        selectedOption: function(newVal, oldVal) {
            if (newVal == "All Bookings") {
                this.client.bookings = this.client.bookings;
            } else if (newVal == "Future bookings only") {
                this.client.bookings.forEach(book => {
                    if (new Date(book.start) > Date.now()) {
                        this.future_bookings.push(book);
                    }
                });
            }  else if (newVal == "Past bookings only") {
                this.client.bookings.forEach(book => {
                    if (new Date(book.start) < Date.now()) {
                        this.past_bookings.push(book);
                    }
                });
            }
        }
    },


    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        pathCreate() {
            window.location.href = `/clients/${this.client.id}/journals/create`;
        },

        deleteJournal(clientId, journal) {
            const url = `/clients/${clientId}/journals/${journal.id}`;
            if (window.confirm('Are you sure you want to delete this client?')) {
                axios.delete(url)
                .then(data => {
                    console.log(data);
                    alert('Journal deleted successfully.');
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                });
            }
        }
    }
}
</script>
