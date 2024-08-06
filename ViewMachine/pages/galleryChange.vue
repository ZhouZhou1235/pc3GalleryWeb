<!-- 页面 管理画廊 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import { Sender,Receiver } from '@/api/Messenger';
import arr_galleryList from '@/components/arr/arr_galleryList.vue';
</script>

<template>
    <smallMenu/>
    <div v-if="haveLoad">
        <div v-if="haveLog">
            <div class="container">
                <span style="font-size: 2em; font-weight: bold;">
                    {{ userData.sex==1?"雄":userData.sex==2?"雌":"" }}
                    {{ userData.species }}
                    {{ userData.name }}
                    的画廊
                </span>
                <arr_galleryList :mode="3" :username="userData.username"></arr_galleryList>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            haveLoad: false,
            haveLog: false,
            userData: null,
        }},
        methods: {

        },
        mounted(){
            let sender = new Sender();
            let receiver = new Receiver();
            // 是否登录
            sender.postSender({action:1,todo:5,})
            .then((res)=>{if(res==1){
                this.haveLog=true;
                // 此处用于调试 上线时注释
                // let obj2 = {action:3,todo:3,mode:2,username:10000};
                // 获取小兽信息
                sender.postSender({action:3,todo:3,mode:1,})
                .then((res)=>{this.userData=res;this.haveLoad=true});
            };});
        },
    }
</script>

<style scoped>
</style>