<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="client.name">
                <div v-if="errors.name && errors.name.length" class="bg-red-300 mt-1">
                    <div v-for="error in errors.name">{{ error }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" v-model="client.email">
                <div v-if="errors.email && errors.email.length" class="bg-red-300 mt-1">
                    <div v-for="error in errors.email">{{ error }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" v-model="client.phone">
                <div v-if="errors.phone && errors.phone.length" class="bg-red-300 mt-1">
                    <div v-for="error in errors.phone">{{ error }}</div>
                </div>
            </div>
            <div class="form-group">
                <label for="name">Address</label>
                <input type="text" id="address" class="form-control" v-model="client.address">
                <div v-if="errors.address && errors.address.length" class="bg-red-300 mt-1">
                    <div v-for="error in errors.address">{{ error }}</div>
                </div>
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" v-model="client.city">
                    <div v-if="errors.city && errors.city.length" class="bg-red-300 mt-1">
                        <div v-for="error in errors.city">{{ error }}</div>
                    </div>
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" class="form-control" v-model="client.postcode">
                    <div v-if="errors.postcode && errors.postcode.length" class="bg-red-300 mt-1">
                        <div v-for="error in errors.postcode">{{ error }}</div>
                    </div>
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
            client: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                postcode: '',
            },
            errors: {
                name: [],
                email: [],
                phone: [],
                address: [],
                city: [],
                postcode: [],
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
                await axios.post('/clients', this.client)
                .then((data) => {
                    window.location.href = data.data.url;
                });
            } catch (e) {
                this.errors = e.response.data.errors
            }

        }
    }
}
</script>
