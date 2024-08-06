<!-- 数据组 画廊标签 -->

<script setup>
import { Receiver, Sender } from '../../api/Messenger';
</script>

<template>
    <span v-for="item in showTags">
        <span class="badge tags">{{ item }}</span>
    </span>
</template>

<script>
    export default {
        props: ["galleryID"],
        data(){return{
            myGalleryID: this.galleryID,
            showTags: null,
        }},
        mounted(){
            // 获取画廊标签
            var sender = new Sender();
            var receiver = new Receiver();
            let obj = {action:3,todo:4,mode:1,galleryID:this.myGalleryID};
            sender.postSender(obj)
            .then(res=>{
                let outArr = receiver.postReceiver(res);
                if(outArr!=undefined){this.showTags = outArr["tags"];}
            });
        },
    }
</script>

<style scoped>
</style>