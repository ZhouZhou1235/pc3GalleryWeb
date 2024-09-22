<!-- 幻想动物画廊 首页 -->

<script setup>
    import card_gallery from '@/components/card_gallery.vue';
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 幻想动物画廊 -->
    <div class="container-fluid">
        <div class="row p-1">
            <div class="col-sm-3">
                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm"
                    @click="getAndShowGallery(1)">时间排序</button>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm"
                    @click="getAndShowGallery(2)">随机画廊</button>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm"
                    @click="getAndShowGallery(3)">印爪热门</button>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="d-grid">
                    <button class="btn btn-outline-secondary btn-sm" :class="{'disabled': !GArea.furryUser.isLog}"
                    @click="getAndShowGallery(4)">我的画廊</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div v-for="i in showGallerysData" class="col-sm-6 col-md-3 col-xl-2 mt-2">
                <card_gallery :theData="i"></card_gallery>
            </div>
        </div>
        <div class="d-grid" v-if="!allDone">
            <button type="button" class="btn btn-outline-secondary" @click="loadMore()">
                加载更多
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            gallerysData: {},
            showGallerysData: {},
            loadNum: 0,

            allDone: false,
        }},
        methods: {
            loadMore(){
                // 加载更多画廊
                if(this.gallerysData==undefined){this.allDone=true;return;}
                let i = this.loadNum;
                this.loadNum += 24;
                if(this.loadNum>this.gallerysData.length){
                    this.loadNum=this.gallerysData.length;
                    this.allDone = true;
                }
                for(i;i<this.loadNum;i++){
                    this.showGallerysData[i] = this.gallerysData[i];
                }
            },
            getAndShowGallery(myMode=1){
                // 获取并显示画廊
                // myMode 1时间 2随机 3印爪数 4仅自己上传
                let theMode = myMode;
                if(theMode==3){theMode=1;}
                this.gallerysData = {},
                this.showGallerysData = {},
                this.loadNum = 0,
                this.allDone = false;
                Messager.getGallerysData(theMode).then(res=>{
                    if(typeof res!=undefined){
                        this.gallerysData=res.mainData;
                        if(myMode==3){
                            this.gallerysData = this.gallerysData.sort((a,b)=>{
                                return b.pawNum - a.pawNum;
                            });
                        }
                        this.loadMore();
                    }
                });
            },
        },
        mounted(){
            this.getAndShowGallery();
        },
    }
</script>

<style scoped>
</style>