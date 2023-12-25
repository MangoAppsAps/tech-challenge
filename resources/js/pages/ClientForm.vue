<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name</label>
                <input v-model="client.name"
                       :class="[hasErrors('name') ? 'is-invalid' : '']"
                       type="text"
                       id="name"
                       class="form-control">

                <div v-for="(error, index) in getFieldErrors('name')" :key="index" class="invalid-feedback">
                    {{ error }}
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input v-model="client.email"
                       :class="[hasErrors('email') ? 'is-invalid' : '']"
                       type="text"
                       id="email"
                       class="form-control">
                <div v-for="(error, index) in getFieldErrors('email')" :key="index" class="invalid-feedback">
                    {{ error }}
                </div>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input v-model="client.phone"
                       :class="[hasErrors('phone') ? 'is-invalid' : '']
                       "type="text"
                       id="phone"
                       class="form-control">
                <div v-for="(error, index) in getFieldErrors('phone')" :key="index" class="invalid-feedback">
                    {{ error }}
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

        <Toast
            v-if="toast.show"
            :message="toast.message"
            :type="toast.type"
            @closeToast="closeToast"
        />

    </div>
</template>

<script>
import axios from 'axios';
import Toast from "../components/Toast";
import toast from "../mixins/toast";

export default {
    name: 'ClientForm',

    mixins: [toast],

    components: {
        Toast,
    },

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
            errors: {},
        }
    },

    methods: {
        async storeClient() {
            try {
                this.errors = {};

                const result = await axios.post('/clients', this.client)

                window.location.href = result.data.url;
            } catch (error) {
                if (error.response?.data?.errors) {
                    // Handle backend validation errors
                    this.errors = error.response.data.errors;
                } else {
                    this.showToast(error.message, 'error');
                }
            }
        },

        hasErrors(field) {
            return field in this.errors;
        },

        getFieldErrors(field) {
            const errors = [];

            if (this.hasErrors(field)) {
                return this.errors[field];
            }

            return errors;
        }
    }
}
</script>
