<template>
    <div>
        <h3 class="mb-3">
            List of client bookings

            <select v-model="bookingFilter" class="float-right text-lg">
                <option value="all">All bookings</option>
                <option value="past">Past bookings only</option>
                <option value="future">Future bookings only</option>
            </select>
        </h3>

        <template v-if="filterBookings().length > 0">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th>Time</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="booking in filterBookings().slice().sort((a, b) => new Date(b.start) - new Date(a.start))" :key="booking.id">
                    <td>{{ formatInterval(booking) }}</td>
                    <td>{{ booking.notes }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="destroy(booking)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>

        <template v-else>
            <p class="text-center">The client has no bookings.</p>
        </template>
    </div>
</template>

<script>
import axios from 'axios';
import moment from "moment/moment";

export default {
    name: 'ClientBookings',

    props: ['client'],

    data() {
        return {
            bookingFilter: 'all',
            bookings: [],
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            axios.get(`/clients/${this.client.id}/bookings`).then(response => {
                this.bookings = response.data.data;
            });
        },

        filterBookings() {
            switch (this.bookingFilter) {
                case 'past':
                    return this.bookings.filter(booking => moment.parseZone(booking.start).isBefore(moment()));
                case 'future':
                    return this.bookings.filter(booking => moment.parseZone(booking.start).isAfter(moment()));
                default:
                    return this.bookings;
            }
        },

        formatInterval(booking) {
            const start = moment.parseZone(booking.start);
            const end = moment.parseZone(booking.end);
            const result = start.format('dddd D MMMM YYYY, H:mm') + ' to ';

            if (start.isSame(end, 'day')) {
                return result + end.format('H:mm');
            }

            return result + end.format('dddd D MMMM YYYY, H:mm');
        },

        destroy(booking) {
            axios.delete(`/clients/${this.client.id}/bookings/${booking.id}`).then(() => {
                this.bookings.splice(this.bookings.indexOf(booking), 1);
            });
        },
    }
}
</script>
