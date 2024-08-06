<!-- 数据组 盆栽标签 -->

<script setup>
import { Sender,Receiver } from '@/api/Messenger';
</script>

<template>
    <span v-for="item in myTags">
        <span class="badge tags">{{ item }}</span>
    </span>
</template>

<script>
    export default {
        props: ["postID"],
        data(){return{
            myPostID: this.postID,
            myTags: {},
        }},
        methods: {

        },
        mounted(){
            let sender = new Sender();
            // 获取盆栽标签数据包
            sender.postSender({action:3,todo:4,postID:this.myPostID,mode:2})
            .then((res)=>{if(res!=3){this.myTags = res["tags"];}});
        }
    }
</script>

<style scoped>
</style>