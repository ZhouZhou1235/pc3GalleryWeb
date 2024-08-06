<!-- 数据组 画廊列表 -->

<script setup>
import { Sender,Receiver } from '@/api/Messenger';
import form_changeGallery from '../form/form_changeGallery.vue';
import { Painter } from '@/work/WebWorker';
import router from '@/router';
import g_vars from '@/configure';
</script>

<template>
    <div v-if="haveLoad">
        <ul class="list-group">
            <div v-for="item in galleryData">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-sm-4">
                            <img :src="item.fileUrl?item.fileUrl:g_vars['image404']" alt="galleryImage" width="100%">
                        </div>
                        <div class="col-sm-8">
                            <a :href="'#/gallery?galleryID='+item.galleryID">
                                {{ item.title }}
                            </a>
                            <p>{{ item.info }}</p>
                            <p>{{ item.createdTime }}</p>
                            印爪<span class="badge">{{ item.pawNum }}</span>
                            收藏<span class="badge">{{ item.starNum }}</span>
                            评论<span class="badge">{{ item.commentNum }}</span>
                            <button class="btn" data-bs-toggle="modal" :data-bs-target="'#form'+item.galleryID">修改</button>
                            <form_changeGallery
                            :galleryID="item.galleryID"
                            :title="item.title"
                            :info="item.info"
                            :username="myUsername"></form_changeGallery>
                        </div>
                    </div>
                </li>
            </div>
        </ul>
        <div class="d-grid">
            <button type="button" class="btn btn-block"
            @click="myLoadMore(outArrData,galleryData,loadNum,viewNum,10)"
            :class="{'disabled':noMore}">
                加载更多
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["mode","username"],
        data(){return{
            haveLoad: true,
            myMode: this.mode,
            myUsername: this.username,
            outArrData: {},
            galleryData: {},
            viewNum: 0,
            loadNum: 10,
            noMore: false,
        }},
        methods: {
            myLoadMore(theOutArr,showData,loadNum,viewNum,num){
                // 加载更多
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num);
                if(num2==true){this.noMore=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
        },
        mounted(){
            // 获取小兽的画廊
            var sender = new Sender();
            sender.postSender({action:3,todo:1,mode:this.myMode,username:this.myUsername})
            .then((res)=>{
                if(res!=3){
                    var painter = new Painter();
                    this.outArrData=painter.paint_arr(res,this.galleryData,this.loadNum);
                }
            })
        },
    }
</script>

<style scoped>
</style>