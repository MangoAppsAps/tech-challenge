// Middlewares
import guestMiddleware from '../../middlewares/guestMiddleware'

export default [
    {
        path: '/login',
        name: 'login',
        component: () => import('../../views/auth/Login.vue'),
        meta: {
            middleware: [guestMiddleware]
        },
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('../../views/auth/Register.vue'),
        meta: {
            middleware: [guestMiddleware]
        },
    },
]
