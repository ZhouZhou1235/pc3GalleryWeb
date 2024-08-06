<!-- 页面 小兽花园盆栽 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
import { Sender } from '@/api/Messenger';
import webEntry from '@/components/webEntry.vue';
import g_vars from '@/configure';
import arr_postTag from '@/components/arr/arr_postTag.vue';
import router from '@/router';
import { FileMover } from '@/work/WebWorker';
import arr_postComment from '@/components/arr/arr_postComment.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faCalendar, faClockRotateLeft, faImage, faLeaf, faPaw, faStar, faTags } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <smallMenu/>
    <div v-if="!haveLog">
        <webEntry/>
    </div>
    <div v-if="haveLoad">
        <div class="container">
            <div class="row">
                <!-- 盆栽 -->
                <div class="col-sm-4 p-3 rounded">
                    <div class="card">
                        <div v-if="myPostData.fileUrl!=null">
                            <div class="card-img-top">
                                <img :src="myPostData.fileUrl?myPostData.fileUrl:g_vars['image404']" alt="postImage" width="100%">
                            </div>
                        </div>
                        <div class="card-header">{{ myPostData.title }}</div>
                        <div class="card-text">
                            <div v-if="haveLog">
                                <form>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="输入标签 多个用空格隔开" v-model="tags">
                                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <font-awesome-icon :icon="faTags" />
                                            标签
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" @click="addTags()">贴标签</a></li>
                                        <li><a class="dropdown-item" @click="cancelTags()">撕标签</a></li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                            <arr_postTag :postID="myPostID"></arr_postTag>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ myPostData.content }}
                            </p>
                            <p><font-awesome-icon :icon="faClockRotateLeft" /> {{ myPostData.updateTime }}</p>
                            <p><font-awesome-icon :icon="faCalendar" /> {{ myPostData.createdTime }}</p>
                            <button type="button" class="btn" @click="addPaw()" :class="{'btn-primary':havePaw}">
                                <font-awesome-icon :icon="faPaw" />
                                印爪<span class="badge">{{ myPostData.pawNum }}</span>
                            </button>
                            <button type="button" class="btn" @click="addStar()" :class="{'btn-primary':haveStar}">
                                <font-awesome-icon :icon="faStar" />
                                收藏<span class="badge">{{ myPostData.starNum }}</span>
                            </button>
                            <button type="button" class="btn">
                                <font-awesome-icon :icon="faLeaf" />
                                叶子<span class="badge">{{ myPostData.commentNum }}</span>
                            </button>
                        </div>
                        <div class="card-footer">
                            <a :href="'#/user?username='+myPostData.username">
                                <div class="row">
                                    <div class="col-3">
                                        <img :src="myPostData.headImageUrl?myPostData.headImageUrl:g_vars['defaultHeadImage']" alt="headImage" width="100%">
                                    </div>
                                    <div class="col-9">
                                        {{ myPostData.sex==1?"雄":myPostData.sex==2?"雌":"" }}
                                        {{ myPostData.species }}
                                        <br>
                                        {{ myPostData.name }}
                                    </div>
                                </div>
                            </a>
                            <!-- <span class="badge">总管理兽</span>
                            <span class="badge">爱印爪</span> -->
                        </div>
                    </div>
                </div>
                <!-- 盆栽叶 -->
                <div class="col-sm-8 p-3 rounded">
                    <ul class="list-group">
                        <!-- 盆栽叶表单 -->
                        <div v-if="haveLog">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-2 mt-1 p-1">
                                        <div class="squareBox">
                                            <img :src="userData.headImageUrl?userData.headImageUrl:g_vars['defaultHeadImage']" alt="headImage" width="100%">
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <form @submit.prevent="addPostComment()">
                                            <label for="comment">
                                                <font-awesome-icon :icon="faLeaf" />
                                                叶子
                                            </label>
                                            <textarea class="form-control" rows="3" id="comment" name="text" placeholder="跟帖......" v-model="formAddPostComment.content"></textarea>
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="inputGroupFile01">
                                                    <font-awesome-icon :icon="faImage" />
                                                    附图
                                                </label>
                                                <input type="file" class="form-control" id="inputGroupFile01" v-on:change="theFileReady($event)">
                                            </div>
                                            <div class="text-end"><button type="submit" class="btn justify-content-end">发送</button></div>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </div>
                        <arr_postComment :postID="myPostID"></arr_postComment>
                    </ul>
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
            havePaw: false,
            haveStar: false,
            myPostID: null,
            myPostData: {},
            userData: {},

            tags: "",
            formAddPostComment: {
                action: 2,
                todo: 4,
                mode: 2,
                file: "",
                content: "",
            },
        }},
        methods: {
            addTags(){
                // 添加标签
                var sender = new Sender();
                var obj = {action:2,todo:3,tags:this.tags,postID:this.myPostID,mode:2};
                sender.postSender(obj)
                .then(()=>{this.tags="";window.location.reload();})
            },
            cancelTags(){
                // 撕下标签
                var sender = new Sender();
                var obj = {action:4,todo:2,tags:this.tags,postID:this.myPostID,mode:2};
                sender.postSender(obj)
                .then(()=>{this.tags="";window.location.reload();})
            },
            addPaw(theCommentID=null){
                // 小兽印爪 commentID默认为空对盆栽印爪
                let sender = new Sender();
                let obj = {action:2,todo:5,postID:this.myPostID,commentID:theCommentID,mode:2};
                sender.postSender(obj)
                .then(()=>{window.location.reload();})
            },
            addStar(){
                // 小兽收藏
                let sender = new Sender();
                let obj = {action:2,todo:6,postID:this.myPostID,mode:2};
                sender.postSender(obj)
                .then(()=>{window.location.reload();})
            },
            theFileReady(event){
                // 文件装入表单
                let fileMover = new FileMover();
                fileMover.fileReady(event,this.formAddPostComment);
            },
            addPostComment(){
                // 添加盆栽叶
                this.formAddPostComment["postID"] = this.myPostID;
                let fileMover = new FileMover();
                fileMover.fileUpload(this.formAddPostComment);
                this.content = "";
                this.haveLoad=false;this.$nextTick(()=>{this.haveLoad=true});
            }
        },
        mounted(){
            let sender = new Sender();
            // 是否登录
            sender.postSender({action:1,todo:5,})
            .then((res)=>{
                if(res==1){this.haveLog=true;}
                // 获取小兽自己的信息
                sender.postSender({action:3,todo:3,mode:1})
                .then((res)=>{if(res!=undefined && res!=null){this.userData=res;}});
            })
            // 获取盆栽数据包
            this.myPostID = this.$route.query.postID;
            let obj = {action:3,todo:2,postID:this.myPostID,mode:4};
            sender.postSender(obj)
            .then((res)=>{
                if(res!=undefined && res!=null){
                    this.myPostData = res["mainData"][0];
                    this.haveLoad = true;
                }
            });
            // 是否印爪 收藏
            sender.postSender({action:5,todo:1,mode:2,postID:this.myPostID})
            .then((res)=>{if(res==1){this.havePaw=true;}})
            sender.postSender({action:5,todo:2,mode:2,postID:this.myPostID})
            .then((res)=>{if(res==1){this.haveStar=true;}})
        }
    }
</script>

<style scoped>
</style>