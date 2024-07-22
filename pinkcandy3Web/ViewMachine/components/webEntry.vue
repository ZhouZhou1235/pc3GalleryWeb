<!-- 网站入口组件 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
    <!-- 登录入口 -->
    <div class="container">
        登录粉糖粒子才能使用功能
        <div class="btn-group">
            <RouterLink to="/begin"><button class="btn">登录</button></RouterLink>
            <RouterLink to="/begin"><button class="btn">注册</button></RouterLink>
        </div>
    </div>
</template>

<style scoped>
</style>
