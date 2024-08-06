<!-- 页面 毛绒画廊展示 -->

<script setup>
import smallMenu from '@/components/smallMenu.vue';
import { Sender,Receiver } from '@/api/Messenger';
import webEntry from '@/components/webEntry.vue';
import router from '@/router';
import g_vars from '@/configure';
import arr_galleryTag from '@/components/arr/arr_galleryTag.vue';
import arr_galleryComment from '@/components/arr/arr_galleryComment.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBookOpen, faCalendar, faComment, faPaw, faStar, faTags } from '@fortawesome/free-solid-svg-icons';
</script>

<template>
    <smallMenu/>
    <div v-if="!haveLog">
        <webEntry/>
    </div>
    <div v-if="haveLoad">
        <!-- 画廊内容 -->
        <div class="container">
            <div class="row">
                <div class="col-sm-8 p-3 rounded">
                    <div class="card">
                        <div class="card-img-top">
                            <img :src="myGalleryData.fileUrl?myGalleryData.fileUrl:g_vars['image404']" alt="galleryImage" width="100%">
                        </div>
                        <div class="card-header">
                            <h3>{{ myGalleryData.title }}</h3>
                        </div>
                        <div class="card-body">
                            <font-awesome-icon :icon="faBookOpen" />
                            {{ myGalleryData.info }}
                            <br>
                            <font-awesome-icon :icon="faCalendar" />
                            {{ showTime(myGalleryData.createdTime) }}
                        </div>
                        <div class="card-footer">
                            <form v-if="haveLog">
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
                            <arr_galleryTag :galleryID="myGalleryID"></arr_galleryTag>
                        </div>
                        <div class="card-text">
                            <button type="button" class="btn" @click="addPaw()" :class="{'btn-primary': havePaw}">
                                <font-awesome-icon :icon="faPaw" />
                                印爪<span class="badge">{{ myGalleryData.pawNum }}</span>
                            </button>
                            <button type="button" class="btn" @click="addStar()" :class="{'btn-primary': haveStar}">
                                <font-awesome-icon :icon="faStar" />
                                收藏<span class="badge">{{ myGalleryData.starNum }}</span>
                            </button>
                            <button type="button" class="btn">
                                <font-awesome-icon :icon="faComment" />
                                评论<span class="badge">{{ myGalleryData.commentNum }}</span>
                            </button>
                        </div>
                    </div>
                    <!-- 评论区 -->
                    <div class="container">
                        <div class="container rounded p-3" v-if="haveLog">
                            <div class="row">
                                <div class="col-1 mt-1 p-1">
                                    <div class="squareBox">
                                        <img :src="userData.headImageUrl?userData.headImageUrl:g_vars['defaultHeadImage']" alt="headImage" width="100%">
                                    </div>
                                </div>
                                <div class="col-11">
                                    <form @submit.prevent="addComment()">
                                        <label for="comment">评论</label>
                                        <textarea class="form-control" rows="5" id="comment" name="text" placeholder="评论......" v-model="comment"></textarea>
                                        <div class="text-end"><button type="submit" class="btn justify-content-end">发送</button></div>
                                    </form>
                                </div>
                            </div>    
                        </div>
                        <div class="container rounded p-3">
                            <arr_galleryComment :galleryID="myGalleryID"></arr_galleryComment>
                        </div>
                    </div>
                </div>
                <!-- 上传者的更多画廊 -->
                <div class="col-sm-4 p-3 rounded">
                    <div class="card">
                        <div class="card-img-top">
                            <div class="backImageBox">
                                <img :src="myGalleryData.backImageUrl?myGalleryData.backImageUrl:g_vars['defaultBackImage']" alt="backImage" width="100%">
                            </div>
                        </div>
                        <div class="card-header">
                            <div style="display: flex;">
                                <div style="width: 20%;">
                                    <div class="squareBox">
                                        <a :href="'#/user?username='+myGalleryData.username">
                                            <img :src="myGalleryData.headImageUrl?myGalleryData.headImageUrl:g_vars['defaultHeadImage']" alt="headImage" width="10%">
                                        </a>
                                    </div>
                                </div>
                                <div style="width: 80%;">
                                    <a :href="'#/user?username='+myGalleryData.username">
                                        <span style="font-size: 1.2em; font-weight: bold;">
                                            {{ myGalleryData.sex==1?"雄":myGalleryData.sex==2?"雌":"" }}
                                            {{ myGalleryData.species }}
                                            <br>
                                            {{ myGalleryData.name }}
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ myGalleryData.userInfo }}
                        </div>
                        <div class="card-footer">
                            <div style="font-size: 1.2em; font-weight: light; color: cadetblue;">
                                {{ myGalleryData.sex==1?"雄":myGalleryData.sex==2?"雌":"" }}
                                {{ myGalleryData.species }}
                                {{ myGalleryData.name }}
                                的更多画廊
                            </div>
                            <div v-for="item in uploaderGallery">
                                <a @click="loadNext(item.galleryID)">
                                    <img :src="item.fileUrl?item.fileUrl:g_vars['image404']" alt="galleryImage" width="100%">
                                </a>
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
            haveLoad: true,
            haveLog: false,
            myGalleryID: {},
            myGalleryData: {},
            uploaderGallery: {},
            userData: {}, // 自己
            tags: "", // tags 要变化的标签        
            comment: "", // 要发的评论
            havePaw: false,
            haveStar: false,
        }},
        methods: {
            myPaint_gallery(theGalleryID){
                // 自有函数 载入绘制画廊页面
                // theGalleryID 要获取画廊的号码
                let sender = new Sender();
                let receiver = new Receiver();
                var outArr1;
                this.myGalleryID = theGalleryID;
                var obj1 = {action:3,todo:1,mode:4,galleryID:this.myGalleryID};
                // 获取画廊数据包
                sender.postSender(obj1)
                .then(res=>{
                    outArr1 = receiver.postReceiver(res);
                    this.myGalleryData = outArr1["mainData"][0];
                    // 获取上传者的更多画廊
                    let obj2 = {action:3,todo:1,mode:8,username:this.myGalleryData["username"]};
                    sender.postSender(obj2)
                    .then(res2=>{
                        let outArr2 = receiver.postReceiver(res2);
                        let loadNum = 3; // 画廊加载数
                        if(loadNum>outArr2["mainData"].length){loadNum=outArr2["mainData"].length;} //比loadNum少
                        for(let i=0;i<loadNum;i++){ 
                            this.uploaderGallery[i] = outArr2["mainData"][i];
                        }
                        this.isPaw();this.isStar();
                        this.haveLoad = false;this.$nextTick(()=>{this.haveLoad=true;})
                    })
                });
            },
            loadNext(theGalleryID){
                // 加载下一篇画廊
                router.push({name:'gallery',query:{galleryID:theGalleryID}});
                this.myPaint_gallery(theGalleryID);
            },
            addTags(){
                // 添加标签
                var sender = new Sender();
                var obj = {action:2,todo:3,tags:this.tags,galleryID:this.myGalleryID,mode:1};
                sender.postSender(obj)
                .then(()=>{this.tags="";window.location.reload();})
            },
            cancelTags(){
                // 撕下标签
                var sender = new Sender();
                var obj = {action:4,todo:2,tags:this.tags,galleryID:this.myGalleryID,mode:1};
                sender.postSender(obj)
                .then(()=>{this.tags="";window.location.reload();})
            },
            addComment(){
                // 添加评论
                var sender = new Sender();
                var obj = {action:2,todo:4,galleryID:this.myGalleryID,content:this.comment,mode:1};
                sender.postSender(obj)
                .then(()=>{this.comment="";window.location.reload();})
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
                if(mode==1){var outStr = year+"年"+month+"月"+date+"日"+" "+hour+":"+minute+":"+secend;}
                if(mode==2){var outStr = year+"年"+month+"月"+date+"日"}
                return outStr;
            },
            addPaw(){
                // 小兽印爪
                var sender = new Sender();
                var obj = {action:2,todo:5,galleryID:this.myGalleryID,mode:1};
                sender.postSender(obj)
                .then(()=>{window.location.reload();})
            },
            isPaw(theCommentID=null){
                // 判断小兽是否印爪
                var sender = new Sender();
                var obj = {action:5,todo:1,galleryID:this.myGalleryID,commentID:theCommentID,mode:1};
                sender.postSender(obj)
                .then((res)=>{
                    if(res==1){this.havePaw=true;}
                })
            },
            addStar(){
                // 小兽收藏
                var sender = new Sender();
                var obj = {action:2,todo:6,galleryID:this.myGalleryID,mode:1};
                sender.postSender(obj)
                .then(()=>{window.location.reload();})
            },
            isStar(){
                // 判断小兽是否收藏
                var sender = new Sender();
                var obj = {action:5,todo:2,galleryID:this.myGalleryID,mode:1};
                sender.postSender(obj)
                .then((res)=>{
                    if(res==1){this.haveStar=true;}
                })
            },
        },
        mounted(){
            var sender = new Sender();
            var receiver = new Receiver();
            // 是否登录
            var obj1 = {action:1,todo:5};
            sender.postSender(obj1)
            .then(res=>{
                if(res==1){this.haveLog=true;}
                receiver.doNumberAct(res);
            });
            // 获取自己的用户信息
            var outArr;
            var obj2 = {action:3,todo:3,mode:1,};
            // 此处用于调试 上线时注释掉
            // var obj2 = {action:3,todo:3,mode:2,username:10000};
            sender.postSender(obj2)
            .then(res=>{
                outArr = receiver.postReceiver(res);
                this.userData = outArr;
            });
            this.myPaint_gallery(this.$route.query.galleryID);
        },
        watch: {
            $route(to,from){
                if(this.$route.query.galleryID){
                    // 组件重新渲染
                    window.location.reload();
                }
            }
        },
    }
</script>

<style scoped>
</style>