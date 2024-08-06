<!-- 数据组 画廊 -->

<script setup>
import router from '@/router';
import { Receiver, Sender } from '../../api/Messenger';
import { Painter } from '../../work/WebWorker';
import g_vars from '@/configure';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faComment, faPaintRoller, faPaw, faStar } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <!-- 毛绒画廊 -->
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
                    <button type="button" class="btn" @click="addPaw(item.galleryID)">
                        <font-awesome-icon :icon="faPaw" />
                        印爪<span class="badge">{{ item.pawNum }}</span>
                    </button>
                    <button type="button" class="btn" @click="addStar(item.galleryID)">
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
    <div class="d-grid">
        <button type="button" class="btn btn-block" :class="{'disabled': noMore}" @click="myLoadMore(theOutArr,galleryData,loadNum,viewNum,10)">
            <font-awesome-icon :icon="faPaintRoller" />
            加载更多
        </button>
    </div>
</template>

<script>
    export default {
        props: ["mode","username"],
        data(){return{
            galleryData: {},
            theOutArr: {},
            loadNum: 20,
            viewNum: 0,
            noMore: false,

            myMode: this.mode,
            myUsername: this.username,
        }},
        methods: {
            myLoadMore(theOutArr,showData,loadNum,viewNum,num){
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num);
                if(num2==true){this.noMore=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
            addPaw(theGalleryID){
                // 小兽印爪
                var sender = new Sender();
                var obj = {action:2,todo:5,galleryID:theGalleryID,mode:1};
                sender.postSender(obj)
            },
            addStar(theGalleryID){
                // 小兽收藏
                var sender = new Sender();
                var obj = {action:2,todo:6,galleryID:theGalleryID,mode:1};
                sender.postSender(obj)
            },
        },
        mounted(){
            var sender = new Sender();
            var receiver = new Receiver();
            // 获取画廊数据包
            var outArr;
            var obj1 = {action:3,todo:1,mode:this.myMode,username:this.myUsername,};
            sender.postSender(obj1)
            .then(res=>{
                outArr=receiver.postReceiver(res);
                let painter = new Painter();
                this.theOutArr = painter.paint_arr(outArr,this.galleryData,this.loadNum);
            });
        },
    }
</script>

<style scoped>
</style>