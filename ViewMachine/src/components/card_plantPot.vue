<!-- 一个盆栽预览卡片 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <div class="card">
        <div class="card-img-top" v-if="postData.fileUrl!=null">
            <RouterLink :to="'/plantPot?postID='+postData.postID">
                <img :src="postData.fileUrl" alt="postImage" width="100%">
            </RouterLink>
        </div>
        <div class="card-body text-center">
            <div style="font-size: 1.4em; font-weight: lighter;">
                <RouterLink :to="'/plantPot?postID='+postData.postID">
                    {{ postData.title }}
                </RouterLink>
            </div>
            <div>最新叶子{{ postData.updateTime }}</div>
            <div>种植时间{{ postData.createdTime }}</div>
            <div class="btn-group" v-if="GArea.furryUser.isLog">
                <button class="btn btn-sm" :class="{'btn-primary':postData.isPaw}"
                @click="changePostIsPaw()">
                    印爪<span class="badge text-bg-secondary">{{ postData.pawNum }}</span>
                </button>
                <button class="btn btn-sm" :class="{'btn-primary':postData.isStar}"
                @click="changePostIsStar()">
                    收藏<span class="badge text-bg-secondary">{{ postData.starNum }}</span>
                </button>
                <button class="btn btn-sm btn-success">
                    叶子<span class="badge text-bg-secondary">{{ postData.commentNum }}</span>
                </button>    
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["theData"],
        data(){return{
            postData: this.theData,
        }},
        methods: {
            changePostIsPaw(){
                // 盆栽印爪
                if(this.postData.isPaw){this.postData.pawNum--;this.postData.isPaw=false;}
                else{this.postData.pawNum++;this.postData.isPaw=true;}
                Messager.requestIsPaw(3,this.postData.postID);
            },
            changePostIsStar(){
                // 盆栽收藏
                if(this.postData.isStar){this.postData.starNum--;this.postData.isStar=false;}
                else{this.postData.starNum++;this.postData.isStar=true;}
                Messager.requestIsStar(2,this.postData.postID);
            },
        },
        mounted(){},
    }
</script>

<style scoped>
</style>