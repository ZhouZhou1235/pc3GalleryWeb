<!-- 页面 小兽空间 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import userMenu from '../components/userMenu.vue';
import { Receiver, Sender } from '../api/Messenger';
import webEntry from '../components/webEntry.vue';
import arr_gallery from '../components/arr/arr_gallery.vue';
import arr_post from '../components/arr/arr_post.vue';
import g_vars from '@/configure';
import { Painter } from '@/work/WebWorker';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faClover, faEye, faFeather, faPaintRoller, faSquarePlus } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <smallMenu/>
    <div v-if="!haveLog">
        <webEntry/>
        <div class="container-sm p-3 text-center">
            <h4>登录后才能使用小兽空间</h4>
        </div>
    </div>
    <div v-if="haveLoad">
        <div v-if="haveLog && myMode==1">
            <userMenu/>
        </div>
        <div v-if="userData!=undefined && userData!=null">
            <!-- 基本信息 -->
            <div class="container p-1">
                <div class="backImageBox">
                    <img :src="userData.backImageUrl?userData.backImageUrl:g_vars['defaultBackImage']" alt="backImage">
                </div>
                <div class="container">
                    <div style="display: flex;">
                        <div style="width: 10%; transform: translate(50%, -50%);">
                            <div class="squareBox">
                                <img :src="userData.headImageUrl?userData.headImageUrl:g_vars['defaultHeadImage']" alt="headImage">
                            </div>
                        </div>
                        <div style="width: 90%; margin-left: 5%;">
                            <span style="font-size: 2em; font-weight: bold;">
                                {{ userData.sex==1?"雄":userData.sex==2?"雌":"" }}
                                {{ userData.species }}
                                {{ userData.name }}
                                <span v-if="myMode!=1">
                                    <button class="btn" @click="addWatch()" :class="{'btn-primary':haveWatch}">
                                        <font-awesome-icon :icon="faSquarePlus" />
                                        关注
                                    </button>
                                </span>
                            </span>
                        </div>
                    </div>
                    <button class="btn">
                        <font-awesome-icon :icon="faEye" />
                        关注<div class="badge">{{ userData.myWatchNum }}</div>
                    </button>
                    <button class="btn">
                        <font-awesome-icon :icon="faClover" />
                        粉丝<div class="badge">{{ userData.watcherNum }}</div>
                    </button>
                    <!-- <span class="badge">xxx</span>
                    <span class="badge">xxx</span> -->
                    <p>
                        {{ userData.joinTime }} 加入粉糖<br>
                        <font-awesome-icon :icon="faFeather" />
                        {{ userData.info}}
                    </p>
                </div>
            </div>
            <!-- 发布内容 -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4 p-3 rounded postBox">
                        <arr_post :mode="gardenShowMode" :username="myUsername"></arr_post>
                    </div>
                    <div class="col-sm-8 galleryBox">
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <arr_gallery :mode="galleryShowMode" :username="myUsername"></arr_gallery>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 粉丝与关注 -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <!-- 关注 -->
                        <div class="container" id="myWatch">
                            <div class="container p-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h4>{{ userData.name }} 的关注</h4>
                                    </li>
                                    <div v-if="haveLoad2">
                                        <div v-for="item in myWatchData">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="squareBox">
                                                            <a :href="'#/user?username='+item.myWatchUsername">
                                                                <img :src="item.myWatchHeadImageUrl?item.myWatchHeadImageUrl:g_vars['defaultHeadImage']" alt="headImage">
                                                            </a>
                                                        </div>
                                                        {{ item.myWatchSex==1?"雄":item.myWatchSex==2?"雌":"" }}
                                                        {{ item.myWatchSpecies }}
                                                        <br>
                                                        {{ item.myWatchName }}
                                                        <!-- <span class="badge">总管理兽</span>
                                                        <span class="badge">爱印爪</span>         -->
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <small>{{ item.myWatchInfo }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                    </div>
                                </ul>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-block"
                                    @click="myLoadMore2(userData,myWatchData,loadNum2,viewNum1,10)"
                                    :class="{'disabled':noMore2}">
                                    <font-awesome-icon :icon="faPaintRoller" />
                                        加载更多
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- 粉丝 -->
                        <div class="container" id="watcher">
                            <div class="container p-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h4>{{ userData.name }} 的粉丝</h4>
                                    </li>
                                    <div v-if="haveLoad1">
                                        <div v-for="item in watcherData">
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="squareBox">
                                                            <a :href="'#/user?username='+item.watcherUsername">
                                                                <img :src="item.watcherHeadImageUrl?item.watcherHeadImageUrl:g_vars['defaultHeadImage']" alt="headImage">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <a :href="'#/user?username='+item.watcherUsername">
                                                            {{ item.watcherSex==1?"雄":item.watcherSex==2?"雌":"" }}
                                                            {{ item.watcherSpecies }}
                                                            {{ item.watcherName }}
                                                        </a>
                                                        <!-- <span class="badge">总管理兽</span>
                                                        <span class="badge">爱印爪</span> -->
                                                        <p>
                                                            <small>{{ item.watcherInfo }}</small>   
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </div>
                                    </div>
                                </ul>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-block"
                                    @click="myLoadMore1(userData,watcherData,loadNum1,viewNum1,10)"
                                    :class="{'disabled':noMore1}">
                                        <font-awesome-icon :icon="faPaintRoller" />
                                        加载更多
                                    </button>
                                </div>
                            </div>
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
            haveLoad: true,
            haveLog: false,
            haveWatch: false,
            userData: {},

            // myMode 显示自己还是他兽 1自己 2他兽
            // myUsername 要显示小兽的粉糖账号
            // 若为空则由粉糖粒子核心session提供（显示自己）
            // ShowMode 显示模式 见 WorkMathine Presenter
            // 上线设置 myMode:1 myUsername:"" gardenShowMode:2 galleryShowMode:2
            myMode: 1,
            myUsername: "",
            gardenShowMode: 2,
            galleryShowMode: 2,

            watcherData: {},
            noMore1: false,
            loadNum1: 3,
            viewNum1: 0,
            haveLoad1: false,

            myWatchData: {},
            noMore2: false,
            loadNum2: 3,
            viewNum2: 0,
            haveLoad2: false,
        }},
        methods: {
            getUser(){
                // 自有函数 获取小兽用户信息
                var sender = new Sender();
                var receiver = new Receiver();
                var obj = {action:3,todo:3,mode:this.myMode,username:this.myUsername,};
                sender.postSender(obj)
                .then(res=>{
                    var outArr = receiver.postReceiver(res);
                    this.userData = outArr;
                    // 载入和渲染粉丝和关注数据
                    let painter = new Painter();
                    if(outArr!=undefined){
                        painter.paint_arrNoKey(this.userData["watchers"],this.watcherData,this.loadNum1);
                        this.haveLoad1 = true;
                        painter.paint_arrNoKey(this.userData["myWatchs"],this.myWatchData,this.loadNum2);
                        this.haveLoad2 = true;
                    }
                    // 组件重新渲染
                    this.haveLoad = false;this.$nextTick(()=>{this.haveLoad=true;})
                });
            },
            addWatch(){
                // 关注一个小兽
                let sender = new Sender();
                let obj = {action:2,todo:8,username:this.myUsername};
                sender.postSender(obj);
            },
            myLoadMore1(theOutArr,showData,loadNum,viewNum,num){
                // 加载更多粉丝
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"watchers");
                if(num2==true){this.noMore1=true;}
                else{this.viewNum1=num2;this.loadNum1=num2;}
            },
            myLoadMore2(theOutArr,showData,loadNum,viewNum,num){
                // 加载更多关注
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,"myWatchs");
                if(num2==true){this.noMore2=true;}
                else{this.viewNum2=num2;this.loadNum2=num2;}
            },
        },
        mounted(){
            let sender = new Sender();
            let receiver = new Receiver();
            if(this.$route.query.username!=null){
                this.myMode = 2;
                this.myUsername = this.$route.query.username;
                this.gardenShowMode = 3;
                this.galleryShowMode = 3;
            };
            // 是否登录
            let obj1 = {action:1,todo:5};
            sender.postSender(obj1)
            .then(res=>{
                receiver.doNumberAct(res);
                if(res==1){this.haveLog=true;}
                this.getUser();
            });
            // 若不是自己的主页 判断是否关注了此小兽
            if(this.myMode!=1){
                sender.postSender({action:5,todo:3,username:this.myUsername})
                .then(res=>{if(res==1){
                    this.haveWatch=true;
                    this.haveLoad=false;this.$nextTick(()=>{this.haveLoad=true});
                }})
            }
        },
        watch: {
            $route(to,from){
                if(this.$route.query.username){
                    this.myMode = 2;
                    this.myUsername = this.$route.query.username;
                    this.gardenShowMode = 3;
                    this.galleryShowMode = 3;
                    this.getUser();
                    this.haveLoad = false;this.$nextTick(()=>{this.haveLoad=true;})
                    window.location.reload();
                }
                else{
                    // 自己
                    this.$router.go(0);
                }
            }
        },
    }
</script>

<style scoped>
</style>