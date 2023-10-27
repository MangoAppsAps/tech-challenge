<template>
    <div>
        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" class="form-control" v-model="journal.date">
                <small v-if="Object.keys(errors).includes('date')">{{ errors.date.join(' ') }}</small>
            </div>
            <div class="form-group">
                <label for="text">Text</label>
                <textarea id="text" class="form-control" v-model="journal.text"></textarea>
                <small v-if="Object.keys(errors).includes('text')">{{ errors.text.join(' ') }}</small>
            </div>
            <div class="text-right">
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'JournalForm',

    props: ['client-id'],

    data() {
        return {
            journal: {
                date: '',
                text: '',
            },
            errors: {},
        }
    },

    mounted() {
        this.journal.date = (new Date()).toLocaleDateString('sv-SE')
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.clientId}/journal`, this.journal)
                .then((data) => {
                    window.location.href = `/clients/${this.clientId}?tab=journals`;
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        }
    }
}
</script>