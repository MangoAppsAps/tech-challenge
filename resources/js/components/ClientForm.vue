<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div v-if="errors.length">
                <b>Please correct the following error<span v-if="errors.length > 1">s</span>:</b>
                <ul>
                    <li v-for="fieldError in errors">{{ fieldError[0] }}: {{ fieldError[1].join(', ') }}</li>
                </ul>
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="client.name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" v-model="client.email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" v-model="client.phone">
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input type="text" id="address" class="form-control" v-model="client.address">
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" v-model="client.city">
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" class="form-control" v-model="client.postcode">
                </div>
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ClientForm',

    data() {
        return {
            errors: [],
            client: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                postcode: '',
            }
        }
    },

    methods: {
        storeClient() {
            this.errors = null;

            axios.post('/clients', this.client)
                .then((data) => {
                    window.location.href = data.data.url;
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = Object.entries(error.response.data.errors);
                    }
                });
        }
    }
}
</script>
