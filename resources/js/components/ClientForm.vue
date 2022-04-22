<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <ValidationObserver v-slot="{ invalid }">
                <form @submit.prevent="storeClient">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <ValidationProvider name="name" rules="max:190|required" v-slot="{ errors }">
                            <input type="text" id="name" class="form-control" placeholder="Name is required and not greater than 190 characters " v-model="client.name">
                            <span style="color:red">{{ errors[0] }}</span>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <ValidationProvider name="email" rules="email|required" v-slot="{ errors }">
                            <input type="text" id="email" class="form-control" placeholder="Must be an email and required" v-model="client.email">
                            <span style="color:red">{{ errors[0] }}</span>
                        </ValidationProvider>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <ValidationProvider name="phone" :rules="{ regex: /(?=.*[0-9])[- +()0-9]+$/ }" v-slot="{ errors }">
                            <input type="text" id="phone" class="form-control" placeholder="Phone number,must be integers and a plus sign" v-model="client.phone">
                            <span style="color:red">{{ errors[0] }}</span>
                        </ValidationProvider>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
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
                        <button type="submit" class="btn btn-primary" :disabled="invalid">Create</button>
                    </div>
                </form>
            </ValidationObserver>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import  ValidationObserver from 'vee-validate';

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
