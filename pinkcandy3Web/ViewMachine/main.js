/* 
 * PINKCANDY 屏幕显示机
 * 工作：显示网站页面 与后端联系
 * 所有动作发给后端 取到结果渲染页面
 * 自行显示网站页面
 */

// PINKCANDY vue 入口JS

// vue
import { createApp } from 'vue'
import main from './main.vue'
import router from './router'

// 全局CSS
import 'bootstrap/dist/css/bootstrap.css' // bootstrap样式表
import './assets/css/pinkcandyDefault.css' // 粉糖粒子样式表

// 全局JS
import 'bootstrap/dist/js/bootstrap' // bootstrap样式脚本

// vue 创建app
const PINKCANDY = createApp(main)
// 指定要使用的模块
PINKCANDY.use(router) // vue路由
// 挂载
PINKCANDY.mount('#main')