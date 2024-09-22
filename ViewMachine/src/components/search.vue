<!-- 子页面 搜索 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
import { GlobelArea } from '@/stores/PiniaBox';
import Card_gallery from './card_gallery.vue';
import Card_plantPot from './card_plantPot.vue';
    const GArea = GlobelArea();
</script>

<template>
    <div class="container-fluid" v-if="!closeSearch">
        <h2>来点粉糖 {{ tags }}</h2>
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">画廊</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">盆栽</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">小兽</button>
            </li>
        </ul>
        <div class="p-3">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="row">
                        <div v-for="item in showGallerysData" class="col-sm-6 col-md-3 col-xl-2 mt-2">
                            <Card_gallery :theData="item"></Card_gallery>
                        </div>
                    </div>
                    <div class="d-grid" v-if="!allDone1">
                        <button type="button" class="btn btn-outline-secondary"
                        @click="loadMoreGallery()">
                            加载更多
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="row">
                        <div v-for="item in showPostsData" class="col-sm-6 col-md-3 mt-2">
                            <Card_plantPot :theData="item"></Card_plantPot>
                        </div>
                    </div>
                    <div class="d-grid" v-if="!allDone2">
                        <button type="button" class="btn btn-outline-secondary"
                        @click="loadMorePost()">
                            加载更多
                        </button>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="item in showUsersData">
                                    <RouterLink :to="'/user?username='+item.username">
                                        <img :src="item.headImageUrl!=null?item.headImageUrl:GArea.staticFiles.defaultHead"
                                        alt="headImage" width="10%">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </RouterLink>
                                    {{ item.info }}
                                </li>
                            </ul>
                            <div class="d-grid" v-if="!allDone3">
                                <button class="btn btn-outline-secondary"
                                @click="loadMoreUser()">加载更多</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-grid">
                <button class="btn btn btn-outline-secondary" @click="closeSearch=true">关闭搜索</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["theTags"],
        data(){return{
            tags: "",
            gallerysData: {},
            postsData: {},
            usersData: {},
            showGallerysData: {},
            showPostsData: {},
            showUsersData: {},
            loadNum1: 0,
            loadNum2: 0,
            loadNum3: 0,
            allDone1: false,
            allDone2: false,
            allDone3: false,

            closeSearch: false,
        }},
        methods: {
            loadMoreGallery(){
                // 加载更多画廊
                if(this.gallerysData==undefined){this.allDone1=true;return;}
                let i = this.loadNum1;
                this.loadNum1 += 12;
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
                this.loadNum2 += 3;
                if(this.loadNum2>this.postsData.length){
                    this.loadNum2 = this.postsData.length;
                    this.allDone2 = true;
                }
                for(i;i<this.loadNum2;i++){
                    this.showPostsData[i] = this.postsData[i];
                }
            },
            loadMoreUser(){
                // 加载更多小兽
                if(this.usersData==undefined){this.allDone3=true;return;}
                let i = this.loadNum3;
                this.loadNum3 += 10;
                if(this.loadNum3>this.usersData.length){
                    this.loadNum3 = this.usersData.length;
                    this.allDone3 = true;
                }
                for(i;i<this.loadNum3;i++){
                    this.showUsersData[i] = this.usersData[i];
                }
            },
            getAndShowSearch(a){
                // 获取并显示搜索结果
                Messager.getSearchThings(a).then(res=>{
                    if(res!=undefined){
                        this.gallerysData = res.gallerys;
                        this.postsData = res.posts;
                        this.usersData = res.users;
                        this.loadMoreGallery();
                        this.loadMorePost();
                        this.loadMoreUser();
                    }
                });
            },
        },
        mounted(){
            this.tags = this.theTags;
            this.getAndShowSearch(this.tags);
        },
    }
</script>

<style scoped>
</style>