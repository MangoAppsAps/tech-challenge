<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>
        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="client.name">
                <span v-if="!isValidName && formSubmitted">Name is required and must be up to 190 characters.</span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" class="form-control" v-model="client.email">
                <span v-show="!isValidEmail && formSubmitted">Enter a valid email address.</span>
                <span v-show="!hasRequiredField && formSubmitted">At least one of phone or email is required.</span>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" v-model="client.phone">
                <span v-show="!isValidPhone && formSubmitted">Phone can only contain digits, spaces, and a plus sign.</span>
                <span v-show="!hasRequiredField && formSubmitted">At least one of phone or email is required.</span>
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
    props: ['user_id'],
    data() {
        return {
            formSubmitted: false,
            client: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                postcode: '',
                userId: this.user_id
            }
        }
    },
    methods: {
        storeClient() {
            this.formSubmitted = true;
            if (this.isFormValid) {
                axios.post('/clients', this.client)
                    .then((data) => {
                        window.location.href = data.data.url;
                    });
            } else {
                console.log('form is not valid')
            }

        }
    },
    computed:{
        isValidName() {
            return this.client.name.trim() !== "" && this.client.name.length <= 190;
        },
        isValidEmail() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return this.client.email.trim() === "" || emailRegex.test(this.client.email);
        },
        isValidPhone() {
            const phoneRegex = /^[0-9+ ]*$/;
            return this.client.phone.trim() === "" || phoneRegex.test(this.client.phone);
        },
        hasRequiredField() {
            return this.client.phone.trim() !== "" || this.client.email.trim() !== "";
        },
        isFormValid() {
            return this.isValidName && this.isValidEmail && this.isValidPhone && this.hasRequiredField;
        },
    }
}
</script>
