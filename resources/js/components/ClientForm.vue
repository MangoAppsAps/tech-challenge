<template>
    <div>
        <h1 class="mb-6">Clients -> Add New Client</h1>

        <div class="max-w-lg mx-auto">
            <div class="form-group">
                <label for="name">{{ 'Name' }}</label>
                <input type="text" id="name" class="form-control" v-model="formData.name">
                <span class="invalid-feedback" role="alert"><strong></strong></span>
            </div>
            <div class="form-group">
                <label for="email">{{ 'Email' }}</label>
                <input type="text" id="email" class="form-control" v-model="formData.email">
                <span class="invalid-feedback" role="alert"><strong></strong></span>
            </div>
            <div class="form-group">
                <label for="phone">{{ 'Phone' }}</label>
                <input type="text" id="phone" class="form-control" v-model="formData.phone">
                <span class="invalid-feedback" role="alert"><strong></strong></span>
            </div>
            <div class="form-group">
                <label for="name">{{ 'Address' }}</label>
                <input type="text" id="address" class="form-control" v-model="formData.address">
                <span class="invalid-feedback" role="alert"><strong></strong></span>
            </div>
            <div class="flex">
                <div class="form-group flex-1">
                    <label for="city">{{ 'City' }}</label>
                    <input type="text" id="city" class="form-control" v-model="formData.city">
                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                </div>
                <div class="form-group flex-1">
                    <label for="postcode">{{ 'Postcode' }}</label>
                    <input type="text" id="postcode" class="form-control" v-model="formData.postcode">
                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                </div>
            </div>

            <div class="text-right">
                <router-link :to="{name: 'clients'}" v-slot="{ href, navigate }" custom>
                    <a :href="href" @click="navigate" class="btn btn-default">{{ 'Cancel' }}</a>
                </router-link>
                <button @click="storeClient" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
    name: 'ClientForm',
    data() {
        return {
            formData: {
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
        ...mapActions({
            CLIENTS_STORE_HANDLE: 'clients/CLIENTS_STORE_HANDLE'
        }),
        storeClient() {
            this.clearErrors()

            this.CLIENTS_STORE_HANDLE(this.formData).then(res => {
                if (!res) return

                this.$toasted.success(res.data.message)

                this.$router.push({name: 'clients-show', params: {id: res.data.data.id}})
            }).catch(err => {
                this.displayErrors(err)
            })
        }
    }
}
</script>
