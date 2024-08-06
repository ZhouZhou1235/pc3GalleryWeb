<!-- 基组件 -->
 
<script setup>
import { RouterLink, RouterView } from 'vue-router';
import { Notifications } from '@kyvg/vue3-notification';
</script>

<template>
    <notifications width="25%" position="bottom right"/>
    <RouterView/>
    <div class="container text-center">
        <small>
            🐾🐾🐾
            PINKCANDY
            让世界变成毛绒绒的形状
            🐾🐾🐾
        </small>
    </div>
</template>

<style scoped>
</style>