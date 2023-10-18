<template>
    <tr>
        <td class="whitespace-nowrap">{{ dateRange }}</td>
        <td>{{ booking.notes }}</td>
        <td>
            <button class="btn btn-danger btn-sm" @click="deleteBooking(booking)">Delete</button>
        </td>
    </tr>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    name: 'BookingTableRow',

    props: ['booking'],

    computed: {
        dateRange: function () {
            // Monday 19 January 2020, 14:00 to 15:00
            let dateFrom = moment.utc(this.booking.start);
            let dateTo = moment.utc(this.booking.end);

            return dateFrom.format('dddd D MMMM, ')
                + dateFrom.format('HH:mm')
                + ' to '
                + dateTo.format('HH:mm')
        }
    },

    methods: {
        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        }
    },
}
</script>
