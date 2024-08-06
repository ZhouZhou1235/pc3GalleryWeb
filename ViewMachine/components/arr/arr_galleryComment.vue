<!-- 数据组 画廊评论 -->

<script setup>
import { Sender } from '@/api/Messenger';
import router from '@/router';
import g_vars from '@/configure';
import { Painter } from '@/work/WebWorker';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faPaintRoller, faPaw } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <div v-for="item in showComment">  
        <div class="row">
            <div class="col-1 mt-1 p-1">
                <a :href="'#/user?username='+item.username">
                    <div class="squareBox">
                        <img :src="item.headImageUrl?item.headImageUrl:g_vars['defaultHeadImage']" alt="headImage" width="100%">
                    </div>
                </a>
            </div>
            <div class="col-11">
                {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                {{ item.species }}
                {{ item.name }}
                <!-- <span class="badge">xxx</span>
                <span class="badge">xxx</span> -->
                <p>{{ item.content }}</p>
                <p>
                    <button type="button" class="btn" @click="addPaw(item.commentID)">
                        <font-awesome-icon :icon="faPaw" />
                        印爪<span class="badge">{{ item.pawNum }}</span>
                    </button>
                    {{ showTime(item.time) }}
                </p>
            </div>
        </div>    
    </div>
    <div class="d-grid">
        <button type="button" class="btn btn-block"
        :class="{'disabled': noMore}"
        @click="myLoadMore(myComment,showComment,loadNum,viewNum,5,'comments')">
            <font-awesome-icon :icon="faPaintRoller" />
            加载更多
        </button>
    </div>
</template>

<script>
    export default {
        props: ["galleryID"],
        data(){return{
            loadNum: 5,
            viewNum: 0,
            showComment: {},
            noMore: false,
            myGalleryID: this.galleryID,
        }},
        methods: {
            myLoadMore(theOutArr,showData,loadNum,viewNum,num,arrKey){
                // 加载更多评论
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,arrKey);
                if(num2==true){this.noMore=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
            showTime(timeStr,mode=1){
                // 时间字符串格式化
                // mode 1完整 2仅日期
                var theTime = new Date(timeStr);
                var year = theTime.getFullYear();
                var month = theTime.getMonth();
                var date = theTime.getDate();
                var hour = theTime.getHours();
                var minute = theTime.getMinutes();
                var secend = theTime.getSeconds();
                if(mode==1){var outStr = year+"/"+month+"/"+date+" "+hour+":"+minute+":"+secend;}
                if(mode==2){var outStr = year+"/"+month+"/"+date}
                return outStr;
            },
            addPaw(theCommentID){
                // 小兽印爪
                var sender = new Sender();
                var obj = {action:2,todo:5,galleryID:this.myGalleryID,commentID:theCommentID,mode:1};
                sender.postSender(obj);
            },
        },
        mounted(){
            // 获取画廊评论
            let sender = new Sender();
            let obj = {action:3,todo:5,galleryID:this.myGalleryID,mode:1};
            sender.postSender(obj)
            .then((res)=>{
                if(res!=undefined && res!=0){
                    this.myComment=res;
                    if(this.loadNum>res["comments"].length){
                        this.loadNum=res["comments"].length;
                    }
                    for(let i=this.viewNum;i<this.loadNum;i++){
                        var addObj = this.myComment["comments"][i];
                        this.showComment[i] = addObj;
                    }
                }
            });
        },
    }
</script>

<style scoped>
</style>