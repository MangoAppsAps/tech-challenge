<template>
    <div>
        <ul>
            <li v-for="error in errors">
                {{ error }}
            </li>
        </ul>

        <h1 class="mb-6">Clients -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="text">Text</label>
                <textarea type="text" id="text" class="form-control" v-model="journal.text"></textarea>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" class="form-control" v-model="journal.date">
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
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
                text: '',
                date: ''
            },
            errors: {}
        }
    },

    methods: {
        storeJournal() {
            this.errors = {};

            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then((data) => {
                    window.location.href = this.client.url;
                }).catch((errors) => {
                if (errors.response.status === 422) {
                    this.errors = errors.response.data.errors
                } else {
                    alert('Something unpredictable happened. Please, kick developer.')
                }
            });
        }
    }
}
</script>
