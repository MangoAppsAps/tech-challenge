<template>
    <div>
        <h1 class="mb-6">Bookings -> Add New Booking for client {{ client.name }}</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="start">Start date</label>
                <input type="date" id="start" class="form-control" v-model="booking.start">
            </div>
            <div class="form-group">
                <label for="end">End date</label>
                <input type="date" id="end" class="form-control" v-model="booking.end">
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <input type="text" id="notes" class="form-control" v-model="booking.notes">
            </div>

            <div class="text-right">
                <a :href="`/clients/${client.id}`" class="btn btn-default">Cancel</a>
                <button @click="storeBooking" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'BookingForm',

    props: ['client'],

    data() {
        return {
            booking: {
                start: '',
                end: '',
                notes: '',
            }
        }
    },

    methods: {
        storeBooking() {
            axios.post(`/clients/${this.client.id}/bookings`, this.booking)
                .then(() => {
                    window.location.href = `/clients/${this.client.id}`;
                });
        }
    }
}
</script>
