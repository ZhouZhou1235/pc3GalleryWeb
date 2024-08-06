<!-- 页面 搜索 -->

<script setup>
import router from '@/router';
import smallMenu from '../components/smallMenu.vue';
import { Sender } from '@/api/Messenger';
import g_vars from '@/configure';
import { Painter } from '@/work/WebWorker';
import { faClockRotateLeft, faComment, faPaintRoller, faPalette, faPaw, faSearch, faShieldDog, faStar, faTree } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <smallMenu/>
    <!-- 搜索 -->
    <div class="container">
        <!-- 搜索框 -->
        <div class="container rounded p-3 text-center">
            <form @submit.prevent="searchTags()">
                <div class="input-group">
                    <input type="text" class="form-control" v-model="tags">
                    <button class="btn btn-outline-secondary">
                        <font-awesome-icon :icon="faSearch" />
                        搜索粉糖
                    </button>
                </div>
            </form>
        </div>
        <div v-if="haveLoad">
            <!-- 搜索结果 -->
            <div class="container rounded p-3">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="pill" href="#home">
                            <font-awesome-icon :icon="faPalette" />
                            画廊
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu1">
                            <font-awesome-icon :icon="faTree" />
                            盆栽
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu2">
                            <font-awesome-icon :icon="faShieldDog" />
                            小兽
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <div class="row row-cols-1 row-cols-md-4 g-4">
                            <div v-for="item in myGalleryData">
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
                                            <button type="button" class="btn">
                                                <font-awesome-icon :icon="faPaw" />
                                                印爪<span class="badge">{{ item.pawNum }}</span>
                                            </button>
                                            <button type="button" class="btn">
                                                <font-awesome-icon :icon="faStar" />
                                                收藏<span class="badge">{{ item.starNum }}</span>
                                            </button>
                                            <button type="button" class="btn">
                                                <font-awesome-icon :icon="faComment" />
                                                评论<span class="badge">{{ item.commentNum }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-block"
                            :class="{'disabled':noMore1}"
                            @click="myLoadMore1(searchData,myGalleryData,loadNum1,viewNum1,10)">
                                <font-awesome-icon :icon="faPaintRoller" />
                                加载更多
                            </button>
                        </div>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                        <ul class="list-group">
                            <div v-for="item in myPostData">
                                <li class="list-group-item">
                                    <font-awesome-icon :icon="faPaw" />
                                    印爪<span class="badge">{{ item.pawNum }}</span>
                                    <a :href="'#/post?postID='+item.postID">
                                        {{ item.title }}
                                    </a>
                                    {{ item.content }}
                                    <br>
                                    <font-awesome-icon :icon="faClockRotateLeft" />
                                    {{ item.updateTime }}
                                </li>
                            </div>
                        </ul>
                        <div class="d-grid">
                            <button type="button" class="btn btn-block"
                            :class="{'disabled':noMore2}"
                            @click="myLoadMore2(searchData,myPostData,loadNum2,viewNum2,10)">
                                <font-awesome-icon :icon="faPaintRoller" />
                                加载更多
                            </button>
                        </div>
                    </div>
                    <div id="menu2" class="container tab-pane fade"><br>
                        <ul class="list-group">
                            <div v-for="item in myUserData">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="squareBox">
                                                        <a :href="'#/user?username='+item.username">
                                                            <img :src="item.headImageUrl?item.headImageUrl:g_vars['defaultHeadImage']" alt="headImage">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="col-9">
                                                    <span style="font-size: 1em; font-weight: bold;">
                                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                                        {{ item.species }}
                                                        <br>
                                                        {{ item.name }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <small>{{ item.info }}</small>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        </ul>
                        <div class="d-grid">
                            <button type="button" class="btn btn-block"
                            :class="{'disabled':noMore3}"
                            @click="myLoadMore3(searchData,myUserData,loadNum3,viewNum3,10)">
                                <font-awesome-icon :icon="faPaintRoller" />
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
            tags: "",
            searchData: {},
            myGalleryData: {},
            loadNum1: 10,
            viewNum1: 0,
            noMore1: false,
            myPostData: {},
            loadNum2: 10,
            viewNum2: 0,
            noMore2: false,
            myUserData: {},
            loadNum3: 10,
            viewNum3: 0,
            noMore3: false,
        }},
        methods: {
            searchTags(){
                // 搜索
                this.searchData = {};
                this.myGalleryData = {};
                this.myPostData = {};
                this.myUserData = {};
                let sender = new Sender();
                let painter = new Painter();
                sender.postSender({action:3,todo:8,tags:this.tags})
                .then(res=>{
                    if(res!=3 && res!=undefined){
                        this.searchData=res;
                        painter.paint_arr(res,this.myGalleryData,this.loadNum1,"gallerys");
                        painter.paint_arr(res,this.myPostData,this.loadNum2,"posts");
                        painter.paint_arr(res,this.myUserData,this.loadNum3,"users");
                        if(this.haveLoad==false){this.haveLoad=true;}
                        else{
                            this.haveLoad=false;
                            this.$nextTick(()=>{this.haveLoad=true;});
                        }
                    }
                });
            },
            myLoadMore1(theOutArr,showData,loadNum,viewNum,num){
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"gallerys");
                if(num2==true){this.noMore1=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
            myLoadMore2(theOutArr,showData,loadNum,viewNum,num){
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"posts");
                if(num2==true){this.noMore2=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
            myLoadMore3(theOutArr,showData,loadNum,viewNum,num){
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"users");
                if(num2==true){this.noMore3=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
        },
        mounted(){

        },
    }
</script>

<style scoped>
</style>