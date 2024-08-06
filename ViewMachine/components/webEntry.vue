<!-- 网站入口组件 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHouseMedical, faRightToBracket } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <!-- 登录入口 -->
    <div class="container">
        登录粉糖粒子才能使用功能
        <div class="btn-group">
            <RouterLink to="/begin">
                <button class="btn">
                    <font-awesome-icon :icon="faRightToBracket" />
                    登录
                </button>
            </RouterLink>
            <RouterLink to="/begin">
                <button class="btn">
                    <font-awesome-icon :icon="faHouseMedical" />
                    注册
                </button>
            </RouterLink>
        </div>
    </div>
</template>

<style scoped>
</style>
