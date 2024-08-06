<!-- 导航 普通 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
import g_vars from '@/configure';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faHome, faPalette, faSearch, faTree, faTreeCity } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <!-- 顶部导航 -->
    <div class="container">
        <div class="row webMenu">
            <div class="col-sm p-3 rounded">
                <div class="row">
                    <div class="col-sm-2">
                        <img :src="g_vars['webLogo']" alt="webLogo" width="100%">
                    </div>
                    <div class="col-sm-10">
                        <!-- 导航 -->
                        <ul class="nav nav-pills rounded webMenu">
                            <li class="nav-item rounded">
                                <RouterLink to="/" class="nav-link">
                                    <font-awesome-icon :icon="faTreeCity" />
                                    粉糖粒子
                                </RouterLink>
                            </li>
                            <li class="nav-item rounded">
                                <RouterLink to="/user" class="nav-link">
                                    <font-awesome-icon :icon="faHome" />
                                    小兽空间
                                </RouterLink>
                            </li>
                            <li class="nav-item rounded">
                                <RouterLink to="/galleryAdd" class="nav-link">
                                    <font-awesome-icon :icon="faPalette" />
                                    上传画廊
                                </RouterLink>
                            </li>
                            <li class="nav-item rounded">
                                <RouterLink to="/postAdd" class="nav-link">
                                    <font-awesome-icon :icon="faTree" />
                                    种植盆栽
                                </RouterLink>
                            </li>
                            <li class="nav-item rounded">
                                <RouterLink to="/search" class="nav-link">
                                    <font-awesome-icon :icon="faSearch" />
                                    搜索粉糖
                                </RouterLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>