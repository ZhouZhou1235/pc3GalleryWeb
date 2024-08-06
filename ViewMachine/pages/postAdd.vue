<!-- 页面 种植盆栽 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import webEntry from '../components/webEntry.vue';
import { Receiver,Sender } from '../api/Messenger';
import { FileMover } from '../work/WebWorker';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faImage, faSeedling } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <smallMenu/>
    <div v-if="!haveLog">
        <webEntry/>
        <div class="container-sm p-3 text-center">
            <h4>登录后才能种植盆栽</h4>
        </div>
    </div>
    <!-- 种植盆栽 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-6 p-3">
                <h1>种植新盆栽</h1>
                <form @submit.prevent="addPost()">
                    <div class="input-group">
                        <div class="input-group-text">
                            <font-awesome-icon :icon="faSeedling" />
                            盆栽名
                        </div>
                        <input type="text" class="form-control" placeholder="盆栽名" id="title" :onchange="showText" v-model="formAddPost.title">
                    </div>
                    <div class="input-group">
                        <div class="input-group-text">
                            <font-awesome-icon :icon="faImage" />
                            花盆贴图
                        </div>
                        <input type="file" class="form-control" :onchange="showImg" id="theImageFile" v-on:change="theFileReady($event)">
                    </div>
                    <div class="p-3">
                        <textarea class="form-control" placeholder="内容" rows="5" id="content" :onchange="showText" v-model="formAddPost.content"></textarea>
                        <textarea class="form-control" placeholder="标签" rows="3" v-model="formAddPost.tags"></textarea>    
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-light" :class="{'disabled': !haveLog}">发布</button>
                    </div>
                    <div class="container-sm border border-warning rounded border-3 mt-3">
                        <p>
                            所有小兽都可以发布帖子<br>
                            至少包含：标题和内容<br>
                            可以贴上标签，搜索标签能发现相关帖子。如有多个用空格隔开<br>
                        </p>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 p-3">
                <div class="card">
                    <div class="card-img-top">
                        <img src="" id="show" width="100%">
                    </div>
                    <div class="card-header"><h4><span id="showTitle"></span></h4></div>
                    <div class="card-body">
                        <p>
                            <span id="showContent"></span>
                        </p>
                    </div>
                </div>
            </div>
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
    function showText(){
        // 显示要发布的帖子文本
        var title = document.getElementById("title").value;
        var content = document.getElementById("content").value;
        document.getElementById("showTitle").innerHTML=title;
        document.getElementById("showContent").innerHTML=content;
    };

    export default {
        data(){return{
            haveLog: false,
            formAddPost: {
                action: 2,
                todo: 2,
                file: "",
                content: "",
                tags: "",
            },
        }},
        methods: {
            theFileReady(event){
                // 文件装入表单
                let fileMover = new FileMover();
                fileMover.fileReady(event,this.formAddPost);
            },
            addPost(){
                // 种植盆栽
                let fileMover = new FileMover();
                fileMover.fileUpload(this.formAddPost);
            }
        },
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
