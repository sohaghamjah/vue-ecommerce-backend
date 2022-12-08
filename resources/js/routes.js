import { createRouter, createWebHistory } from "vue-router";
import  AdminLayout from './pages/Index.vue';

const routes =[
    {
        path: '/login',
        name: 'Login',
        component: () => import('./pages/Login.vue'),
        meta:{
            requireAuth:false,
        }
    },
    {
        path: '/',
        name: 'Dashboard',
        component: () => import('./pages/Dashboard.vue'),
        meta:{
            requireAuth:true,
            layout: AdminLayout
        }
    },
    {
        path: '/brand',
        name: 'Brand',
        component: () => import('./pages/Brand.vue'),
        meta:{
            requireAuth:true,
            layout: AdminLayout
        }
    },
    {
        path: '/category',
        name: 'Category',
        component: () => import('./pages/Category.vue'),
        meta:{
            requireAuth:true,
            layout: AdminLayout
        }
    },
    {
        path: '/supplier',
        name: 'Supplier',
        component: () => import('./pages/Supplier.vue'),
        meta:{
            requireAuth:true,
            layout: AdminLayout
        }
    },
    {
        path: '/product',
        name: 'Product',
        component: () => import('./pages/Product.vue'),
        meta:{
            requireAuth:true,
            layout:AdminLayout,
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'Notfound',
        component: () => import('./pages/NotFound.vue'),
        meta:{
            requireAuth:false,
        }
    },
];

const router = createRouter({
    history: createWebHistory('/'),
    routes,
    linkActiveClass:"active",
    linkExactActiveClass:"exact-active"
});

router.beforeEach((to,from) => {
    if(to.meta.requireAuth && !localStorage.getItem('token'))
    {
        return {name:'Login'}
    }
    if(to.meta.requireAuth == false && localStorage.getItem('token'))
    {
        return {name:'Dashboard'}
    }
});

export default router;