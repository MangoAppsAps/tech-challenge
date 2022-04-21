<template>
    <div class="dsdsadsa">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link to="/" v-slot="{ href, navigate }" custom>
                    <a :href="href" @click="navigate" class="nav-link">{{ 'Tech Challenge' }}</a>
                </router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li v-if="authenticated">
                            <router-link :to="{name: 'clients'}" v-slot="{ href, navigate }" custom>
                                <a :href="href" @click="navigate" class="nav-link">{{ 'Clients' }}</a>
                            </router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <template v-if="!authenticated">
                            <li class="nav-item">
                                <router-link :to="{name: 'login'}" v-slot="{ href, navigate }" custom>
                                    <a :href="href" @click="navigate" class="nav-link">{{ 'Login' }}</a>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'register'}" v-slot="{ href, navigate }" custom>
                                    <a :href="href" @click="navigate" class="nav-link">{{ 'Register' }}</a>
                                </router-link>
                            </li>
                        </template>
                        <template v-else>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" @click.prevent="toggleDropdown">{{ user.name }}</a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" :style="{ display: dropDownClass }">
                                    <button @click.prevent="logout" class="dropdown-item">
                                        {{ 'Logout' }}
                                    </button>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view :key="$route.fullPath"></router-view>
        </main>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'Main',
    data() {
        return {
            dropDownClass: 'none'
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user'
        }),
    },
    methods: {
        ...mapActions({
            LOGOUT_HANDLE: 'auth/LOGOUT_HANDLE'
        }),
        logout() {
            this.LOGOUT_HANDLE().then(res => {
                this.$router.replace({name: 'login'})
            })
        },
        toggleDropdown() {
            this.dropDownClass = this.dropDownClass == 'none' ? 'block' : 'none'
        }
    }
}
</script>
