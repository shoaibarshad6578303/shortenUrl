import { createRouter, createWebHistory } from 'vue-router'
 
import UrlIndex from '@/components/urls/UrlIndex.vue'


 
const routes = [
    {
        path: '/',
        name: 'urls.index',
        component: UrlIndex
    },
    
];
 
export default createRouter({
    history: createWebHistory(),
    routes
})