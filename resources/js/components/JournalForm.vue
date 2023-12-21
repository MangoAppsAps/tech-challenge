<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Notes</label>
                <textarea type="text" id="notes" class="form-control" v-model="journal.notes"></textarea>
            </div>

            <div class="text-right">
                <a :href="`/clients/${client.id}`" class="btn btn-default">Cancel</a>
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
                notes: '',
            }
        }
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then((data) => {
                    window.location.href = data.data.client_url;
                });
        }
    }
}
</script>
