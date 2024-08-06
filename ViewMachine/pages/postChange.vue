<!-- 页面 管理盆栽 -->

<script setup>
import { Sender } from '@/api/Messenger';
import smallMenu from '../components/smallMenu.vue';
import arr_postList from '@/components/arr/arr_postList.vue';
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
                    的盆栽
                </span>
                <arr_postList :mode="3" :username="userData.username"></arr_postList>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            haveLoad: false,
            haveLog: false,
            userData: {},
        }},
        methods: {

        },
        mounted(){
            // 是否登录
            let sender = new Sender();
            sender.postSender({action:1,todo:5,})
            .then(res=>{
                if(res==1){this.haveLog=true;}
                // 获取小兽信息
                sender.postSender({action:3,todo:3,mode:1,})
                .then((res)=>{
                    this.userData=res;
                    this.haveLoad=true;
                });
            })
        },

    }
</script>

<style scoped>
</style>