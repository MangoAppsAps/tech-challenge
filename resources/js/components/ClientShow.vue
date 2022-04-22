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

                    <v-select :options="options"  v-model="filter" class="mb-3"></v-select>

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
                                <tr v-for="booking in bookings" :key="booking.id">
                                    <td>{{ formattTime(booking.start,booking.end) }}</td>
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
                    <h3 class="mb-3">
                        List of client journals
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
                        New Journal
                        </button>
                    </h3>
                    <template v-if="client.bookings && client.bookings.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in bookings" :key="booking.id">
                                    <td>{{ formattTime(booking.start,booking.end) }}</td>
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

                <!---Add Journal-->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">

                        <div class="modal-header">
                            <h4 class="modal-title">New Journal</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class='col-sm-6'>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type='date' v-model="date" class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control" v-model="notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" @click="addJournal" data-dismiss="modal">Add</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment'
export default {
    name: 'ClientShow',

    props: ['client'],

    data() {
        return {
            currentTab: 'bookings',
            options: ["All bookings", "Future bookings only" ,"Past bookings only"],
            filter:"All bookings",
            date: '',
            notes: '',
        }
    },

    computed: {
        bookings(){
            const now = moment()
            if(this.filter === 'Future bookings only'){
                return this.client.bookings.filter(booking => moment(booking.end).isAfter(now));
            }else if (this.filter === 'Past bookings only'){
                return this.client.bookings.filter(booking => moment(booking.end).isBefore(now));
            }
            return this.client.bookings
        }
    },

    methods: {
        addJournal() {
            // const payload = {
            //     date: this.date,
            //     notes: this.notes,
            //     client: this.client.id
            // }
            // axios.post(`/clients/journals`, payload);
        },
        switchTab(newTab) {
            this.currentTab = newTab;
        },

        deleteBooking(booking) {
            axios.delete(`/bookings/${booking.id}`);
        },

        formattTime(start, end){
            const dateValue = moment(start).format('dddd D MMMM  YYYY');
            const timeStart = moment(start,'HHmm').format("HH:mm");
            const timeEnd = moment(end, 'HHmm').format("HH:mm");
            return `${dateValue} ${timeStart} - ${timeEnd}`;
        }
    }
}
</script>
