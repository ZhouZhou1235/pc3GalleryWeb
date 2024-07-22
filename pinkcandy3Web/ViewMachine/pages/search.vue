<!-- 页面 搜索 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
</script>

<template>
    <smallMenu/>
    <!-- 搜索 -->
    <div class="container">
        <!-- 搜索框 -->
        <div class="container rounded p-3 text-center">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control">
                    <button class="btn btn-outline-secondary">搜索</button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
</style>