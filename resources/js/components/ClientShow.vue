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
                    <div class="btn-group">
                        <button class="btn dropdown-toggle" type="button" id="bookingMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}">
                            Bookings
                        </button>
                        <div class="dropdown-menu" aria-labelledby="bookingMenu">
                            <span class="dropdown-item cursor-pointer" @click="setList('bookings', 'all')">All Bookings</span>
                            <span class="dropdown-item cursor-pointer" @click="setList('bookings', 'future')">Future bookings only</span>
                            <span class="dropdown-item cursor-pointer" @click="setList('bookings', 'past')">Past bookings only</span>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button class="btn dropdown-toggle" type="button" id="journalMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}">
                            Journals
                        </button>
                        <div class="dropdown-menu" aria-labelledby="journalMenu">
                            <span class="dropdown-item cursor-pointer" @click="setList('journals', 'index')">View Journals</span>
                            <span class="dropdown-item cursor-pointer" @click="setList('journals', 'create')">Create Journal</span>
                        </div>
                    </div>
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
                                <tr v-for="booking in visibleBookings" :key="`booking_${booking.id}`">
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
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals' && journals == 'index'">
                    <h3 class="mb-3">List of client journals</h3>
                    <hr />
                    <div v-for="journal in visibleJournals"
                        :key="`journal_${journal.id}`">
                        <p class="italic">{{ convertDate(journal.date) }}</p>
                        <p>{{ journal.text }}</p>
                        <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
                        <hr />
                    </div>
                </div>

                <div class="bg-white rounded p-4" v-if="currentTab == 'journals' && journals == 'create'">
                    <h3 class="mb-3">Create a new journal</h3>
                    <journal-form :client-id="client.id"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import JournalForm from './JournalForm.vue';

export default {
    name: 'ClientShow',

    props: ['client'],

    components: { JournalForm },

    data() {
        return {
            currentTab: 'bookings',
            allBookings: this.client.bookings,
            visibleBookings: [],
            visibleJournals: [],
            journals: 'index',
        }
    },

    mounted() {
        this.visibleJournals = this.client.journals.sort((a,b) => (new Date(b.date)) - (new Date(a.date)));
        this.visibleBookings = this.allBookings
        let tabParameter = (new URLSearchParams(window.location.search)).get('tab');
        if (tabParameter && ['journals','bookings'].includes(tabParameter)) this.currentTab = tabParameter;
    },

    methods: {
        setList(tab, type = null) {
            this.switchTab(tab);
            if (tab == 'bookings') this.filterBookings(type);
            if (tab == 'journals') this.journals = type;
        },

        switchTab(newTab) {
            this.currentTab = newTab;
        },

        filterBookings(type) {
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
            // TODO: Confirm that user really wants to delete this
            axios.delete(`/bookings/${booking.id}`);
            // TODO: Remove this booking from the visible bookings
        },

        deleteJournal(journal) {
            let confirmation = confirm('Are you sure you would like to delete this journal?')
            if (!confirmation) return;

            axios.delete(`/clients/${this.client.id}/journal/${journal.id}`);
            this.visibleJournals = this.visibleJournals
                .filter(j => j.id !== journal.id)
                .sort((a, b) => (new Date(b.date)) - (new Date(a.date)));
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
