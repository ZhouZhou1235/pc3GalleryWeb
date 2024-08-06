<!-- 页面 收藏 -->

<script setup>
import { Painter } from '@/work/WebWorker';
import smallMenu from '../components/smallMenu.vue';
import { Sender } from '@/api/Messenger';
import router from '@/router';
import g_vars from '@/configure';
</script>

<template>
    <smallMenu/>
    <div v-if="haveLoad && haveLog">
        <!-- 收藏 -->
        <div class="container">
            <div class="container rounded p-3">
                <span style="font-size: 2em; font-weight: bold;">
                    {{ starContent.theUser.sex==1?"雄":starContent.theUser.sex==2?"雌":"" }}
                    {{ starContent.theUser.species }}
                    {{ starContent.theUser.name }}
                    的收藏
                </span>
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="pill" href="#home">画廊</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu1">盆栽</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <div v-for="item in galleryData">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-img-top">
                                            <a :href="'#/gallery?galleryID='+item.galleryID">
                                                <img :src="item.fileUrl?item.fileUrl:g_vars['image404']" alt="galleryImage" class="img-thumbnail" width="100%">
                                            </a>
                                        </div>
                                        <div class="card-header">
                                            <h3>{{ item.title }}</h3>
                                        </div>
                                        <div class="card-text">
                                            <button type="button" class="btn">印爪<span class="badge">{{ item.pawNum }}</span></button>
                                            <button type="button" class="btn">收藏<span class="badge">{{ item.starNum }}</span></button>
                                            <button type="button" class="btn">评论<span class="badge">{{ item.commentNum }}</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-block"
                            @click="myLoadMore1(starContent,galleryData,loadNum1,viewNum1,10)"
                            :class="{'disabled':noMore1}">
                                加载更多
                            </button>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                        <ul class="list-group">
                            <div v-for="item in gardenData">
                                <li class="list-group-item">
                                    印爪<span class="badge">{{ item.pawNum }}</span>
                                    <a :href="'#/post?postID='+item.postID">
                                        {{ item.title }}
                                    </a>
                                    种植时间
                                    {{ item.createdTime }}
                                </li>
                            </div>
                        </ul>
                        <div class="d-grid">
                            <button type="button" class="btn btn-block"
                            @click="myLoadMore2(starContent,gardenData,loadNum2,viewNum2,10)"
                            :class="{'disabled':noMore2}">
                                加载更多
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
            haveLoad: false,
            haveLog: false,
            starContent: {},

            galleryData: {},
            loadNum1: 10,
            viewNum1: 0,
            noMore1: false,
            gardenData: {},
            loadNum2: 10,
            viewNum2: 0,
            noMore2: false,
        }},
        methods: {
            myLoadMore1(theOutArr,showData,loadNum,viewNum,num){
                // 加载更多画廊
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"gallerys");
                if(num2==true){this.noMore1=true;}
                else{this.viewNum1=num2;this.loadNum1=num2;}
            },
            myLoadMore2(theOutArr,showData,loadNum,viewNum,num){
                // 加载更多盆栽
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"posts");
                if(num2==true){this.noMore2=true;}
                else{this.viewNum2=num2;this.loadNum2=num2;}
            },
        },
        mounted(){
            let sender = new Sender();
            let painter = new Painter();
            // 是否登录
            sender.postSender({action:1,todo:5})
            .then(res=>{
                if(res==1){
                    this.haveLog=true;
                    // 登录后载入小兽信息
                    sender.postSender({action:3,todo:6,mode:1})
                    .then(res=>{
                        if(res!=undefined && res!=null){
                            this.starContent=res;
                            if(res!=0 && res!=undefined){
                                // 载入画廊 盆栽
                                painter.paint_arr(res,this.galleryData,this.loadNum1,"gallerys");
                                painter.paint_arr(res,this.gardenData,this.loadNum2,"posts");
                                this.haveLoad = true;
                            }
                        }
                    })
                }
            })
        },
    }
</script>

<style scoped>
</style>