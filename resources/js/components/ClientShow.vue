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
                <select id="bookingFilterDropdown" @change="changeBookingFilter($event)">
                    <option v-for="filter in bookingFilterItems" :value="filter.value" :key="filter.value">{{ filter.label }}</option>
                </select>
                <div>
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">Bookings</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>

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
                                <tr v-for="booking in client.bookings" :key="booking.id">
                                    <td>{{ booking.formattedTime }}</td>
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

                    <p>Write a new journal for a client:</p>

                    <textarea id="journalTextInput" name="journalText" rows="8" cols="60" style="border: 1px solid grey"></textarea>

                    <a class="btn btn-primary btn-sm" @click="createJournal()">Save New Journal</a>

                    <br/>

                    <p>Current client journals:</p>

                    <br/>

                    <table>
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Journal</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="clientJournal in journals" :key="clientJournal.id">
                            <td>{{ clientJournal.formattedTime }}</td>
                            <td>{{ clientJournal.journal }}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" @click="deleteJournal(clientJournal)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientShow',

    props: ['client', 'journals'],

    mounted: function(){

        const params = new URLSearchParams(window.location.search);
        let bookingFilter = params.get('bookingFilter');

        if(bookingFilter !== null)
        {
            bookingFilter = params.get('bookingFilter');
        }
        else
        {
            bookingFilter = 'all';
        }

        document.querySelector('#bookingFilterDropdown').value = bookingFilter;
    },

    data() {
        return {
            currentTab: 'bookings',

            bookingFilterItems: [
                {value: 'all', label: 'All bookings'},
                {value: 'future', label: 'Future bookings only'},
                {value: 'past', label: 'Past bookings only'},
            ],
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        changeBookingFilter(event)
        {
            let selectedFilter = event.target.value;

            window.location.href = window.location.pathname + "?bookingFilter=" + selectedFilter;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        createJournal()
        {
            const clientId = window.location.pathname.split("/").pop();

            const journal = {
                journal: document.getElementById('journalTextInput').value,
            };

            axios.post('/clients/' + clientId + '/journals', journal)
                .then(() => {

                    // Out of scope but could obviously have better UI feedback after this event
                    window.location.reload();
                });
        },

        deleteJournal(journal)
        {
            const clientId = window.location.pathname.split("/").pop();

            axios.delete(`/clients/${clientId}/journals/${journal.id}`).then(function() {

                // Out of scope but could obviously have better UI feedback after this event
                window.location.reload();
            });
        }
    }
}
</script>
