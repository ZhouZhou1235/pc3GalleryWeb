<!-- 带数据的表单 修改盆栽 -->

<script setup>
import { Sender,Receiver } from '@/api/Messenger';
</script>

<template>
    <!-- 模态框修改表单 -->
    <div class="modal fade" :id="myPostID">
        <div class="modal-dialog modal-lg">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">修改主题帖</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <h4>正在修改 {{ myTitle }} postID {{ myPostID }}</h4>
                        <div class="input-group">
                            <div class="input-group-text">盆栽标题</div>
                            <input type="text" class="form-control" placeholder="盆栽标题" v-model="myTitle">
                        </div>
                        <div>
                            <textarea class="form-control" placeholder="盆栽内容" rows="5" v-model="myContent"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" @click="changePost()" data-bs-dismiss="modal">修改</button>
                        <button type="button" class="btn btn-danger" @click="delPost()" data-bs-dismiss="modal">删除</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["postID","title","content","username"],
        data(){return{
            myPostID: this.postID,
            myTitle: this.title,
            myContent: this.content,
            myUsername: this.username,
        }},
        methods: {
            changePost(){
                // 修改盆栽
                var sender = new Sender();
                sender.postSender({
                    action:4,todo:3,
                    postID:this.myPostID,
                    title:this.myTitle,
                    content:this.myContent,
                    mode:2})
            },
            delPost(){
                // 删除盆栽
                let x = confirm(`
                    PINKCANDY警告
                    删除操作不可逆！
                    真的要删除吗？TAT
                `);
                if(x==true){
                    let sender = new Sender();
                    sender.postSender({
                        action:4,todo:5,
                        postID:this.myPostID,
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