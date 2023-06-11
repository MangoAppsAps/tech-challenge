<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" v-model="client.name" v-validate="'required|max:190'">
                <span v-show="errors.has('name')" class="text-red-800">{{ errors.first('name') }}</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" v-model="client.email" v-validate="client.phone ? 'email' : 'required|email'">
                <span v-show="errors.has('email')" class="text-red-800">{{ errors.first('email') }}</span>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" v-model="client.phone" v-validate="{ required: !client.email, regex: /^\+?[0-9\s]+$/ }">
                <span v-show="errors.has('phone')" class="text-red-800">{{ errors.first('phone') }}</span>
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
            this.$validator.validate().then(valid => {
                if (valid) {
                    axios.post('/clients', this.client)
                        .then((data) => {
                            window.location.href = data.data.url;
                        });
                }
            });
        }
    }
}
</script>
