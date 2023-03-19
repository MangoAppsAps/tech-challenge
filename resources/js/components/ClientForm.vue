<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <form @submit.prevent="storeClient">
            <div class="max-w-lg mx-auto">
                <ul class="my-8 list-disc text-red-500 ml-3">
                    <li v-for="e in errors">{{ e }}</li>
                </ul>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="form-control" v-model="client.name" maxlength="190" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" v-model="client.email">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" class="form-control" v-model="client.phone" pattern="^\+?[0-9\s]+$">
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
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </form>
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
            this.errors = [];
            if (!this.validate())
                return;
            axios.post('/clients', this.client)
                .then((data) => {
                    window.location.href = data.data.url;
                }).catch(err => {
                    if (err.response.status != 422) throw err

                    this.errors = Object.values(err.response.data.errors).flat()
                });
        },
        validate() {
            if (!this.client.email.trim() && !this.client.phone.trim()) {
                this.errors = ['At least email or phone should be given.'];
                return false;
            }

            return true;
        }
    }
}
</script>
