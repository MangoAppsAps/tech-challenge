<template>
    <div class="bg-white rounded p-4">
        <h3 class="mb-3">List of client bookings</h3>

        <div class="form-group w-48">
            <label for="timeFilter">Filter:</label>
            <select class="form-control" id="timeFilter" v-model="timeFilter">
                <option v-for="option in timeFilterOptions" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
        </div>

        <template v-if="bookings.length > 0">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Time</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="booking in bookings" :key="booking.id">
                        <td>{{ booking.id }}</td>
                        <td>{{ booking.interval }}</td>
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


        <div v-if="isLoadingBookings">
            <p class="text-center">Loading bookings...</p>
        </div>

        <base-pagination
            v-if="pagination.last_page > 1"
            class="mt-4"
            @navigate="handleNavigate"
            :pagination="pagination"/>
    </div>
</template>

<script>
import axios from "axios";
import BasePagination from "./BasePagination";

export default {
    components: {BasePagination},
    props: {
        clientId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            bookings: [],
            pagination: {},
            isLoadingBookings: false,
            currentUrl: `/clients/${this.clientId}/bookings`,
            timeFilterOptions: [
                {value: null, label: 'All bookings'},
                {value: 'future', label: 'Future bookings only'},
                {value: 'past', label: 'Past bookings only'},
            ],
            timeFilter: null
        }
    },
    beforeMount() {
        this.loadBookings();
    },

    watch: {
        currentUrl(newUrl) {
            this.loadBookings(newUrl);
        },
        timeFilter(time) {
            this.loadBookings(this.pagination.path, {time});
        }
    },
    methods: {
        loadBookings(url = this.currentUrl, params = {}) {
            this.isLoadingBookings = true;
            axios.get(url, {params})
                .then(({data}) => {
                    this.bookings = data.data;
                    this.pagination = data.meta;
                })
                .finally(() => this.isLoadingBookings = false);
        },
        handleNavigate(url) {
            this.currentUrl = url;
        },
        deleteBooking(booking, index) {
            if (confirm(`Are you sure you want to delete booking: #${booking.id}?`)) {
                axios.delete(`/clients/${booking.client_id}/bookings/${booking.id}`)
                    .then(() => this.bookings.splice(index, 1));
            }
        }
    }
}
</script>
