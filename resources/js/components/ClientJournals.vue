<template>
    <div>
        <h3 class="mb-3">
            List of client journals
            <button class="float-right btn btn-primary" @click="addJournalVisible = true">+ New Journal</button>
        </h3>

        <template v-if="journals && journals.length > 0">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th>Date</th>
                    <th>Content</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="journal in journals.slice().sort((a, b) => new Date(b.date) - new Date(a.date))" :key="journal.id">
                    <td>{{ formatDate(journal) }}</td>
                    <td>{{ journal.text }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" @click="destroy(journal)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>

        <template v-if="!journals.length && !addJournalVisible">
            <p class="text-center">The client has no journals.</p>
        </template>

        <template v-if="addJournalVisible">
            <div class="max-w-lg mx-auto">
                <div class="form-group">
                    <label for="name">Date</label>
                    <input type="date" id="date" class="form-control" v-model="journal.date">
                </div>
                <div class="form-group">
                    <label for="name">Content</label>
                    <textarea id="text" class="form-control" v-model="journal.text" rows="3" required></textarea>
                </div>

                <div class="text-right">
                    <button @click="addJournalVisible = false" class="btn btn-default">Cancel</button>
                    <button @click="store" class="btn btn-primary">Create</button>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import axios from 'axios';
import moment from "moment/moment";

export default {
    name: 'ClientJournals',

    props: ['client'],

    data() {
        return {
            addJournalVisible: false,
            journals: [],
            journal: {
                date: moment().format('YYYY-MM-DD'),
                text: '',
            },
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            axios.get(`/clients/${this.client.id}/journals`).then(response => {
                this.journals = response.data.data;
            });
        },

        formatDate(journal) {
            return moment.parseZone(journal.date).format('dddd D MMMM YYYY');
        },

        store() {
            axios.post(`/clients/${this.client.id}/journals`, this.journal)
                .then(response => {
                    this.journals.push(response.data.data);
                    this.addJournalVisible = false;
                }).finally(() => {
                    this.journal = {
                        date: moment().format('YYYY-MM-DD'),
                        text: '',
                    }
                });
        },

        destroy(journal) {
            axios.delete(`/clients/${this.client.id}/journals/${journal.id}`).then(() => {
                this.journals.splice(this.journals.indexOf(journal), 1);
            })
        },
    }
}
</script>
