<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <form @submit.prevent="submit">
                <div class="form-group">
                    <label for="name">Name</label>
                    <FormInput type="text" id="name" v-model="client.name" :error="errors.name"/>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <FormInput type="email" id="email" v-model="client.email" :error="errors.email"/>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <FormInput type="text" id="phone" v-model="client.phone" :error="errors.phone"/>
                </div>
                <div class="form-group">
                    <label for="name">Address</label>
                    <FormInput type="text" id="address" v-model="client.address" :error="errors.address"/>
                </div>
                <div class="flex space-x-4">
                    <div class="form-group flex-1">
                        <label for="city">City</label>
                        <FormInput type="text" id="city" v-model="client.city" :error="errors.city"/>
                    </div>
                    <div class="form-group flex-1">
                        <label for="postcode">Postcode</label>
                        <FormInput type="text" id="postcode" v-model="client.postcode" :error="errors.postcode"/>
                    </div>
                </div>

                <div class="text-right">
                    <a href="/clients" class="btn btn-default">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import intus from 'intus';
import FormInput from "./FormInput";
import {isEmail, isMax, isRegex, isRequired, isRequiredWithout} from "intus/rules";

export default {
    name: 'ClientForm',
    components: {FormInput},
    data() {
        return {
            isSubmitting: false,
            errors: {},
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
        submit() {
            if (this.isSubmitting) return;

            const validation = intus.validate(this.client, {
                name: [isRequired(), isMax(190)],
                email: [isRequiredWithout('phone'), isEmail()],
                phone: [isRequiredWithout('email'), isRegex(/^[+]?[ ]*[0-9 ]*$/)],
            }, {
                "phone.isRegex": "Phone can only contain a plus sign, digits and spaces."
            });

            this.errors = validation.errors();

            if (validation.passes()) {
                this.isSubmitting = true;
                axios.post('/clients', this.client)
                    .then((data) => window.location.href = data.data.url)
                    .catch((error) => {
                        if (error.response.status === 422) {
                            let errors = error.response.data.errors;

                            for (let field in errors) {
                                errors[field] = errors[field][0];
                            }

                            this.errors = errors;
                        }
                    })
                    .finally(() => this.isSubmitting = false);
            }
        }
    }
}
</script>
