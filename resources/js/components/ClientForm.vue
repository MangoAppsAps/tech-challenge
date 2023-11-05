<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" v-model="client.name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" v-model="client.email" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" v-model="client.phone" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input id="address" v-model="client.address" type="text" class="form-control">
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input id="city" v-model="client.city" type="text" class="form-control">
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input id="postcode" v-model="client.postcode" type="text" class="form-control">
                </div>
            </div>

            <div class="text-right">
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button class="btn btn-primary" @click="storeClient">Create</button>
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
            axios.post('/clients', this.client)
                .then((data) => {
                    window.location.href = data.data.url;
                });
        }
    }
}
</script>
