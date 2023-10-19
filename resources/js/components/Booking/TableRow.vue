<template>
    <tr>
        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ dateRange }}</td>
        <td class="px-3 py-4 text-sm text-gray-500">{{ booking.notes }}</td>
        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
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
            // axios.delete(`/bookings/${booking.id}`);
            alert('not implemented: should delete booking')
        }
    },
}
</script>
