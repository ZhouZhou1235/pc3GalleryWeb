<!-- 子页面 消息 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
import router from '@/router';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <div class="container">
        <h2>小兽空间 - {{ GArea.furryUser.name }}的消息</h2>
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        大印爪
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>画廊印爪</h3>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.galleryPaws">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        印爪
                                        <RouterLink :to="'/gallery?galleryID='+item.galleryID">
                                            {{ item.title }}
                                        </RouterLink>
                                        {{ item.time }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h3>盆栽印爪</h3>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.postPaws">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        印爪
                                        <RouterLink :to="'/plantPot?postID='+item.postID">
                                            {{ item.title }}
                                        </RouterLink>
                                        {{ item.time }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                        小印爪
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <h2>画廊评论印爪</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.galleryCommentPaws">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        印爪
                                        <RouterLink :to="'/gallery?galleryID='+item.galleryID">
                                            {{ item.title }}
                                        </RouterLink>
                                        评论
                                        {{ item.content }}
                                        {{ item.time }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <h2>叶子印爪</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.postCommentPaws">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        印爪
                                        <RouterLink :to="'/plantPot?postID='+item.postID">
                                            {{ item.title }}
                                        </RouterLink>
                                        叶子
                                        {{ item.content }}
                                        {{ item.time }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                        收到回复
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>画廊评论</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.galleryComments">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        给画廊
                                        <RouterLink :to="'/gallery?galleryID='+item.galleryID">
                                            {{ item.title }}
                                        </RouterLink>
                                        评论
                                        {{ item.content }}
                                        {{ item.time }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <h2>叶子</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.postComments">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        让盆栽
                                        <RouterLink :to="'/plantPot?postID='+item.postID">
                                            {{ item.title }}
                                        </RouterLink>
                                        生长叶子
                                        {{ item.content }}
                                        {{ item.time }}
                                    </li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <h2>叶回复</h2>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"
                                    v-for="item in messageData.replys">
                                        <RouterLink :to="'/user?username='+item.username">
                                            {{ item.name }}
                                        </RouterLink>
                                        在盆栽
                                        <RouterLink :to="'/plantPot?postID='+item.postID">
                                            {{ item.title }}
                                        </RouterLink>
                                        的叶子
                                        {{ item.conten }}
                                        上贴纸条
                                        {{ item.replyContent }}
                                        {{ item.time }}
                                    </li>
                                </ul>
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
            messageData: {},
        }},
        methods: {
            getMessage(){
                // 获得消息数据
                Messager.getMessageData().then(res=>{
                    if(res!=undefined){
                        this.messageData = res;
                    }
                });
            },
        },
        mounted(){
            this.getMessage();
        },
    }
</script>

<style scoped>
</style>