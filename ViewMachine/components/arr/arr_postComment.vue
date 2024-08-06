<!-- 数据组 叶子 -->

<script setup>
import { Sender } from '@/api/Messenger';
import g_vars from '@/configure';
import router from '@/router';
import { Painter } from '@/work/WebWorker';
import { faPaw } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <div v-if="haveLoad">
        <div v-for="item in postCommentData">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-2 mt-1 p-1">
                        <div class="squareBox">
                            <a :href="'#/user?username='+item.username">
                                <img :src="item.headImageUrl?item.headImageUrl:g_vars['defaultHeadImage']" alt="headImage" width="100%">
                            </a>
                        </div>
                    </div>
                    <div class="col-10">
                        <p>
                            {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                            {{ item.species }}
                            <br>
                            {{ item.name }}
                            <!-- <span class="badge">总管理兽</span>
                            <span class="badge">爱印爪</span> -->
                        </p>
                        <p>{{ item.content }}</p>
                        <div v-if="item.commentImageUrl!=null">
                            <img :src="item.commentImageUrl" alt="commentImage" width="50%">
                        </div>
                        <p>{{ item.time }}</p>
                        <div class="container-sm">
                            <button class="btn" @click="addPaw(item.commentID)">
                                <font-awesome-icon :icon="faPaw" />
                                印爪<span class="badge">{{ item.pawNum }}</span>
                            </button>
                            <button type="button" class="btn" data-bs-toggle="collapse" :data-bs-target="'#'+item.commentID">回复<span class="badge">{{ item.replyNum }}</span></button>
                            <div :id="item.commentID" class="collapse">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <form @submit.prevent="addReply(item.commentID)">
                                            <label for="comment">回复</label>
                                            <textarea class="form-control" rows="2" id="comment" name="text" placeholder="回复......" v-model="content"></textarea>
                                            <div class="text-end"><button type="submit" class="btn justify-content-end">发送</button></div>
                                        </form>        
                                    </li>
                                    <div v-for="theReply in item.replys">
                                        <li class="list-group-item">
                                            <a :href="'#/user?username='+theReply.replyerUsername">
                                                {{ theReply.replyerName }}
                                            </a>
                                            <p>{{ theReply.replyContent }}</p>
                                            <p>{{ theReply.replyTime }}</p>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </div>
        <div class="d-grid">
            <button type="button" class="btn btn-block"
            :class="{'disabled':noMore}"
            @click="myLoadMore(theOutArr,postCommentData,loadNum,viewNum,10,'comments')">
                加载更多
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["postID"],
        data(){return{
            haveLoad: false,
            myPostID: this.postID,
            theOutArr: {},
            postCommentData: {},
            loadNum: 10,
            viewNum: 0,
            noMore: false,
            // 回复内容
            content: "",
        }},
        methods: {
            myLoadMore(theOutArr,showData,loadNum,viewNum,num,arrKey){
                // 加载更多盆栽叶
                let painter = new Painter();
                let num2 = painter.loadMore(theOutArr,showData,loadNum,viewNum,num,arrKey);
                if(num2==true){this.noMore=true;}
                else{this.viewNum=num2;this.loadNum=num2;}
            },
            addPaw(theCommentID){
                // 添加盆栽叶印爪
                // theCommentID 要印爪的盆栽叶号码
                let sender = new Sender();
                let obj = {action:2,todo:5,postID:this.myPostID,commentID:theCommentID,mode:2};
                sender.postSender(obj);
            },
            addReply(theCommentID){
                // 添加盆栽叶回复
                // theCommentID 要回复的盆栽叶号码
                let sender = new Sender();
                sender.postSender({action:2,todo:7,commentID:theCommentID,content:this.content,});
                this.haveLoad=false;this.$nextTick(()=>{this.haveLoad=true;})
                this.content = "";
            },
        },
        mounted(){
            let sender = new Sender();
            let painter = new Painter();
            let obj = {action:3,todo:5,postID:this.myPostID,mode:2};
            sender.postSender(obj)
            .then((res)=>{
                if(res!=undefined && res!=null){
                    let outArr = res;
                    if(res!=0 && res!=3){
                        this.theOutArr = painter.paint_arr(outArr,this.postCommentData,this.loadNum,"comments");
                        this.haveLoad = true;
                    }
                }
            })
        },
    }
</script>

<style scoped>
</style>