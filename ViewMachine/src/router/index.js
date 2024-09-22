// vue路由

import { createRouter, createWebHistory } from 'vue-router'
import homePage from '@/views/homePage.vue'
import User_control from '@/components/user_control.vue'
import User_message from '@/components/user_message.vue'
import User_star from '@/components/user_star.vue'
import User from '@/views/user.vue'
import Search from '@/components/search.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'homePage',
            component: homePage,
            meta: {title: "粉糖粒子 - 幻想动物画廊"},
        },
        {
            path: '/enter',
            name: 'enter',
            component: ()=>import('@/views/enter.vue'),
            meta: {title: "幻想动物画廊 - 网站入口"},
        },
        {
            path: '/about',
            name: 'about',
            component: ()=>import('@/views/about.vue'),
            meta: {title: "幻想动物画廊 - 大门"},
        },
        {
            path: '/gallery',
            name: 'gallery',
            component: ()=>import('@/views/gallery.vue'),
            meta: {title: "幻想动物画廊 - 画廊"},
        },
        {
            path: '/user',
            name: 'user',
            component: User,
            meta: {title: "个兽空间 - 主页"},
            children: [
                {
                    path: 'control', // 域名/user/control
                    name: 'userControl',
                    component: User_control,
                },
                {
                    path: 'message',
                    name: 'userMessage',
                    component: User_message,
                },
                {
                    path: 'star',
                    name: 'userStar',
                    component: User_star,
                },
            ],
        },
        {
            path: '/garden',
            name: 'garden',
            component: ()=>import('@/views/garden.vue'),
            meta: {title: "幻想动物画廊 - 花园"},
        },
        {
            path: '/add',
            name: 'add',
            component: ()=>import('@/views/add.vue'),
            meta: {title: "幻想动物画廊 - 添加"},
        },
        {
            path: '/plantPot',
            name: 'plantPot',
            component: ()=>import('@/views/plantPot.vue'),
            meta: {title: "幻想动物画廊 - 盆栽"},
        },
    ]
})

export default router