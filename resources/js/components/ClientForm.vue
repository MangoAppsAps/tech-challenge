<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" :class="{ 'form-control--has-error': errors.name }"
                    required v-model="client.name" />
                <small v-if="errors.name" class="form-control--error">{{ errors.name }}</small>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" :class="{ 'form-control--has-error': errors.email }"
                    v-model="client.email" />
                <small v-if="errors.email" class="form-control--error">{{ errors.email }}</small>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" class="form-control" :class="{ 'form-control--has-error': errors.phone }"
                    v-model="client.phone" />
                <small v-if="errors.phone" class="form-control--error">{{ errors.phone }}</small>
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
                <small v-if="errors.phoneOrEmail" class="form-control--error">{{ errors.phoneOrEmail }}</small>
                <a href="/clients" class="btn btn-default">Cancel</a>
                <button @click="storeClient" class="btn btn-primary" :class="{ 'btn-disabled': formHasErrors }"
                    :disabled="formHasErrors">Create</button>
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
            emailRegex: /^[\w\-\.]+@([\w-]+\.)+[\w-]{2,}$/,
            phoneRegex: /^\+?[\d\s]+$/,
            errors: {
                name: '',
                email: '',
                phone: '',
                phoneOrEmail: '',
            },
            formHasErrors: true
        }
    },

    methods: {
        storeClient() {
            axios.post('/clients', this.client)
                .then((data) => {
                    window.location.href = data.data.url;
                });
        }
    },

    watch: {
        client: {
            handler: function (val, oldVal) {
                if (!val.name) { // Name is required
                    this.errors.name = "Name required.";
                    this.formHasErrors = true;
                } else if (val.name && val.name.length > 190) { // Name must not be over 190 characters
                    this.errors.name = "Name must be under 190 characters.";
                    this.formHasErrors = true;
                } else this.errors.name = '';

                if (val.email && !this.emailRegex.test(val.email)) { // Email must be valid
                    this.errors.email = "Not a valid email.";
                    this.formHasErrors = true;
                } else this.errors.email = '';

                if (val.phone && !this.phoneRegex.test(val.phone)) { // Phone must contain only numbers, plus signs, and/or spaces
                    this.errors.phone = "Phone number may only contain numbers, plus signs, and spaces.";
                    this.formHasErrors = true;
                } else this.errors.phone = '';

                if (![this.client.email, this.client.phone].some(item => item)) { // either phone or email must be filled
                    this.errors.phoneOrEmail = "Must fill out either phone or email."
                    this.formHasErrors = true;
                } else this.errors.phoneOrEmail = '';

                if (Object.values(this.errors).every(item => item === '')) { // Finally, check if any form errors are still active
                    this.formHasErrors = false;
                }

            },
            deep: true,
        }
    }
}
</script>

<style scoped>
.form-control--has-error {
    border-bottom: 1px solid red;
}

.form-control--error {
    color: red;
}

.btn.btn-disabled {
    cursor: auto;
}
</style>
