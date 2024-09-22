<!-- 添加 -->

<script setup>
    import { addFileToForm, Messager, showNotice } from '@/api/ConnectCore';
    import router from '@/router';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <div class="container">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">上传画廊</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">种植盆栽</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">写下留言</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="container">
                            <div class="input-group">
                                <label class="input-group-text" for="theImageFile">画廊</label>
                                <input type="file" class="form-control" id="theImageFile" @change="addGalleryToForm($event)">
                            </div>
                            <label for="exampleFormControlInput1" class="form-label">标题</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="画廊标题" v-model="addGalleryForm.title">
                            <label for="exampleFormControlTextarea1" class="form-label">说明</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" placeholder="说明" v-model="addGalleryForm.info"></textarea>
                            <label for="exampleFormControlTextarea2" class="form-label">标签</label>
                            <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" placeholder="多个标签用空格隔开" v-model="addGalleryForm.tags"></textarea>
                            <div class="d-grid">
                                <button type="button" class="btn btn-outline-secondary" :class="{'disabled':sending || !GArea.furryUser.isLog}"
                                @click="sendTheGallery()">
                                    上传
                                </button>
                            </div>
                            <div class="border border-3 border-warning rounded">
                                <div style="font-weight: bold;">上传说明</div>
                                上传画廊至少包含图片文件和标题，填写说明更佳。
                                图片要求jpg/jpeg/png/gif格式，过大的图片（>5M）可能导致失败。
                                如果作者非上传兽最好在说明处补充来源。
                                <div style="font-weight: bold;">标签是什么？</div>
                                标签就是画廊的要素，一个幻想动物画廊通常有作者、系列等标签。
                                标签有助于搜索，下面给出标签格式。
                                <div style="color: orange;">
                                    标签(=1) 默认描述 =1可省略
                                    <br>
                                    标签=2 作者
                                    标签=3 系列
                                    标签=4 角色
                                    标签=5 兽种
                                    <br>
                                    例 蓝色 狗狗世界=3 犬=5
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="container border border-3 border-black rounded">
                            <img src="" id="showImage" width="100%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <label class="input-group-text" for="theImageFile">花盆贴图</label>
                            <input type="file" class="form-control" id="theImageFile" @change="addPostImageToForm($event)">
                        </div>
                        <label for="exampleFormControlInput1" class="form-label">盆栽名</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="盆栽名" v-model="addPostForm.title">
                        <label for="exampleFormControlTextarea1" class="form-label">正文</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" placeholder="正文" v-model="addPostForm.content"></textarea>
                        <label for="exampleFormControlTextarea2" class="form-label">标签</label>
                        <textarea class="form-control" id="exampleFormControlTextarea2" rows="3" placeholder="多个标签用空格隔开" v-model="addPostForm.tags"></textarea>
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-secondary" :class="{'disabled':sending || !GArea.furryUser.isLog}"
                            @click="sendThePost()">
                                种植
                            </button>
                        </div>
                        <div class="border border-3 border-warning rounded">
                            <p style="font-weight: bold;">盆栽是幻想动物画廊另一种媒体</p>
                            <p>
                                盆栽由盆栽名和内容构成，允许带一张贴图，将放到花园中展示。
                                盆栽可以生长叶子，叶子还能贴纸条。
                                画廊侧重图片，盆栽侧重图文聊天。
                            </p>
                            <p style="font-weight: bold;">盆栽标签</p>
                            <p>
                                盆栽和画廊共用一套标签，规则相同。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                <div class="row">
                    <div class="container">
                        <label for="exampleFormControlInput1" class="form-label">粉糖粒子留言板</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="留言......" v-model="content">
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-secondary" :class="{'disabled':sending || !GArea.furryUser.isLog}"
                            @click="sendTheMessage()">
                                发送
                            </button>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            addGalleryForm: {
                file: null,
                title: "",
                info: "",
                tags: "",
            },
            addPostForm: {
                file: null,
                title: "",
                content: "",
                tags: "",
            },
            content: "", // 留言板
            sending: false, // 传输时禁止点击按钮
        }},
        methods: {
            showImg(){
                // 显示要上传的图片
                let reads = new FileReader();
                let file = document.getElementById("theImageFile").files[0];
                reads.readAsDataURL(file);
                reads.onload=function(e){document.getElementById("showImage").src=this.result;}
            },
            addGalleryToForm(e){
                // 将画廊图片装入发送表单
                addFileToForm(this.addGalleryForm,e);
                this.showImg();
            },
            addPostImageToForm(e){
                // 将盆栽图片装入发送表单
                addFileToForm(this.addPostForm,e);
            },
            sendTheGallery(){
                // 上传画廊
                this.sending = true;
                Messager.sendNewGallery(this.addGalleryForm).then(res=>{
                    if(res==2){router.push('/');showNotice(8);}
                    else{this.sending=false;showNotice(7);}
                });
            },
            sendThePost(){
                // 种植盆栽
                this.sending = true;
                Messager.sendNewPost(this.addPostForm).then(res=>{
                    if(res==2){router.push('/');showNotice(10);}
                    else{this.sending=false;showNotice(9);}
                });
            },
            sendTheMessage(){
                // 发送留言
                this.sending = true;
                Messager.sendBoardMessage(this.content);
                router.push('/about');
            },
        },
        mounted(){},
    }
</script>

<style scoped>
</style>