// vue路由

import { createRouter, createWebHashHistory, createWebHistory } from 'vue-router'
import homePage from '../pages/homePage.vue'

const router = createRouter({
    // 路由模式
    // web html5history 地址优雅 但需要配置服务器请求返回主页，兼容差。
    // hash 哈希路由 兼容良好无需配置 但地址携带/#/不利于搜索引擎收录
    // history: createWebHistory(import.meta.env.BASE_URL),
    history: createWebHashHistory(import.meta.env.BASE_URL),
    routes: [
        {
            // 首页
            path: '/',
            name: 'homePage',
            component: homePage,
        },
        {
            // 关于
            path: '/about',
            name: 'about',
            component: ()=>import('../pages/about.vue')
        },
        {
            // 搜索
            path: '/search',
            name: 'search',
            component: ()=>import('../pages/search.vue')
        },
        {
            // 开始
            path: '/begin',
            name: 'begin',
            component: ()=>import('../pages/begin.vue')
        },
        {
            // 毛绒画廊
            path: '/gallery',
            name: 'gallery',
            component: ()=>import('../pages/gallery.vue')
        },
        {
            // 上传画廊
            path: '/galleryAdd',
            name: 'galleryAdd',
            component: ()=>import('../pages/galleryAdd.vue')
        },
        {
            // 管理画廊
            path: '/galleryChange',
            name: 'galleryChange',
            component: ()=>import('../pages/galleryChange.vue')
        },
        {
            // 小兽花园
            path: '/post',
            name: 'post',
            component: ()=>import('../pages/post.vue')
        },
        {
            // 种植盆栽
            path: '/postAdd',
            name: 'postAdd',
            component: ()=>import('../pages/postAdd.vue')
        },
        {
            // 管理盆栽
            path: '/postChange',
            name: 'postChange',
            component: ()=>import('../pages/postChange.vue')
        },
        {
            // 小兽空间
            path: '/user',
            name: 'user',
            component: ()=>import('../pages/user.vue')
        },
        {
            // 消息
            path: '/userMessage',
            name: 'userMessage',
            component: ()=>import('../pages/userMessage.vue')
        },
        {
            // 收藏
            path: '/userStar',
            name: 'userStar',
            component: ()=>import('../pages/userStar.vue')
        },
    ]
})

export default router