<template>
    <div>
        <h1 class="mb-6">{{ 'Clients' }} -> {{ client.name }}</h1>

        <div class="flex">
            <div class="w-1/3 mr-5">
                <div class="w-full bg-white rounded p-4">
                    <h2>{{ 'Client Info' }}</h2>
                    <table>
                        <tbody>
                            <tr>
                                <th class="text-gray-600 pr-3">{{ 'Name' }}</th>
                                <td>{{ client.name }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">{{ 'Email' }}</th>
                                <td>{{ client.email }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">{{ 'Phone' }}</th>
                                <td>{{ client.phone }}</td>
                            </tr>
                            <tr>
                                <th class="text-gray-600 pr-3">{{ 'Address' }}</th>
                                <td>{{ client.address }}<br/>{{ client.postcode + ' ' + client.city }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-2/3">
                <div>
                    <button class="btn" :class="{'btn-primary': currentTab == 'bookings', 'btn-default': currentTab != 'bookings'}" @click="switchTab('bookings')">{{ 'Bookings' }}</button>
                    <button class="btn" :class="{'btn-primary': currentTab == 'journals', 'btn-default': currentTab != 'journals'}" @click="switchTab('journals')">{{ 'Journals' }}</button>
                </div>

                <!-- Bookings -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'bookings'">
                    <h3 class="mb-3">{{ 'List of client bookings' }}</h3>

                    <template v-if="client.bookings && client.bookings.length > 0">
                        <div class="form-group" >
                            <label for="exampleFormControlSelect1">{{ 'Filter bookings' }}</label>
                                <select class="form-control" id="filterBookings" @change="refreshData" v-model="filterBookings">
                                    <option value="all">{{ 'All bookings' }}</option>
                                    <option value="future">{{ 'Future Bookings only' }}</option>
                                    <option value="past">{{ 'Past bookings only' }}</option>
                                </select>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ 'Time' }}</th>
                                    <th>{{ 'Notes' }}</th>
                                    <th>{{ 'Actions' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in client.bookings" :key="booking.id">
                                    <td>{{ booking.start }} to {{ booking.end }}</td>
                                    <td>{{ booking.notes }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteBooking(booking.id)">{{ 'Delete' }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>

                    <template v-else>
                        <p class="text-center">{{ 'The client has no bookings.' }}</p>
                    </template>

                </div>

                <!-- Journals -->
                <div class="bg-white rounded p-4" v-if="currentTab == 'journals'">
                    <h3 class="mb-3">{{ 'List of client journals' }}</h3>

                    <h3 class="mb-6">{{ 'Add new journal' }}</h3>

                    <div class="form-group">
                        <label for="journal_content">{{ 'Journal content' }}</label>
                        <textarea rows="5" id="journal_content" class="form-control" v-model="journalData.journal_content"></textarea>
                        <span class="invalid-feedback" role="alert"><strong></strong></span>
                    </div>

                    <div class="text-right">
                        <button @click="createJournal" class="btn btn-primary">{{ 'Create journal' }}</button>
                    </div>

                    <template v-if="client.journals && client.journals.length > 0">
                        <table>
                            <thead>
                                <tr>
                                    <th>{{ 'Date' }}</th>
                                    <th>{{ 'Content' }}</th>
                                    <th>{{ 'Actions' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="journal in client.journals" :key="journal.id">
                                    <td>{{ journal.journal_date }}</td>
                                    <td>{{ journal.journal_content }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="deleteJournal(journal.id)">{{ 'Delete' }}</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                    <template v-else>
                        <p class="text-center">{{ 'The client has no journals.' }}</p>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'ClientShow',
    props: ['client'],
    data() {
        return {
            currentTab: 'bookings',
            filterBookings: 'all',
            journalData: {
                client_id: this.$route.params.id,
                journal_content: '',
            }
        }
    },
    methods: {
        ...mapActions({
            BOOKINGS_DESTROY_HANDLE: 'clients/BOOKINGS_DESTROY_HANDLE',
            JOURNALS_STORE_HANDLE: 'clients/JOURNALS_STORE_HANDLE',
            JOURNALS_DESTROY_HANDLE: 'clients/JOURNALS_DESTROY_HANDLE',
        }),
        switchTab(newTab) {
            this.currentTab = newTab;
        },
        deleteBooking(id) {
            this.BOOKINGS_DESTROY_HANDLE(id).then(res => {
                this.$toasted.success(res.data.message)

                this.$emit('refreshData', this.filterBookings)
            }).catch(err => {
                this.displayErrors(err)
            })
        },
        deleteJournal(id) {
            this.JOURNALS_DESTROY_HANDLE(id).then(res => {
                this.$toasted.success(res.data.message)

                this.$emit('refreshData', this.filterBookings)
            }).catch(err => {
                this.displayErrors(err)
            })
        },
        createJournal() {
            this.clearErrors()

            this.JOURNALS_STORE_HANDLE(this.journalData).then(res => {
                this.$toasted.success(res.data.message)

                this.$emit('refreshData', this.filterBookings)
            }).catch(err => {
                this.displayErrors(err)
            })
        },
        refreshData() {
            this.$emit('refreshData', this.filterBookings)
        },
    }
}
</script>
