<template>
    <div>
        <h1 class="mb-6">Journals -> Add New Journal</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="note">Note</label>
                <input type="text" id="name" class="form-control" v-model="journal.note">
            </div>

            <div class="text-right">
                <a href="/journals" class="btn btn-default">Cancel</a>
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
                note: '',
            }
        }
    },

    methods: {
        storeJournal() {
            
            const url = window.location.href.replace('/create', '');
            const sub_url = url.split('/');
            const client_id = sub_url[sub_url.indexOf('clients') + 1];
            axios.post(url, {
                client_id: client_id,
                note: this.journal.note,
                })
                .then((data) => {
                    console.log(data);
                    alert('Journal created successfully');
                    window.location.href = url.replace('/journal', '');
                });
        }
    }
}
</script>
