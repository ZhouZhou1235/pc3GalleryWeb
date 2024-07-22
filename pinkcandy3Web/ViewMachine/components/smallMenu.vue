<!-- 导航 普通 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
    <!-- 顶部导航 -->
    <div class="container">
        <div class="row webMenu">
            <div class="col-sm p-3 rounded">
                <!-- 导航 -->
                <ul class="nav nav-pills rounded webMenu">
                <li class="nav-item rounded">
                    <RouterLink to="/" class="nav-link">粉糖粒子</RouterLink>
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
    </div>
</template>

<style scoped>
</style>