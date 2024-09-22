<!-- 子页面 收藏 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import card_gallery from './card_gallery.vue';
    import card_plantPot from './card_plantPot.vue';
import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <div class="container">
        <h2>小兽空间 - {{ GArea.furryUser.name }}的收藏</h2>
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
                    <div class="col-sm-6 col-md-4 col-xl-3 mt-2"
                    v-for="i in showGallerysData">
                        <card_gallery :theData="i"></card_gallery>
                    </div>
                </div>
                <div class="d-grid" v-if="!allDone1">
                    <button class="btn btn-outline-secondary"
                    @click="loadMoreGallery()">加载更多</button>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-xl-3 mt-2"
                    v-for="i in showPostsData">
                        <card_plantPot :theData="i"></card_plantPot>
                    </div>
                </div>
                <div class="d-grid" v-if="!allDone2">
                    <button class="btn btn-outline-secondary"
                    @click="loadMorePost()">加载更多</button>
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
                this.loadNum1 += 8;
                if(this.loadNum1>this.gallerysData.length){
                    this.loadNum1=this.gallerysData.length;
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
                this.loadNum2 += 4;
                if(this.loadNum2>this.postsData.length){
                    this.loadNum2=this.postsData.length;
                    this.allDone2 = true;
                }
                for(i;i<this.loadNum2;i++){
                    this.showPostsData[i] = this.postsData[i];
                }
            },
        },
        mounted(){
            Messager.getStarData(1).then(res=>{
                if(res!=undefined){
                    this.gallerysData = res.gallerys;
                    this.postsData = res.posts;
                    this.loadMoreGallery();
                    this.loadMorePost();
                }
            });
        },
    }
</script>

<style scoped>
</style>