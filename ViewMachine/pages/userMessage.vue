<!-- 页面 消息 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import { Sender } from '@/api/Messenger';
import { faComment, faCommentDots, faLeaf, faPaw } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <smallMenu/>
    <div v-if="true">
        <!-- 消息 -->
        <div class="container">
            <div class="container rounded p-3">
                <span style="font-size: 2em; font-weight: bold;">
                    {{ userData.sex==1?"雄":userData.sex==2?"雌":"" }}
                    {{ userData.species }}
                    {{ userData.name }}
                    的消息
                </span>
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="pill" href="#home">
                            <font-awesome-icon :icon="faPaw" />
                            画廊
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu1">
                            <font-awesome-icon :icon="faPaw" />
                            画廊评论
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu2">
                            <font-awesome-icon :icon="faComment" />
                            画廊
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu3">
                            <font-awesome-icon :icon="faPaw" />
                            盆栽
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu4">
                            <font-awesome-icon :icon="faPaw" />
                            叶子
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu5">
                            <font-awesome-icon :icon="faLeaf" />
                            叶子
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="pill" href="#menu6">
                            <font-awesome-icon :icon="faCommentDots" />
                            叶回复
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="home" class="container tab-pane active">
                        <ul class="list-group">
                            <div v-for="item in messageData.galleryPaws">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    给画廊
                                    <a :href="'#/gallery?galleryID='+item.galleryID">
                                        {{ item.title }}
                                    </a>
                                    印爪了
                                    {{ item.time }}
                                </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
                    </div>
                    <div id="menu1" class="container tab-pane fade">
                        <ul class="list-group">
                            <div v-for="item in messageData.galleryCommentPaws">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    给您在画廊
                                    <a :href="'#/gallery?galleryID='+item.galleryID">
                                        {{ item.title }}
                                    </a>
                                    留下的评论
                                    {{ item.content }}
                                    印爪了
                                    {{ item.time }}
                                </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
                    </div>
                    <div id="menu2" class="container tab-pane fade">
                        <ul class="list-group">
                            <div v-for="item in messageData.galleryComments">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    对您上传的画廊
                                    <a :href="'#/gallery?galleryID='+item.galleryID">
                                        {{ item.title }}
                                    </a>
                                    作出了评论
                                    {{ item.content }}
                                    {{ item.time }}
                                </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
                    </div>
                    <div id="menu3" class="container tab-pane fade">
                        <ul class="list-group">
                            <div v-for="item in messageData.postPaws">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    给盆栽
                                    <a :href="'#/post?postID='+item.postID">
                                        {{ item.title }}
                                    </a>
                                    印爪了
                                    {{ item.time }}
                                </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
                    </div>
                    <div id="menu4" class="container tab-pane fade">
                        <ul class="list-group">
                            <div v-for="item in messageData.postCommentPaws">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    给您让盆栽
                                    <a :href="'#/post?postID='+item.postID">
                                        {{ item.title }}
                                    </a>
                                    长出的叶子
                                    {{ item.content }}
                                    印爪了
                                    {{ item.time }}
                                </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
                    </div>
                    <div id="menu5" class="container tab-pane fade">
                        <ul class="list-group">
                            <div v-for="item in messageData.postComments">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    让你种植的盆栽
                                    <a :href="'#/post?postID='+item.postID">
                                        {{ item.title }}
                                    </a>
                                    长出叶子
                                    {{ item.content }}
                                    {{ item.time }}
                                </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
                    </div>
                    <div id="menu6" class="container tab-pane fade">
                        <ul class="list-group">
                            <div v-for="item in messageData.replys">
                                <li class="list-group-item">
                                    <a :href="'#/user?username='+item.username">
                                        {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                        {{ item.species }}
                                        {{ item.name }}
                                    </a>
                                    在您让盆栽
                                    <a :href="'#/post?postID='+item.postID">
                                        {{ item.title }}
                                    </a>
                                    长出的叶子
                                    {{ item.content }}
                                    留下回复
                                    {{ item.replyContent }}
                                    {{ item.time }}
                                    </li>
                            </div>
                            <li class="list-group-item">
                                PINKCANDY 粉糖粒子核心提供计算
                            </li>
                        </ul>
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
            userData: {},
            messageData: {},
        }},
        methods: {

        },
        mounted(){
            let sender = new Sender();
            // 是否登录
            sender.postSender({action:1,todo:5})
            .then(res=>{if(res==1){
                this.haveLog = true;
                // 获取小兽信息
                sender.postSender({action:3,todo:3,mode:1})
                .then(res=>{
                    if(res!=3){
                        this.userData=res;
                        // 获取消息数据包
                        let obj = {action:3,todo:7,mode:1};
                        sender.postSender(obj)
                        .then(res=>{
                            if(res!=undefined){
                                this.messageData = res;
                                this.haveLoad = true;
                            }
                        })
                    }
                })
            }})
        },
    }
</script>

<style scoped>
</style>