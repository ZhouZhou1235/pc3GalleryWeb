<!-- 页面 小兽空间 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import userMenu from '../components/userMenu.vue';
</script>

<template>
    <smallMenu/>
    <div v-if="login">
        <userMenu/>
    </div>
</template>

<script>
    var login = false;
    export default {
        data(){return{}},
        mounted(){
            // 写判断是否登录
            console.log("ok");
        },
    }
</script>

<style scoped>
</style>