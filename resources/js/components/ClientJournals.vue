<template>
    <div class="bg-white rounded p-4">
        <div class="flex items-center space-x-4 mb-3">
            <h3>Journals</h3>
            <button
                @click="showJournalForm = true"
                type="button"
                class="btn btn-secondary">New entry
            </button>
        </div>

        <journal-form
            class="mb-4"
            v-if="showJournalForm"
            :client-id="clientId"
            @close="showJournalForm = false"
            @created="handleCreatedJournal"
        />

        <template v-if="journals.length > 0">
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(journal, index) in journals" :key="journal.id">
                        <td>{{ journal.id }}</td>
                        <td>{{ journal.date }}</td>
                        <td>{{ journal.content }}</td>
                        <td>
                            <button
                                class="btn btn-danger btn-sm"
                                @click="deleteJournal(journal, index)">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </template>

        <template v-else>
            <p class="text-center">The client has no journals.</p>
        </template>

        <div v-if="isLoadingJournals">
            <p class="text-center">Loading journals...</p>
        </div>

        <base-pagination
            v-if="pagination.last_page > 1"
            class="mt-4"
            @navigate="handleNavigate"
            :pagination="pagination"/>
    </div>
</template>

<script>
import axios from "axios";
import BasePagination from "./BasePagination";
import JournalForm from "./JournalForm";

export default {
    components: {BasePagination, JournalForm},
    props: {
        clientId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            showJournalForm: false,
            journals: [],
            pagination: {},
            isLoadingJournals: false,
            currentUrl: `/clients/${this.clientId}/journals`
        }
    },
    beforeMount() {
        this.loadJournals();
    },
    watch: {
        currentUrl(newUrl) {
            this.loadJournals(newUrl);
        },
        timeFilter(time) {
            this.loadJournals(this.pagination.path, {time: time});
        }
    },
    methods: {
        loadJournals(url = this.currentUrl, params = {}) {
            this.isLoadingJournals = true;
            axios.get(url, {params})
                .then(({data}) => {
                    this.journals = data.data;
                    this.pagination = data.meta;
                })
                .finally(() => this.isLoadingJournals = false);
        },
        handleNavigate(url) {
            this.currentUrl = url;
        },
        handleCreatedJournal(journal) {
            this.journals.unshift(journal);
        },
        deleteJournal(journal, index) {
            if (confirm(`Are you sure you want to delete journal: #${journal.id}?`)) {
                axios.delete(`/clients/${journal.client_id}/journals/${journal.id}`)
                    .then(() => this.journals.splice(index, 1));
            }
        }
    }
}
</script>
