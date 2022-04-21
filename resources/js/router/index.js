import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store'

Vue.use(VueRouter)

// Middlewares
import authMiddleware from '../middlewares/authMiddleware'

// Pipeline
import middlewarePipeline from './pipeline'

// Routes
import auth from './auth'
import clients from './clients'

// Main view
import Main from '../layouts/Main.vue'

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior() {
        return { x: 0, y: 0 }
    },
    routes: [
        {
            path: '/',
            component: Main,
            children: [
                ...auth,
                ...clients
            ],
            meta: {
                middleware: [authMiddleware]
            }
        },
    ],
})

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next()
    }

    const middleware = to.meta.middleware

    const context = {
        to,
        from,
        next,
        store
    }

    if (middleware.length === 1) {
        return middleware[0]({
            ...context,
        })
    } else {
        return middleware[0]({
            ...context,
            next: middlewarePipeline(context, middleware, 1)
        })
    }
})

export default router
