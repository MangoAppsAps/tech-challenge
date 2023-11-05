<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">Name *</label>
                <input id="name" v-model="client.name" type="text" class="form-control">
                <p v-if="nameError" class="text-red-500">{{ nameError }}</p>
            </div>
            <div class="form-group">
                <label for="email">Email (*)</label>
                <input id="email" v-model="client.email" type="email" class="form-control" @input="onContactFieldInput" @blur="onEmailFieldBlur">
                <p v-if="contactError" class="text-red-500">{{ contactError }}</p>
                <p v-else-if="emailError" class="text-red-500">{{ emailError }}</p>
            </div>
            <div class="form-group">
                <label for="phone">Phone (*)</label>
                <input id="phone" v-model="client.phone" type="tel" class="form-control" @input="onContactFieldInput">
                <p v-if="contactError" class="text-red-500">{{ contactError }}</p>
                <p v-else-if="phoneError" class="text-red-500">{{ phoneError }}</p>
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
            <div class="flex">
                <div class="flex-1 flex items-center">
                    <p v-if="serverError" class="text-red-500">Internal server error</p>
                </div>
                <div>
                    <a href="/clients" class="btn btn-default">Cancel</a>
                    <button class="btn btn-primary" @click="storeClient">Create</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { isValidEmailAddress, isValidPhoneNumber } from '../utils/ValidationUtils';
import axios from 'axios';

const NAME_ERROR_MESSAGE = 'Please enter a name between 0 and 190 characters.';
const EMAIL_ERROR_MESSAGE = 'Please enter a valid email address';
const PHONE_ERROR_MESSAGE = 'Please enter a valid phone number including only digits, spaces and plus signs';
const CONTACT_ERROR_MESSAGE = 'An email address or a phone number is required';

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
            nameError: null,
            emailError: null,
            phoneError: null,
            contactError: null,
            serverError: null,
        }
    },

    watch: {
        'client.name': function () {
            this.validateClientName();
        },
        'client.phone': function () {
            this.validateClientPhone()
        },
        'client.email': function () {
            // We do not want to validate the email address "on the fly" if
            // the error is not already set, as that would always show an 
            // error when the users starts typing. The "on blur" event
            // is handling the initial validation of the email field.
            if (this.emailError !== null) {
                this.validateClientEmail()
            }
        },
    },


    methods: {
        storeClient() {
            if (!this.allowSubmit()) {
                return;
            }

            axios.post('/clients', this.client)
                .then((data) => {
                    window.location.href = data.data.url;
                }).catch((e) => {
                    // TODO: Handle these server errors in a better way.
                    if(e.response.status === 422) {
                        // Server side validation error
                        const errors = e.response.data.errors ?? null;
                        if (errors) {
                            this.nameError = errors.name[0] ?? null;
                            this.emailError = errors.email[0] ?? null;
                            this.phoneError = errors.phone[0] ?? null;
                        }
                    } else {
                        this.serverError = true;
                    }

                });
        },
        /**
         * Event listener for the blur event on the email field.
         * Validates the value whenever the focus is moved from the field.
         * 
         * @returns {void}
         */
        onEmailFieldBlur() {
            this.validateClientEmail();
        },
        /**
         * Event listener for when a "contact information" field
         * is changed. Clears the contact information error.
         * 
         * @returns {void}
         */
         onContactFieldInput() {
            this.contactError = null;
        },
        /**
         * Validates the client name and sets and error
         * message if not valid.
         * 
         * @returns {boolean}
         */
         validateClientName() {
            if(0 < this.client.name.length && this.client.name.length <= 190){
                this.nameError = null;
                return true;
            }

            this.nameError = NAME_ERROR_MESSAGE;
            return false;
        },
        /**
         * Validates the client phone and sets and error
         * message if not valid.
         * 
         * @returns {boolean}
         */
        validateClientPhone() {
            const valid = isValidPhoneNumber(this.client.phone);
            // Note: An empty phone is considered valid in this context
            //       as it is not required if an email address is set.
            if(valid || this.client.phone === ''){
                this.phoneError = null;
                return true;
            }

            this.phoneError = PHONE_ERROR_MESSAGE;
            return false;

        },
        /**
         * Validates the client email and sets and error
         * message if not valid.
         * 
         * @returns {boolean}
         */
        validateClientEmail() {
            const valid = isValidEmailAddress(this.client.email);
            // Note: An empty email is considered valid in this context
            //       as it is not required if a phone number is set.
            if(valid || this.client.email === ''){
                this.emailError = null;
                return true;
            }

            this.emailError = EMAIL_ERROR_MESSAGE;
            return false;
        },
        /**
         * Validates the clients contact infromation and sets 
         * and error message if not valid.
         * 
         * @returns {boolean}
         */
         validateClientContact() {
            if(this.client.email !== '' || this.client.phone !== ''){
                this.contactError = null;
                return true;
            }
           
            this.contactError = CONTACT_ERROR_MESSAGE;
            return false;
        },
        /**
         * Validate the client data and checks if there are any errors.
         * 
         * @returns {boolean}
         */
         allowSubmit() {
            // Run all the validation funcions.
            // Note: This might not be necessary every time because
            //       they are validated "on the fly", but it will 
            //       prevents a server request from being sent
            //       if the user click 'create' at the start.
            this.validateClientName();
            this.validateClientEmail();
            this.validateClientPhone();
            this.validateClientContact();

            return (
                this.nameError === null &&
                this.emailError === null && 
                this.phoneError === null && 
                this.contactError === null
            );
        }
    }
}
</script>
