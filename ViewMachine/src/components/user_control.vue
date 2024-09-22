<!-- 子页面 内容管理 -->

<script setup>
    import { Messager, showNotice } from '@/api/ConnectCore';
import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <div class="container">
        <h1>小兽空间 - {{ GArea.furryUser.name }}的内容管理</h1>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">画廊</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">盆栽</button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                <div class="row">
                    <div class="col-sm-3" v-for="item in showGallerysData">
                        <div class="container">
                            <RouterLink :to="'/gallery?galleryID='+item.galleryID">
                                <img :src="item.fileUrl" alt="galleryImage" width="100%">
                            </RouterLink>
                            <div class="container">
                                <div style="font-size: 1.2em;">{{ item.title }}</div>
                                <p>印爪{{ item.pawNum }} 收藏{{ item.starNum }} 评论{{ item.commentNum }}</p>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" :data-bs-target="'#'+item.galleryID">
                                        修改
                                    </button>
                                </div>
                            </div>
                            <div class="modal fade" :id="item.galleryID" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2>修改画廊 {{ item.title }}</h2>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <p>画廊标题</p>
                                                <input type="email" class="form-control" placeholder="画廊标题......" v-model="item.title">
                                            </div>
                                            <div class="mb-3">
                                                <p>说明</p>
                                                <textarea class="form-control" rows="4" placeholder="说明......" v-model="item.info"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                                            @click="updateGallery(item.title,item.info,item.galleryID)">修改</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                            @click="deleteGallery(item.galleryID)">删除</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid" v-if="!allDone1">
                        <button class="btn btn-outline-secondary"
                        @click="loadMoreGallery()">
                            加载更多
                        </button>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="item in showPostsData">
                        <div class="container">
                            <div style="font-size: 1.5em; font-weight: bold;">
                                <RouterLink :to="'/plantPot?postID='+item.postID">
                                    {{ item.title }}
                                </RouterLink>
                                <p>印爪{{ item.pawNum }} 收藏{{ item.starNum }} 叶子{{ item.commentNum }}</p>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" :data-bs-target="'#'+item.postID">
                                修改
                            </button>
                        </div>
                        <div class="modal fade" :id="item.postID" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2>修改盆栽 {{ item.title }}</h2>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <p>盆栽名</p>
                                            <input type="email" class="form-control" placeholder="盆栽名......" v-model="item.title">
                                        </div>
                                        <div class="mb-3">
                                            <p>正文内容</p>
                                            <textarea class="form-control" rows="8" placeholder="内容......" v-model="item.content"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-warning" data-bs-dismiss="modal"
                                        @click="updatePost(item.title,item.content,item.postID)">修改</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                        @click="deletePost(item.postID)">删除</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="d-grid" v-if="!allDone2">
                    <button class="btn btn-outline-secondary"
                    @click="loadMorePost()">
                        加载更多
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            gallerysData: {},
            postsData: {},
            showGallerysData: {},
            showPostsData: {},
            loadNum1: 0,
            loadNum2: 0,
            allDone1: false,
            allDone2: false,
        }},
        methods: {
            loadMoreGallery(){
                // 加载更多画廊
                if(this.gallerysData==undefined){this.allDone1=true;return;}
                let i = this.loadNum1;
                this.loadNum1 += 16;
                if(this.loadNum1>this.gallerysData.length){
                    this.loadNum1 = this.gallerysData.length;
                    this.allDone1 = true;
                }
                for(i;i<this.loadNum1;i++){
                    this.showGallerysData[i] = this.gallerysData[i];
                }
            },
            loadMorePost(){
                // 加载更多盆栽
                if(this.postsData==undefined){this.allDone2=true;return;}
                let i = this.loadNum2;
                this.loadNum2 += 10;
                if(this.loadNum2>this.postsData.length){
                    this.loadNum2 = this.postsData.length;
                    this.allDone2 = true;
                }
                for(i;i<this.loadNum2;i++){
                    this.showPostsData[i] = this.postsData[i];
                }
            },
            updateGallery(title,info,galleryID){
                // 更新画廊内容
                Messager.requestChangeMedia(1,title,info,galleryID);
            },
            deleteGallery(id){
                // 删除画廊
                const GArea = GlobelArea();
                let x = confirm("画廊删除是不可逆的！确认删除？");
                if(x){
                    Messager.requestDelGallery(id,GArea.furryUser.username).then(res=>{
                        if(res==1){showNotice(13);this.getAndShowControl();}
                    });
                }
            },
            updatePost(title,content,postID){
                // 更新盆栽内容
                Messager.requestChangeMedia(2,title,content,postID);
            },
            deletePost(id){
                // 删除盆栽
                const GArea = GlobelArea();
                let x = confirm("即将要摧毁一个盆栽！包括叶子、纸条全部都会消失！！确认删除？");
                if(x){
                    Messager.requestDelPost(id,GArea.furryUser.username).then(res=>{
                        if(res==1){showNotice(14);this.getAndShowControl();}
                    });
                }
            },
            getAndShowControl(){
                // 获取并显示管理区域
                this.showGallerysData = {},
                this.showPostsData = {},
                this.loadNum1 = 0,
                this.loadNum2 = 0,
                this.allDone1 = false,
                this.allDone2 = false;
                Messager.getGallerysData(4).then(res=>{
                    if(res!=undefined){
                        this.gallerysData = res.mainData;
                        this.loadMoreGallery();
                    }
                });
                Messager.getPostsData(2).then(res=>{
                    if(res!=undefined){
                        this.postsData = res.mainData;
                        this.loadMorePost();
                    }
                });
            },
        },
        mounted(){
            this.getAndShowControl();
        },
    }
</script>

<style scoped>
</style>