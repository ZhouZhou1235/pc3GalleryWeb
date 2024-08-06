<!-- 页面 PINKCANDY主页 -->

<script setup>
import { Sender } from '@/api/Messenger';
import mainMenu from '@/components/mainMenu.vue'
import webEntry from '@/components/webEntry.vue';
import arr_gallery from '@/components/arr/arr_gallery.vue';
import arr_post from '@/components/arr/arr_post.vue';
</script>

<template>
    <mainMenu/>
    <div v-if="!haveLog">
        <webEntry/>
    </div>
    <!-- 展示内容 -->
    <div v-if="haveLoad">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 p-3 rounded postBox">
                    <arr_post :mode="1" :username="null"></arr_post>
                </div>
                <div class="col-sm-8 galleryBox">
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        <arr_gallery :mode="1" :username="null"></arr_gallery>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            haveLog: false,
            haveLoad: true,
        }},
        mounted(){
            var sender = new Sender();
            // 是否登录
            sender.postSender({action:1,todo:5})
            .then(res=>{if(res==1){this.haveLog=true;}});
        },
    }
</script>

<style scoped>
</style>
