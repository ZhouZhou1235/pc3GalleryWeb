// vue项目入口JS脚本

// 全局导入项

// vue基本
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';

// 用户界面库 bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min.js';
// Vue用户界面库 element-ui 样式表
import 'element-plus/dist/index.css';
// 幻想动物画廊样式表
import '@/assets/css/pc3Gallery.css';
// 异步通信 axios
import axios from 'axios';

// 开始程序
const app = createApp(App); // 创建vue程序
axios.defaults.withCredentials = true; // 请求允许携带cookie
app.use(createPinia()); // pinia状态管理
app.use(router); // vue路由

// 路由meta遍历 更新标题
router.beforeEach((to,from,next)=>{
    if(to.meta.title){document.title=to.meta.title}
    next();
});

// 挂载
app.mount('#app')