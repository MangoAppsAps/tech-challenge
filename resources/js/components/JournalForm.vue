<template>
    <div>
        <h1 class="mb-6">Add New Journal</h1>
        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Client</label>
                <input type="text" id="name" class="form-control" v-model="client.name" disabled>
            </div>
            <div class="form-group">
                <label for="name">Date</label>
                <input type="date" id="name" class="form-control" v-model="journal.date">
                <div v-if="errors.date && errors.date.length" class="bg-red-300 mt-1">
                    <div v-for="error in errors.date">{{ error }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Text</label>
                <textarea type="text" id="email" class="form-control" v-model="journal.text"></textarea>
                <div v-if="errors.text && errors.text.length" class="bg-red-300 mt-1">
                    <div v-for="error in errors.text">{{ error }}</div>
                </div>
            </div>

            <div class="text-right">
                <a :href="`/clients/${this.client.id}?tab=journals`" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientForm',

    props: ['client'],

    data() {
        return {
            journal: {
                date: '',
                text: '',
            },
            errors: {
                date: [],
                text: [],
            },
            errorsTemplate: {},
        }
    },

    mounted () {
        this.errorsTemplate = { ...this.errors }
    },

    methods: {
        async storeClient() {
            try {
                this.errors = { ...this.errorsTemplate }
                await axios.post(`/clients/${this.client.id}/journals`, this.journal)
                window.location.href = `/clients/${this.client.id}?tab=journals`
            } catch (e) {
                this.errors = e.response.data.errors
            }

        }
    }
}
</script>
