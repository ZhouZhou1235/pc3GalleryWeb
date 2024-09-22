<!-- 盆栽 -->

<script setup>
    import { addFileToForm, Messager } from '@/api/ConnectCore';
import TagBox from '@/components/tagBox.vue';
import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 盆栽主体 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-img-top" v-if="postData.fileUrl!=null">
                        <img :src="postData.fileUrl" alt="postImage" width="100%">
                    </div>
                    <div class="card-body">
                        <h2>{{ postData.title }}</h2>
                        <p style="white-space: pre-line;">{{ postData.content }}</p>
                        <div>更新时间{{ postData.updateTime }}</div>
                        <div>种植时间{{ postData.createdTime }}</div>
                        <div class="btn-group">
                            <button class="btn" :class="{'btn-primary':postData.isPaw,'disabled':!GArea.furryUser.isLog}"
                            @click="changePostIsPaw()">
                                印爪<span class="badge text-bg-secondary">{{ postData.pawNum }}</span>
                            </button>
                            <button class="btn" :class="{'btn-primary':postData.isStar,'disabled':!GArea.furryUser.isLog}"
                            @click="changePostIsStar()">
                                收藏<span class="badge text-bg-secondary">{{ postData.starNum }}</span>
                            </button>
                            <button class="btn btn-success">
                                叶子<span class="badge">{{ postData.commentNum }}</span>
                            </button>
                        </div>
                        <div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="输入标签 多个用空格隔开" v-model="tags">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    标签
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item"  @click="addTags()">贴标签</a></li>
                                    <li><a class="dropdown-item" @click="cancelTags()">撕标签</a></li>
                                </ul>
                            </div>
                            <span v-for="tag in tagsData" class="badge text-bg-secondary">
                                {{ tag }}
                            </span>
                        </div>        
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-3">
                                                <RouterLink :to="'/user?username='+postData.username">
                                                    <div class="squareBox">
                                                        <img :src="postData.headImageUrl!=null?postData.headImageUrl:GArea.staticFiles.defaultHead" alt="headImage">
                                                    </div>
                                                </RouterLink>
                                            </div>
                                            <div class="col-9">
                                                <h2>{{ postData.name }}</h2>
                                                <h3>
                                                    {{ postData.sex==1?"雄":postData.sex==2?"雌":"" }}
                                                    {{ postData.species }}
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-2">
                        <img :src="GArea.furryUser.headImage!=null?GArea.furryUser.headImage:GArea.staticFiles.defaultHead"
                        alt="headImage" width="100%">
                    </div>
                    <div class="col-10">
                        叶子
                        <textarea name="" class="form-control" placeholder="内容......" rows="6"
                        v-model="addPostCommentForm.content"></textarea>
                        <input type="file" class="form-control" @change="addCommentImageToForm($event)">
                        <div class="text-end">
                            <button class="btn btn-outline-secondary" @click="sendComment()">生长</button>
                        </div>
                    </div>
                </div>
                <div class="row p-3" v-for="item in postCommentData">
                    <div class="col-2">
                        <RouterLink :to="'/user?username='+item.username">
                            <img :src="item.headImageUrl!=null?item.headImageUrl:GArea.staticFiles.defaultHead"
                            alt="headImage" width="100%">
                        </RouterLink>
                    </div>
                    <div class="col-10">
                        <div style="font-size: 1.2em; font-weight: bold;">
                            {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                            {{ item.species }}
                            {{ item.name }}
                        </div>
                        <div style="white-space: pre-line;">{{ item.content }}</div>
                        <div v-if="item.commentImageUrl!=null">
                            <img :src="item.commentImageUrl" alt="headImage" width="100%">
                        </div>
                        <div>时间{{ item.time }}</div>
                        <div class="container">
                            <button class="btn" :class="{'btn-primary':item.isPaw,'disabled':!GArea.furryUser.isLog}"
                            @click="changeCommentIsPaw(item)">印爪<span class="badge text-bg-secondary">{{ item.pawNum }}</span></button>
                            <button type="button" class="btn" data-bs-toggle="collapse" :data-bs-target="'#'+item.commentID">叶纸条<span class="badge text-bg-secondary">{{ item.replyNum }}</span></button>
                            <div :id="item.commentID" class="collapse">
                                <div class="container">
                                    <label for="comment">叶纸条</label>
                                    <textarea class="form-control" rows="3" placeholder="叶纸条......" v-model="content"></textarea>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-outline-secondary"
                                        @click="sendCommentReply(item.commentID)">贴上</button>
                                    </div>
                                </div>
                                <div v-for="i in item.replys">
                                    <a :href="'/user=?username='+i.replyerUsername">
                                        {{ i.replyerName }}
                                    </a>
                                    <p>{{ i.replyContent }}</p>
                                    <p>{{ i.replyTime }}</p>
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
            postData: {},
            postCommentData: {},
            tagsData: {},
            tags: "",
            addPostCommentForm: {
                postID: "",
                content: "",
                file: null,
            },
            sending: false,
            content: "", // 叶回复内容
        }},
        methods: {
            getAndShowPost(){
                // 获取并显示盆栽
                let postID = this.$route.query.postID;
                Messager.getPostData(postID).then(res=>{
                    if(res!=undefined){
                        this.postData = res.mainData[0];
                        this.addPostCommentForm.postID = this.postData.postID;
                        Messager.getTagsMask(2,this.postData.postID).then(res=>{
                            if(res!=undefined){
                                this.tagsData=res.tags;
                            }
                        });
                        Messager.getCommentData(2,this.postData.postID).then(res=>{
                            if(res!=undefined){
                                this.postCommentData = res.comments;
                            }
                        });
                    }
                });
            },
            addCommentImageToForm(e){
                // 将叶子附图装入发送表单
                addFileToForm(this.addPostCommentForm,e);
            },
            changePostIsPaw(){
                // 盆栽印爪
                if(this.postData.isPaw){this.postData.pawNum--;this.postData.isPaw=false;}
                else{this.postData.pawNum++;this.postData.isPaw=true;}
                Messager.requestIsPaw(3,this.postData.postID);
            },
            changePostIsStar(){
                // 盆栽收藏
                if(this.postData.isStar){this.postData.starNum--;this.postData.isStar=false;}
                else{this.postData.starNum++;this.postData.isStar=true;}
                Messager.requestIsStar(2,this.postData.postID);
            },
            sendComment(){
                // 生长叶子
                if(this.addPostCommentForm.content==null){return;}
                this.sending = true;
                Messager.sendPostComment(this.addPostCommentForm).then((res)=>{
                    this.sending = false;
                    this.addPostCommentForm.content = "";
                    this.addPostCommentForm.file = null;
                    this.getAndShowPost();
                });
            },
            sendCommentReply(id){
                // 叶回复
                Messager.sendCommentReply(this.content,id);
                this.content = "",
                this.getAndShowPost();
            },
            changeCommentIsPaw(theItem){
                // 叶子印爪
                if(theItem.isPaw){theItem.pawNum--;theItem.isPaw=false;}
                else{theItem.pawNum++;theItem.isPaw=true;}
                Messager.requestIsPaw(4,this.postData.postID,theItem.commentID);
            },
            addTags(){
                // 贴标签
                Messager.addTags(2,this.tags,this.postData.postID);
                this.getAndShowPost();
                this.tags = "";
            },
            cancelTags(){
                // 撕标签
                Messager.cancelTags(2,this.tags,this.postData.postID);
                this.getAndShowPost();
                this.tags = "";
            },
        },
        mounted(){
            this.getAndShowPost();
        },
        watch: {
            $route(to,from){
                if(this.$route.query.postID){
                    this.getAndShowPost();
                }
            }
        },
    }
</script>

<style scoped>
</style>