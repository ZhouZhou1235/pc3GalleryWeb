<!-- 页面 PINKCANDY主页 -->

<script setup>
import { Receiver, Sender } from '../api/messenger';
import mainMenu from '../components/mainMenu.vue'
import webEntry from '../components/webEntry.vue';
</script>

<template>
    <mainMenu/>
    <div v-if="!haveLog">
        <webEntry/>
    </div>
</template>

<script>
    export default {
        data(){return{
            haveLog: false,
        }},
        mounted(){
            { // 是否登录
                var obj = {action:1,todo:5};
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(obj)
                .then(res=>{
                    if(res==1){this.haveLog=true;}
                    receiver.doNumberAct(res);
                });
            }
        },
    }
</script>

<style scoped>
</style>
