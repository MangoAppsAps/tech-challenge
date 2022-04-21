<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ 'Login' }}</div>

                    <div class="card-body">
                        <form action="#" @submit.prevent="login">
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ 'E-Mail Address' }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" required autocomplete="email" autofocus v-model="formData.email">
                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ 'Password' }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" v-model="formData.password">
                                    <span class="invalid-feedback" role="alert"><strong></strong></span>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ 'Login' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
    name: 'Login',
        data() {
    return {
            formData: {
                email: '',
                password: ''
            }
        }
    },
    methods: {
        ...mapActions({
            LOGIN_HANDLE: 'auth/LOGIN_HANDLE'
        }),
        login() {
            this.clearErrors()

            this.LOGIN_HANDLE(this.formData).then(res => {
                this.$router.push('/')
            }).catch(err => {
                this.displayErrors(err)
            })
        },
    }
}
</script>
