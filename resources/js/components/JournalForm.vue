<template>
    <div>
        <h1 class="mb-6">Client Journals -> Add New Journal</h1>

        <div v-if="showErrors" class="alert alert-danger">
            <ul>
                <li v-for="(messages, field) in validationErrors" :key="field">
                    {{ messages.join(', ') }}
                </li>
            </ul>
        </div>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" class="form-control" v-model="journal.date">
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" placeholder="Add the content here" id="content" v-model="journal.content"></textarea>
            </div>

            <div class="text-right">
                <a :href="`/clients/${clientId}/journals/create`" class="btn btn-default">Cancel</a>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'JournalForm',

    props: ['clientId'],

    data() {
        return {
            journal: {
                date: '',
                content: '',
                client_id: '',
            },
            validationErrors: {},
            showErrors: false,
        }
    },

    methods: {
        storeJournal() {
            axios.post(`/clients/${this.clientId}/journals/create`, this.journal)
                .then((data) => {
                    window.location.href = `/clients/${this.clientId}`;
                }).catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        this.showErrors = true;
                    }
                });
        }
    }
}
</script>
