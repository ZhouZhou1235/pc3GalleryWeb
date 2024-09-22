<!-- 画廊 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import tagBox from '@/components/tagBox.vue';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 画廊主体 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <!-- 画廊图片 -->
                <div class="border border-secondary border-3 rounded">
                    <img :src="galleryData.fileUrl!=null?galleryData.fileUrl:GArea.staticFiles.image404" alt="galleryImage" width="100%">
                </div>
                <!-- 评论区 -->
                <div class="container p-3">
                    <div class="row">
                        <div class="col-1 p-0">
                            <div class="squareBox">
                                <img :src="GArea.furryUser.headImage!=null?GArea.furryUser.headImage:GArea.staticFiles.defaultHead" alt="headImage" width="100%">
                            </div>
                        </div>
                        <div class="col-11">
                            <label for="comment">评论</label>
                            <textarea class="form-control" rows="5" id="comment" name="text" placeholder="评论......" v-model="content"></textarea>
                            <div class="text-end"><button type="submit" class="btn btn-outline-secondary"
                                @click="sendComment()">发送</button></div>
                        </div>
                    </div>
                    <div class="row" v-for="item in showCommentData">
                        <div class="col-1 p-0">
                            <RouterLink :to="'/user?username='+item.username">
                                <div class="squareBox">
                                    <img :src="item.headImageUrl!=null?item.headImageUrl:GArea.staticFiles.defaultHead" alt="headImage" width="100%">
                                </div>
                            </RouterLink>
                        </div>
                        <div class="col-11">
                            <div style="font-size: 1.2em; font-weight: bold">
                                {{ item.sex==1?"雄":item.sex==2?"雌":"" }}
                                {{ item.species }}
                                {{ item.name }}
                            </div>
                            <div>{{ item.content }}</div>
                            <div>{{ item.time }}</div>
                            <button class="btn" :class="{'btn-primary':item.isPaw,'disabled':!GArea.furryUser.isLog}"
                            @click="changeCommentIsPaw(item)">印爪<span class="badge text-bg-secondary">{{ item.pawNum }}</span></button>
                        </div>
                    </div>
                    <div class="d-grid" v-if="!allDone">
                        <button type="button" class="btn btn-outline-secondary" @click="loadMoreComment()">
                            加载更多
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <!-- 画廊信息 -->
                <div class="row">
                    <div class="col text-break">
                        <h1>{{ galleryData.title }}</h1>
                        <p>{{ galleryData.info }}</p>
                        <p>{{ galleryData.createdTime }}</p>
                        <div class="btn-group">
                            <button class="btn" :class="{'btn-primary':galleryData.isPaw,'disabled':!GArea.furryUser.isLog}"
                            @click="changeGalleryIsPaw()">
                                印爪<span class="badge text-bg-secondary">{{ galleryData.pawNum }}</span>
                            </button>
                            <button class="btn" :class="{'btn-primary':galleryData.isStar,'disabled':!GArea.furryUser.isLog}"
                            @click="changeGalleryIsStar()">
                                收藏<span class="badge text-bg-secondary">{{ galleryData.starNum }}</span>
                            </button>
                            <button class="btn btn-info">
                                评论<span class="badge">{{ galleryData.commentNum }}</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <div class="backImageBox">
                                    <img :src="galleryData.backImageUrl!=null?galleryData.backImageUrl:GArea.staticFiles.defaultBack" alt="backImage">
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <RouterLink :to="'/user?username='+galleryData.username">
                                            <div class="squareBox">
                                                <img :src="galleryData.headImageUrl!=null?galleryData.headImageUrl:GArea.staticFiles.defaultHead" alt="headImage">
                                            </div>
                                        </RouterLink>
                                    </div>
                                    <div class="col-9">
                                        <h2>{{ galleryData.name }}</h2>
                                        <h3>
                                            {{ galleryData.sex==1?"雄":galleryData.sex==2?"雌":"" }}
                                            {{ galleryData.species }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container border border-secondary border-3 rounded">
                    <div class="row">
                        <h2>画廊标签</h2>
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
                    </div>
                    <div class="container">
                        <tagBox :theData="tagsData" :key="tagBoxKey"></tagBox>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            galleryData: {},
            commentData: {},
            showCommentData: {},
            tagsData: {},

            content: "",
            tags: "",

            loadNum: 0,
            allDone: false,

            tagBoxKey: 0,
        }},
        methods: {
            loadMoreComment(){
                // 加载更多评论
                if(this.commentData==undefined){this.allDone=true;return;}
                let i = this.loadNum;
                this.loadNum += 3;
                if(this.loadNum>this.commentData.length){
                    this.loadNum=this.commentData.length;
                    this.allDone = true;
                }
                for(i;i<this.loadNum;i++){
                    this.showCommentData[i] = this.commentData[i];
                }
            },
            showOrUpdateGallery(){
                // 展示或刷新画廊
                let galleryID = this.$route.query.galleryID;
                Messager.getGalleryData(galleryID).then(res=>{
                    this.galleryData = res.mainData[0];
                    document.title = "画廊 - "+this.galleryData.title;
                    Messager.getCommentData(1,this.galleryData.galleryID).then(res=>{
                        this.commentData = res.comments;
                        this.loadMoreComment();
                    });
                    Messager.getTagsMask(1,this.galleryData.galleryID).then(res=>{
                        this.tagsData = res.tags;
                        this.tagBoxKey += 1;
                    });
                });
            },
            changeGalleryIsPaw(){
                // 画廊印爪
                if(this.galleryData.isPaw){this.galleryData.pawNum--;this.galleryData.isPaw=false;}
                else{this.galleryData.pawNum++;this.galleryData.isPaw=true;}
                Messager.requestIsPaw(1,this.galleryData.galleryID);
            },
            changeGalleryIsStar(){
                // 画廊收藏
                if(this.galleryData.isStar){this.galleryData.starNum--;this.galleryData.isStar=false;}
                else{this.galleryData.starNum++;this.galleryData.isStar=true;}
                Messager.requestIsStar(1,this.galleryData.galleryID);
            },
            sendComment(){
                // 发送评论
                if(this.content==null){return;}
                Messager.sendGalleryComment(this.galleryData.galleryID,this.content).then(()=>{
                    this.content = "";
                    this.showOrUpdateGallery();
                });
            },
            changeCommentIsPaw(theItem){
                // 画廊评论印爪
                if(theItem.isPaw){theItem.pawNum--;theItem.isPaw=false;}
                else{theItem.pawNum++;theItem.isPaw=true;}
                Messager.requestIsPaw(2,this.galleryData.galleryID,theItem.commentID);
            },
            addTags(){
                // 贴标签
                Messager.addTags(1,this.tags,this.galleryData.galleryID);
                this.showOrUpdateGallery();
                this.tags = "";
            },
            cancelTags(){
                // 撕标签
                Messager.cancelTags(1,this.tags,this.galleryData.galleryID);
                this.showOrUpdateGallery();
                this.tags = "";
            },
        },
        mounted(){
            this.showOrUpdateGallery();
        },
        watch: {
            $route(to,from){
                if(this.$route.query.galleryID){
                    this.showOrUpdateGallery();
                }
            }
        },
    }
</script>

<style scoped>
</style>