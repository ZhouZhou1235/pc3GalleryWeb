<!-- 页面 上传画廊 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import { Receiver,Sender } from '../api/messenger';
import webEntry from '../components/webEntry.vue';
import { ref } from 'vue';
import axios from 'axios';
</script>

<template>
    <smallMenu/>
    <div v-if="!haveLog">
        <webEntry/>
    </div>
    <!-- 上传画廊 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-6 p-3">
                <h1>上传新画廊</h1>
                <div v-if="!haveLog">
                    <div class="container text-center">
                        <h4>登录后才能上传画廊</h4>
                    </div>
                </div>
                <form @submit.prevent="addGallery()">
                    <div class="input-group">
                        <div class="input-group-text">画廊图片</div>
                        <input type="file" class="form-control" id="theImageFile" :onchange="showImg" v-on:change="fileReady($event)">
                    </div>
                    <div class="input-group">
                        <div class="input-group-text">画廊名</div>
                        <input type="text" class="form-control" placeholder="画廊名" v-model="formAddGallery.title">
                    </div>
                    <div class="p-3">
                        <textarea class="form-control" placeholder="说明" rows="5" v-model="formAddGallery.info"></textarea>
                        <textarea class="form-control" placeholder="标签" rows="3" v-model="formAddGallery.tags"></textarea>    
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-light" :class="{'disabled': !haveLog}">上传</button>
                    </div>
                    <div class="container-sm border border-warning rounded border-3 mt-3">
                        <p>
                            所有小兽都可以上传画廊<br>
                            至少包含：图片文件（支持jpg jpeg png gif，不能超过5MB）和画廊名<br>
                            若为转载，最好在说明处标注作者和来源。<br>
                            可以贴上标签，搜索标签能发现相关画廊。如有多个用空格隔开，不能有换行符。<br>
                            <span style="color: red;">
                                存在以下要素的画廊是直接禁止发布的，如有发现将立即删除。<br>
                                1 暴露生殖器（表达艺术形态美感的除外）<br>
                                2 详细刻画的肛门<br>
                                3 严重的暴力恐怖画面<br>
                                4 严重的抑郁，精神心理异常，猎奇怪异<br>
                                5 政治相关内容<br>
                                ......<br>
                            </span>   
                        </p>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 p-3">
                <img src="" id="show" width="100%">
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

    export default {
        data(){return{
            haveLog: false,
            formAddGallery: {
                action: 2,
                todo: 1,
                file: "",
                info: "",
                tags: "",
            },
        }},
        methods: {
            fileReady(event){
                // 文件装入表单
                // 获取文件信息
                let file = ref(null);
                let theFile = event.target.files[0];
                file.value = theFile;
                this.formAddGallery.file = theFile;
            },
            addGallery(){
                // 上传画廊
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(this.formAddGallery,2)
                .then(res=>{
                    receiver.postReceiver(res);
                });
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
