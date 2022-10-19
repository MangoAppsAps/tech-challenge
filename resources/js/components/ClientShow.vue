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
                    <button
                        :class="['btn', currentTab === 'bookings' ? 'btn-primary' : 'btn-default']"
                        @click="switchTab('bookings')">
                        Bookings
                    </button>
                    <button
                        :class="['btn', currentTab === 'journals' ? 'btn-primary' : 'btn-default']"
                        @click="switchTab('journals')">
                        Journals
                    </button>
                </div>

                <client-bookings v-if="currentTab === 'bookings'" :client-id="client.id"/>
                <client-journals v-if="currentTab === 'journals'" :client-id="client.id"/>
            </div>
        </div>
    </div>
</template>

<script>
import ClientBookings from "./ClientBookings";
import ClientJournals from "./ClientJournals";

export default {
    name: 'ClientShow',
    components: {
        ClientBookings,
        ClientJournals
    },

    props: {
        client: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            currentTab: 'bookings',
        }
    },

    methods: {
        switchTab(newTab) {
            this.currentTab = newTab;
        },
    }
}
</script>
