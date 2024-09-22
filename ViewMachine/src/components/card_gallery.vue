<!-- 一个画廊预览卡片 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <RouterLink :to="'/gallery?galleryID='+galleryData.galleryID">
        <img :src="galleryData.fileUrl" alt="galleryImage" width="100%">
    </RouterLink>
    <div class="container text-center">
        <div style="font-size: 1.2em; font-weight: bold;">{{ galleryData.title }}</div>
        <div class="btn-group" v-if="GArea.furryUser.isLog">
            <button class="btn btn-sm" :class="{'btn-primary':galleryData.isPaw}"
            @click="changeGalleryIsPaw()">
                印爪<span class="badge text-bg-secondary">{{ galleryData.pawNum }}</span>
            </button>
            <button class="btn btn-sm" :class="{'btn-primary':galleryData.isStar}"
            @click="changeGalleryIsStar()">
                收藏<span class="badge text-bg-secondary">{{ galleryData.starNum }}</span>
            </button>
            <button class="btn btn-sm btn-info">
                评论<span class="badge text-bg-secondary">{{ galleryData.commentNum }}</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["theData"],
        data(){return{
            galleryData: this.theData,
        }},
        methods: {
            changeGalleryIsPaw(){
                // 画廊印爪
                if(this.galleryData.isPaw){this.galleryData.pawNum--;this.galleryData.isPaw=false;}
                else{this.galleryData.pawNum++;this.galleryData.isPaw=true;}
                Messager.requestIsPaw(1,this.galleryData.galleryID);
            },
            changeGalleryIsStar(){
                // 画廊收藏
                if(this.galleryData.isStar){this.galleryData.starNum--;this.galleryData.isStar=false;}
                else{this.galleryData.starNum++;this.galleryData.isStar=true;}
                Messager.requestIsStar(1,this.galleryData.galleryID);
            },
        },
        mounted(){

        },
    }
</script>

<style scoped>
</style>