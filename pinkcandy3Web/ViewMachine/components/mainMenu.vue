<!-- 导航 首页 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
    <!-- 首页顶部导航 -->
    <div class="container">
        <div class="p-3 rounded">
            <!-- 印象 -->
            <div class="rounded p-3 text-center webImpression">
                <img src="/ViewMachine/assets/Images/pinkcandy.svg" alt="webLogo">
            </div>
            <!-- 导航 -->
            <ul class="nav nav-pills rounded webMenu">
                <li class="nav-item rounded">
                    <RouterLink to="/about" class="nav-link">粉糖粒子</RouterLink>
                </li>
                <li class="nav-item rounded">
                    <RouterLink to="/user" class="nav-link">我的空间</RouterLink>
                </li>
                <li class="nav-item rounded">
                    <RouterLink to="/galleryAdd" class="nav-link">上传画廊</RouterLink>
                </li>
                <li class="nav-item rounded">
                    <RouterLink to="/postAdd" class="nav-link">种植盆栽</RouterLink>
                </li>
                <li class="nav-item rounded">
                    <RouterLink to="/search" class="nav-link">搜索粉糖</RouterLink>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
</style>
