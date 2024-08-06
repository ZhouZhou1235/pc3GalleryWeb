<!-- 带数据的表单 修改画廊 -->

<script setup>
import { Sender,Receiver } from '@/api/Messenger';
</script>

<template>
    <!-- 模态框修改表单 -->
    <div class="modal fade" :id="'form'+myGalleryID">
        <div class="modal-dialog modal-lg">
            <form action="">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">修改画廊</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>正在修改 {{ myTitle }} galleryID {{ myGalleryID }}</h4>
                        <div class="input-group">
                            <div class="input-group-text">画廊名</div>
                            <input type="text" class="form-control" placeholder="画廊名" v-model="myTitle">
                        </div>
                        <div class="p-3">
                            <textarea class="form-control" placeholder="说明" rows="5" v-model="myInfo"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" @click="changeGallery()" data-bs-dismiss="modal">修改</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click="delGallery()">删除</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["galleryID","title","info","username"],
        data(){return{
            myGalleryID: this.galleryID,
            myTitle: this.title,
            myInfo: this.info,
            myUsername: this.username,
        }},
        methods: {
            changeGallery(){
                // 修改画廊
                var sender = new Sender();
                sender.postSender({
                    action:4,todo:3,
                    galleryID:this.myGalleryID,
                    title:this.myTitle,info:this.myInfo,
                    mode:1})
            },
            delGallery(){
                // 删除画廊
                let x = confirm(`
                    PINKCANDY警告
                    删除操作不可逆！
                    真的要删除吗？TAT
                `);
                if(x==true){
                    let sender = new Sender();
                    sender.postSender({
                        action:4,todo:4,
                        galleryID:this.myGalleryID,
                        username:this.myUsername,})
                    .then(()=>{window.location.reload();})
                }
            },
        },
        mounted(){

        },
    }
</script>

<style scoped>
</style>