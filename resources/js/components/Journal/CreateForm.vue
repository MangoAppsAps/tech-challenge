<template>
    <div>
        <breadcrumbs>Clients -> Journals -> Add New Journal</breadcrumbs>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" class="form-control" v-model="form.date">
                <span v-if="validation_errors.date" class="mt-2 text-sm text-red-500">{{ validation_errors.date[0] }}</span>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" class="form-control" v-model="form.description" rows="6"></textarea>
                <span v-if="validation_errors.description" class="mt-2 text-sm text-red-500">{{ validation_errors.description[0] }}</span>
            </div>

            <div class="text-right">
                <button @click="window.history.back()" class="btn btn-default">Cancel</button>
                <button @click="storeJournal" class="btn btn-primary">Create</button>
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
            form: {
                date: '',
                description: '',
            },
            validation_errors: {}
        }
    },

    methods: {
        storeJournal() {
            axios.post('/clients/' + this.client.id + '/journals', this.form)
                .then((data) => {
                    window.location.href = data.data.url;
                })
                .catch((err) => {
                    this.validation_errors = err.response.data.errors;
                })
        }
    }
}
</script>
