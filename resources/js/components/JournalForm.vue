<template>
    <div>
        <ol class="mb-6">
            <li class="breadcrumb-item"><a :href="`/clients/${client}`">Client</a></li>
            <li class="breadcrumb-item active">Add New Journal</li>
        </ol>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="name" class="form-control" required v-model="journal.date" />
            </div>
            <div class="form-group">
                <label for="entry">Entry</label>
                <textarea id="entry" class="form-control" v-model="journal.text" rows="8"></textarea>
            </div>


            <div class="text-right">
                <a :href="`/clients/${client}`" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'JournalForm',

    props: ['client'],

    data() {
        return {
            journal: {
                date: '',
                entry: '',
                client_id: this.client
            },
        }
    },

    methods: {
        async storeJournal() {
            await axios.post(`/clients/${this.client}/journals`, this.journal);
            window.location.href = `/clients/${this.client}`;
        }
    },
}
</script>

