<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" @input="clearErrorMessage" class="form-control" v-model="client.name">
                <div v-if="errorMessage.name" class="error-message">
                    {{ errorMessage.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" @input="clearErrorMessage" class="form-control" v-model="client.email">
                <div v-if="errorMessage.email_or_phone" class="error-message">
                    {{ errorMessage.email_or_phone[0] }}
                </div>
                <div v-else-if="errorMessage.email" class="error-message">
                    {{ errorMessage.email[0] }}
                </div>
             </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" @input="clearErrorMessage" class="form-control" v-model="client.phone">
                <div v-if="errorMessage.email_or_phone" class="error-message">
                    {{ errorMessage.email_or_phone[0] }}
                </div>
                <div v-else-if="errorMessage.phone" class="error-message">
                    {{ errorMessage.phone[0] }}
                </div>
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
            },
            errorMessage: '',
        }
    },

    methods: {
        storeClient(event) {
            event.preventDefault();

            axios.post('/clients', this.client)
                .then((data) => {
                    console.log(data.data);
                    alert('Client created!');
                    window.location.href = '/clients';
                })
                .catch((error) => {
                    console.log('error')
                    if (error.response && error.response.status === 422) {
                        this.errorMessage = error.response.data.errors;
                    } else {
                        this.errorMessage = 'An error occurred while submitting the form.';
                        }
                });
        },

        clearErrorMessage() {
            this.errorMessage = '';
        }
    }
}
</script>
