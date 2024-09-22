<!-- 幻想动物画廊 尾部 -->

<script setup>
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 尾部 -->
    <div class="container-fluid text-center">
        <div class="row justify-content-center">
            <div class="col-6">
                <img :src="GArea.staticFiles.webLogoBig" alt="webLogo" width="100%">
            </div>
        </div>
        <div class="row">
            <small>PINKCANDY 保留所有权利 2023-2024</small>
        </div>
        <div class="row">
            <ul class="breadcrumb justify-content-center">
                <li class="breadcrumb-item">站长周周</li>
                <li class="breadcrumb-item">
                    <a href="https://github.com/ZhouZhou1235">github</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="https://space.bilibili.com/63629388?spm_id_from=333.1007.0.0">哔哩哔哩</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="https://x.com/zhouzhou1235">推特</a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
</script>

<style scoped>
</style>