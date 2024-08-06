<!-- 数据组 盆栽列表 -->

<script setup>
import { Sender } from '@/api/Messenger';
import router from '@/router';
import { Painter } from '@/work/WebWorker';
import form_changePost from '../form/form_changePost.vue';
</script>

<template>
    <ul class="list-group">
        <div v-for="item in myPostData">
            <li class="list-group-item">
                <button class="btn" data-bs-toggle="modal" :data-bs-target="'#'+item.postID">修改</button>
                印爪<span class="badge">{{ item.pawNum }}</span>
                收藏<span class="badge">{{ item.starNum }}</span>
                叶子<span class="badge">{{ item.commentNum }}</span>
                <a :href="'#/post?postID='+item.postID">
                    {{ item.title }}
                </a>
                创建时间 {{ item.createdTime }}
                <form_changePost
                    :postID="item.postID"
                    :title="item.title"
                    :content="item.content"
                    :username="myUsername"></form_changePost>
            </li>
        </div>
    </ul>
    <div class="d-grid">
        <button type="button" class="btn btn-block" @click="myLoadMore(theOutArr,myPostData,loadNum,viewNum,10)" :class="{'disabled':noMore}">
            加载更多
        </button>
    </div>
</template>

<script>
    export default {
        props: ["mode","username"],
        data(){return{
            myUsername: this.username,
            myMode: this.mode,
            myPostData: {},
            theOutArr: {},
            loadNum: 10,
            viewNum: 0,
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
            let sender = new Sender();
            let obj = {action:3,todo:2,mode:this.myMode,username:this.myUsername};
            sender.postSender(obj)
            .then(res=>{
                if(res!=3){
                    let painter = new Painter();
                    this.theOutArr = painter.paint_arr(res,this.myPostData,this.loadNum);
                    this.haveLoad=true;
                }
            })
        },
    }
</script>

<style scoped>
</style>