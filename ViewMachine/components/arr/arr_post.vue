<!-- 数据组 盆栽 -->

<script setup>
import { Receiver, Sender } from '@/api/Messenger';
import { Painter } from '@/work/WebWorker';
import g_vars from '@/configure';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faPaintRoller, faPaw } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <!-- 小兽花园 -->
    <div v-for="item in gardenData">
        <div class="card">
            <div v-if="item.fileUrl!=null">
                <div class="card-img-top">
                    <a :href="'#/post?postID='+item.postID">
                        <img :src="item.fileUrl" alt="postImage" class="img-thumbnail" width="100%">
                    </a>
                </div>
            </div>
            <div class="card-header">
                <a :href="'#/post?postID='+item.postID">
                    <h3>{{ item.title }}</h3>
                </a>
            </div>
            <div class="card-text">
                <button type="button" class="btn" @click="addPaw(item.postID)">
                    <font-awesome-icon :icon="faPaw" />
                    印爪<span class="badge">{{ item.pawNum }}</span>
                </button>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-3">
                        <a :href="'#/user?username='+item.username">
                            <div class="squareBox">
                                <img :src="item.headImageUrl?item.headImageUrl:g_vars['defaultHeadImage']" alt="headImage">
                            </div> 
                        </a>
                    </div>
                    <div class="col-9">
                        <a :href="'#/user?username='+item.username">
                            {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                            {{ item.species }}
                            <br>
                            {{ item.name }}
                        </a>
                        <br>
                        <!-- <span class="badge">徽章1</span>
                        <span class="badge">徽章2</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-grid">
        <button type="button" class="btn btn-block" :class="{'disabled': noMore}" @click="myLoadMore(theOutArr,gardenData,loadNum,viewNum,10)">
            <font-awesome-icon :icon="faPaintRoller" />
            加载更多
        </button>
    </div>
</template>

<script>
    export default {
        props: ["mode","username"],
        data(){return{
            haveLog: false,
            gardenData: {},
            theOutArr: {},
            loadNum: 10,
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
            addPaw(thePostID){
                var sender = new Sender();
                sender.postSender({action:2,todo:5,postID:thePostID,mode:2})
            },
        },
        mounted(){
            var sender = new Sender();
            var receiver = new Receiver();
            // 获取盆栽数据包
            var outArr;
            var obj1 = {action:3,todo:2,mode:this.myMode,username:this.myUsername};
            sender.postSender(obj1)
            .then(res=>{
                outArr=receiver.postReceiver(res);
                let painter = new Painter();
                this.theOutArr = painter.paint_arr(outArr,this.gardenData,this.loadNum);
            });
        },
    }
</script>

<style scoped>
</style>