import { createRouter, createWebHistory } from "vue-router";

const routes =[
    {
        path: '/',
        name: 'Dashboard',
        component: () => import('./pages/Dashboard.vue'),
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('./pages/Login.vue'),
    },
    {
        path: '/brand',
        name: 'Brand',
        component: () => import('./pages/Brand.vue'),
    },
    {
        path: '/category',
        name: 'Category',
        component: () => import('./pages/Category.vue'),
    },
    {
        path: '/supplier',
        name: 'Supplier',
        component: () => import('./pages/Supplier.vue'),
    },
    {
        path: '/product',
        name: 'Product',
        component: () => import('./pages/Product.vue'),
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Notfound',
        component: () => import('./pages/NotFound.vue'),
    },
];

export default createRouter({
    history: createWebHistory('/'),
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
})