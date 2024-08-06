<!-- 导航 小兽用户 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
import form_changeUser from './form/form_changeUser.vue';
import { Sender } from '@/api/Messenger';
import router from '@/router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faMessage, faPencil, faPenFancy, faRightFromBracket, faShieldDog, faStar, } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <!-- 小兽操作 -->
    <div class="container">
        <div class="btn-group">
            <button class="btn btn-warning" @click="logout()">
                <font-awesome-icon :icon="faRightFromBracket" />
                退出登录
            </button>
            <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
                <font-awesome-icon :icon="faShieldDog" />
                修改个兽信息
            </button>
            <form_changeUser/>
            <RouterLink to="/galleryChange">
                <button class="btn">
                    <font-awesome-icon :icon="faPencil" />
                    管理画廊
                </button>
            </RouterLink>
            <RouterLink to="/postChange">
                <button class="btn">
                    <font-awesome-icon :icon="faPenFancy" />
                    管理盆栽
                </button>
            </RouterLink>
            <RouterLink to="/userMessage">
                <button class="btn">
                    <font-awesome-icon :icon="faMessage" />
                    消息
                </button>
            </RouterLink>
            <RouterLink to="/userStar">
                <button class="btn">
                    <font-awesome-icon :icon="faStar" />
                    收藏
                </button>
            </RouterLink>
        </div>
    </div>
</template>

<script>
    export default {
        date(){return{

        }},
        methods: {
            logout(){
                // 退出登录
                var obj = {action:1,todo:6,};
                var sender = new Sender();
                sender.postSender(obj);
                router.push("/");
            },
        },
    }
</script>

<style scoped>
</style>
