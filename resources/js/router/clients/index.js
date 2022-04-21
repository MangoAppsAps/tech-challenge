// Middlewares
import authMiddleware from '../../middlewares/authMiddleware'

export default [
    {
        path: '/clients',
        name: 'clients',
        component: () => import('../../views/clients/Clients.vue'),
        meta: {
            middleware: [authMiddleware]
        },
    },
    {
        path: '/clients/show/:id',
        name: 'clients-show',
        component: () => import('../../views/clients/Show.vue'),
        meta: {
            middleware: [authMiddleware]
        },
    },
    {
        path: '/clients/create',
        name: 'clients-create',
        component: () => import('../../views/clients/Create.vue'),
        meta: {
            middleware: [authMiddleware]
        },
    },
]
