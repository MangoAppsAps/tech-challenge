<template>
    <div>
        <div class="flex justify-between">
            <select v-model="filter" class="shadow-sm border border-gray-500 p-2 mb-4 bg-transparent">
                <option value="all">All journals</option>
                <option value="future">Future journals only</option>
                <option value="past">Past journals only</option>
            </select>
            <div>
                <a :href="`/clients/${this.client.id}/journals/create`" class="float-right btn btn-primary">+ New Journal</a>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th class="px-2">Text</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="journal in journals" :key="journal.id" class="border-bottom border-gray-500">
                <td class="text-nowrap">{{ journal.formatted_date }}</td>
                <td class="px-2">{{ journal.text }}</td>
                <td>
                    <button class="btn btn-danger btn-sm" @click="deleteJournal(journal)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'Journals',

    props: ['client'],

    data () {
        return {
            filter: 'all',
            baseJournals: [],
            journals: [],
        }
    },

    mounted () {
        this.baseJournals = _.clone(this.client.journals)
        this.applyFilter()
    },

    methods: {
        // breaking DRY to save time
        applyFilter() {
            let currentTime = Date.now() / 1000
            switch (this.filter) {
                case 'future':
                    this.journals = this.baseJournals.filter(journal => journal.date_stamp > currentTime)
                    break
                case 'past':
                    this.journals = this.baseJournals.filter(journal => journal.date_stamp <= currentTime)
                    break
                default:
                    this.journals = { ...this.baseJournals }
                    break
            }
        },
        async deleteJournal (journal) {
            try {
                await axios.delete(`/clients/${this.client.id}/journals/${journal.id}`)
                let key = _.findKey(this.journals, { id: journal.id })
                if (key) {
                    this.baseJournals.splice(key, 1)
                    this.applyFilter()
                }
            } catch (e) {
                console.log(e)
            }
        },
    },
    watch: {
        filter () {
            this.applyFilter()
        }
    }
}
</script>

<style scoped>

</style>
