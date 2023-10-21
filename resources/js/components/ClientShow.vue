<template>
    <div>
        <ol class="mb-6">
            <li class="breadcrumb-item"><a href="/clients">Clients</a></li>
            <li class="breadcrumb-item active">{{ client.name }}</li>
        </ol>

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
                                <td>
                                    {{ client.address }}<br />{{ client.postcode }} {{ client.city }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn"
                        :class="{ 'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings' }"
                        @click="switchTab('bookings')">Bookings</button>
                    <button class="btn"
                        :class="{ 'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals' }"
                        @click="switchTab('journals')">Journals</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">List of client bookings</h3>

                    <template v-if="bookings && bookings.length > 0">
                        <select @change="filterBookings($event.target.value)">
                            <option value="all" selected>All bookings</option>
                            <option value="future">Future bookings only</option>
                            <option value="past">Past bookings only</option>
                        </select>
                        <table>
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in bookings" :key="booking.id">
                                    <td>{{ getFormattedDate(booking.start) }}, {{ getformattedTime(booking.start) }} to
                                        {{
                                            getformattedTime(booking.end) }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm"
                                            @click="deleteBooking(booking)">Delete</button>
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
                    <a :href="`/clients/${client.id}/journals/create`" class="float-right btn btn-primary">+ New journal</a>

                    <template v-if="journals && journals.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Entry</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="journal in journals" :key="journal.id" class="journal-row"
                                    :class="{ 'is-loading': journal.id === loadingId }">
                                    <td>{{ journal.date }}</td>
                                    <td>{{ journal.text }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm"
                                            @click="deleteJournal(journal)">Delete</button>
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
            locale: 'en-DE',
            bookings: this.client.bookings,
            journals: this.client.journals,
            loadingId: 0
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        async deleteBooking(booking) {
            await axios.delete(`bookings/${booking.id}`);
            window.location.reload();
        },

        async deleteJournal(journal) {
            this.loadingId = journal.id;
            await axios.delete(`/clients/${this.client.id}/journals/${journal.id}`);
            window.location.reload();
            setTimeout(() => {
                this.loadingId = 0;
                this.currentTab = 'journals';
            }, 400)
        },

        getFormattedDate(date) {
            return new Date(date).toLocaleDateString(this.locale, { weekday: 'long', month: 'long', day: 'numeric' });
        },

        getformattedTime(timeString) {
            return new Date(timeString).toLocaleTimeString(this.locale, { 'timeStyle': 'short' });
        },

        filterBookings(filterValue) {
            if (filterValue == 'all') { // if filterValue is all, reset it to the full array from props
                this.bookings = this.client.bookings;
            } else {
                if (filterValue === 'future') {
                    this.bookings = this.client.bookings.filter((booking) => {
                        const dateStart = new Date(booking.start);
                        const now = new Date();
                        return dateStart > now;
                    })
                } else if (filterValue === 'past') {
                    this.bookings = this.client.bookings.filter((booking) => {
                        const dateStart = new Date(booking.start);
                        const now = new Date();
                        return dateStart < now;
                    })
                }
            }
        }
    },
}
</script>

<style scoped>
.journal-row.is-loading {
    animation: fading .5s linear infinite;
}

@keyframes fading {
    0% {
        opacity: 1;
    }

    50% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}
</style>