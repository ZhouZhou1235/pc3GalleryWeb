<!-- vue基组件 -->

<script setup>
    import TheMenu from './components/theMenu.vue';
    import websiteFooter from './components/websiteFooter.vue';
</script>

<template>
    <TheMenu></TheMenu>
    <router-view></router-view>
    <websiteFooter></websiteFooter>
</template>

<script>
</script>

<style scoped>
</style>