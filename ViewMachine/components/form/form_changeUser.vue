<!-- 带数据的表单 修改个兽信息 -->

<script setup>
import { g_vars } from '../../configure';
import { Receiver, Sender } from '../../api/Messenger';
import { FileMover } from '../../work/WebWorker';
import router from '@/router';
</script>

<template>
    <!-- 修改表单模态框 -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-xl">
            <form @submit.prevent="updateUser()">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">修改个兽信息</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="container-sm text-center">
                                    <div class="squareBox">
                                        <img :src="userData.headImageUrl!=null?userData.headImageUrl:g_vars['defaultHeadImage']"
                                        alt="headImg"
                                        style="width: 100%;"
                                        id="show"
                                        >
                                    </div>
                                    <h4>{{ userData.name }}</h4>
                                    <p>粉糖账号 {{ userData.username }}</p>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">邮箱</span>
                                    <input type="text" class="form-control" v-model="userData.email">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">密码</span>
                                    <input type="text" class="form-control" v-model="userData.pendPassword">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text">头像</span>
                                    <input type="file" class="form-control" id="theImageFile" :onchange="showImg" v-on:change="theFileReady1($event)">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">背景墙</span>
                                    <input type="file" class="form-control" v-on:change="theFileReady2($event)">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">名称</span>
                                    <input type="text" class="form-control" v-model="userData.name">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">介绍</span>
                                    <textarea name="" id="" class="form-control" rows="5" v-model="userData.info"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-select" aria-label="Default select example" v-model="userData.sex">
                                            <option selected>性别</option>
                                            <option value="1">雄</option>
                                            <option value="2">雌</option>
                                            <option value="3">无</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">兽种</span>
                                            <input type="text" class="form-control" v-model="userData.species">
                                        </div>
                                    </div>
                                </div>
                                <div class="container-sm border border-warning rounded border-3">
                                    <p>
                                        不要随意改变邮箱和密码，您需要确保：<br>
                                        1 邮箱可用，用于找回账号。<br>
                                        2 记住密码<br>
                                        粉糖粒子允许上传自由宽高比的背景墙图像，
                                        但建议上传形状扁平的背景墙。<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" @click="updateUser">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    function showImg(){
        // 显示要上传的图片
        var reads = new FileReader();
        var file = document.getElementById("theImageFile").files[0];
        reads.readAsDataURL(file);
        reads.onload=function(e){document.getElementById("show").src=this.result;}
    };

    export default {
        data(){return{
            userData: {},
        }},
        methods: {
            showImg(){
                // 显示要上传的图片
                var reads = new FileReader();
                var file = document.getElementById("theImageFile").files[0];
                reads.readAsDataURL(file);
                reads.onload=function(e){document.getElementById("show").src=this.result;}
            },
            theFileReady1(event){
                // 头像装入表单
                let fileMover = new FileMover();
                fileMover.fileReady(event,this.userData,"headImage");
            },
            theFileReady2(event){
                // 背景墙装入表单
                let fileMover = new FileMover();
                fileMover.fileReady(event,this.userData,"backImage");
            },
            updateUser(){
                // 修改小兽信息
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(this.userData,2)
                .then(res=>{
                    receiver.doNumberAct(res);
                    window.location.reload();
                });
            },
        },
        mounted(){
            var sender = new Sender();
            var receiver = new Receiver();
            // 获取小兽信息
            var outArr;
            // mode2用于调试
            // 上线设置
            var obj1 = {action:3,todo:3,mode:1,};
            // var obj1 = {action:3,todo:3,mode:2,username:10000,};
            sender.postSender(obj1)
            .then(res=>{
                outArr = receiver.postReceiver(res);
                this.userData = outArr;
                if(outArr!=undefined && outArr!=null){
                    // 填表准备提交
                    this.userData["action"] = 4;
                    this.userData["todo"] = 1;
                    this.userData["pendPassword"] = "";
                    this.userData["headImage"] = null;
                    this.userData["backImage"] = null;
                }
            });
        }
    }
</script>

<style scoped>
</style>