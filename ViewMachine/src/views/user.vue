<!-- 小兽空间 -->

<script setup>
    import { addFileToForm, Messager, showNotice } from '@/api/ConnectCore';
    import router from '@/router';
    import card_gallery from '@/components/card_gallery.vue';
    import card_plantPot from '@/components/card_plantPot.vue';
    import { GlobelArea } from '@/stores/PiniaBox';
    import { ElTooltip } from 'element-plus';
    const GArea = GlobelArea();
</script>

<template>
    <div v-if="GArea.furryUser.isLog || username!=null">
        <!-- 背景墙 -->
        <div class="container-fluid">
            <div style="min-height: 12em; max-height: 24em; overflow-y: scroll;">
                <img :src="userData.backImageUrl!=null?userData.backImageUrl:GArea.staticFiles.defaultBack"
                alt="backImage" width="100%">
            </div>
        </div>
        <!-- 操作 -->
        <div class="container" v-if="showControl">
            <div class="btn-group">
                <button class="btn btn-info" @click="showTheZone()">小兽空间</button>
                <RouterLink to="/user/control">
                    <button class="btn" @click="hideTheZone()">管理</button>
                </RouterLink>
                <RouterLink to="/user/message">
                    <button class="btn" @click="hideTheZone()">消息</button>
                </RouterLink>
                <RouterLink to="/user/star">
                    <button class="btn" @click="hideTheZone()">收藏</button>
                </RouterLink>
                <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal">修改资料</button>
                <button class="btn btn-warning" @click="logout()">注销</button>
            </div>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-xl">
                    <form action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">修改资料</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="container-sm text-center">
                                            <div class="squareBox">
                                                <img :src="GArea.furryUser.headImage!=null?GArea.furryUser.headImage:GArea.staticFiles.defaultHead"
                                                alt="headImage" width="100%" id="showImage">
                                            </div>
                                            <h4>{{ changeUserForm.name }}</h4>
                                            <p>粉糖账号{{ GArea.furryUser.username }}</p>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">邮箱</span>
                                            <input type="text" class="form-control" v-model="changeUserForm.email">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">密码</span>
                                            <input type="text" class="form-control" v-model="changeUserForm.pendPassword" placeholder="新密码 留空表示不修改">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-text">头像</span>
                                            <input type="file" class="form-control" @change="addHeadImageToForm($event)" id="theImageFile">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">背景墙</span>
                                            <input type="file" class="form-control" @change="addBackImageToForm($event)">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">名称</span>
                                            <input type="text" class="form-control" v-model="changeUserForm.name">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">介绍</span>
                                            <textarea name="" id="" class="form-control" rows="5" v-model="changeUserForm.info"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-select" aria-label="Default select example" v-model="changeUserForm.sex">
                                                    <option selected>性别</option>
                                                    <option value="1">雄</option>
                                                    <option value="2">雌</option>
                                                    <option value="3">无</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <span class="input-group-text">兽种</span>
                                                    <input type="text" class="form-control" v-model="changeUserForm.species">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-sm border border-warning rounded border-3">
                                            <p>
                                                不要随意改变邮箱和密码，您需要确保：<br>
                                                1 邮箱可用，用于找回账号。<br>
                                                2 记住密码<br>
                                                粉糖粒子允许上传自由宽高比的背景墙图像，
                                                但建议上传形状扁平的背景墙。<br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn" data-bs-dismiss="modal"
                                @click="changeUserData()">修改</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div v-if="!showZone">
            <RouterView></RouterView>
        </div>
        <!-- 空间 -->
        <div class="container" v-show="showZone">
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-3">
                            <img :src="userData.headImageUrl!=null?userData.headImageUrl:GArea.staticFiles.defaultHead"
                            alt="headImage" width="100%">
                        </div>
                        <div class="col-9">
                            <h1>{{ userData.name }}</h1>
                            <div style="font-size: 1.2em; font-weight: bold;">
                                {{ userData.sex==1?"雄":userData.sex==2?"雌":"" }}
                                {{ userData.species }}
                                关注{{ userData.myWatchNum }}
                                粉丝{{ userData.watcherNum }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-grid" v-if="showWatchButton && GArea.furryUser.isLog">
                            <button class="btn" :class="{'btn-primary':userData.isFollow}"
                            @click="followUser(userData.username)">
                                关注
                            </button>
                        </div>
                        <div class="col">
                            <div style="font-size: 1.4em;">
                                <span v-for="item in userData.badges">
                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        :content="'<h2>'+item.info+'</h2>'"
                                        placement="top"
                                        raw-content
                                    >
                                        <span class="badge rounded-pill text-bg-info">
                                            {{ item.title }}
                                        </span>
                                    </el-tooltip>
                                </span>
                            </div>
                            <p style="white-space: pre-line;">
                                {{ userData.info }}
                            </p>
                            <div style="color: pink;">粉糖账号{{ userData.username }}</div>
                            <div style="color: pink;">{{ userData.joinTime }}加入粉糖</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h2>粉丝</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="item in showWatchersData">
                                    <RouterLink :to="'/user?username='+item.watcherUsername">
                                        <img :src="item.watcherHeadImageUrl!=null?item.watcherHeadImageUrl:GArea.staticFiles.defaultHead"
                                        alt="headImage" width="10%">
                                        {{ item.watcherSex==1?"雄":item.watcherSex==2?"雌":"" }}
                                        {{ item.watcherSpecies }}
                                        {{ item.watcherName }}
                                    </RouterLink>
                                </li>
                            </ul>
                            <div class="d-grid" v-if="!allDone1">
                                <button class="btn btn-outline-secondary"
                                @click="loadMoreWatcher()">加载更多</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h2>关注</h2>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" v-for="item in showMyWatchsData">
                                    <RouterLink :to="'/user?username='+item.myWatchUsername">
                                        <img :src="item.myWatchHeadImageUrl!=null?item.myWatchHeadImageUrl:GArea.staticFiles.defaultHead"
                                        alt="headImage" width="10%">
                                        {{ item.myWatchSex==1?"雄":item.myWatchSex==2?"雌":"" }}
                                        {{ item.myWatchSpecies }}
                                        {{ item.myWatchName }}
                                    </RouterLink>
                                </li>
                            </ul>
                            <div class="d-grid" v-if="!allDone2">
                                <button class="btn btn-outline-secondary"
                                @click="loadMoreMyWatchs()">加载更多</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="container">
                        <h2>幻想动物画廊</h2>
                        <div class="row">
                            <div v-for="item in showGallerysData" class="col-sm-4 mt-2">
                                <card_gallery :theData="item"></card_gallery>
                            </div>
                        </div>
                        <div class="d-grid" v-if="!allDone3">
                            <button type="button" class="btn btn-outline-secondary"
                            @click="loadMoreGallery()">
                                加载更多
                            </button>
                        </div>
                    </div>
                    <div class="container">
                        <h2>花园盆栽</h2>
                        <div class="row">
                            <div v-for="item in showPostsData" class="col-sm-4 mt-2">
                                <card_plantPot :theData="item"></card_plantPot>
                            </div>
                        </div>
                        <div class="d-grid" v-if="!allDone4">
                            <button type="button" class="btn btn-outline-secondary"
                            @click="loadMorePost()">
                                加载更多
                            </button>
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
            username: null,
            userData: {},
            gallerysData: {},
            postsData: {},
            showWatchersData: {},
            showMyWatchsData: {},
            showGallerysData: {},
            showPostsData: {},

            showZone: true,
            showControl: false,
            showWatchButton: true,
            loadNum1: 0,
            loadNum2: 0,
            loadNum3: 0,
            loadNum4: 0,
            allDone1: false,
            allDone2: false,
            allDone3: false,
            allDone4: false,

            changeUserForm: {
                username: "",
                email: "",
                pendPassword: "",
                name: "",
                sex: "",
                species: "",
                info: "",
                headImage: null,
                backImage: null,
            },
        }},
        methods: {
            followUser(a){
                // 关注小兽
                Messager.followUser(a);
                if(this.userData.isFollow==true){this.userData.isFollow=false;}
                else{this.userData.isFollow=true;}
            },
            hideTheZone(){this.showZone=false},
            showTheZone(){this.showZone=true;},
            loadMoreWatcher(){
                // 加载更多粉丝
                if(this.userData.watchers==undefined){this.allDone1=true;return;}
                let i = this.loadNum1;
                this.loadNum1 += 5;
                if(this.loadNum1>this.userData.watchers.length){
                    this.loadNum1 = this.userData.watchers.length;
                    this.allDone1 = true;
                }
                for(i;i<this.loadNum1;i++){
                    this.showWatchersData[i] = this.userData.watchers[i];
                }
            },
            loadMoreMyWatchs(){
                // 加载更多关注
                if(this.userData.myWatchs==undefined){this.allDone2=true;return;}
                let i = this.loadNum2;
                this.loadNum2 += 5;
                if(this.loadNum2>this.userData.myWatchs.length){
                    this.loadNum2 = this.userData.myWatchs.length;
                    this.allDone2 = true;
                }
                for(i;i<this.loadNum2;i++){
                    this.showMyWatchsData[i] = this.userData.myWatchs[i];
                }
            },
            loadMoreGallery(){
                // 加载更多画廊
                if(this.gallerysData==undefined){this.allDone3=true;return;}
                let i = this.loadNum3;
                this.loadNum3 += 6;
                if(this.loadNum3>this.gallerysData.length){
                    this.loadNum3 = this.gallerysData.length;
                    this.allDone3 = true;
                }
                for(i;i<this.loadNum3;i++){
                    this.showGallerysData[i] = this.gallerysData[i];
                }
            },
            loadMorePost(){
                // 加载更多盆栽
                if(this.postsData==undefined){this.allDone4=true;return;}
                let i = this.loadNum4;
                this.loadNum4 += 3;
                if(this.loadNum4>this.postsData.length){
                    this.loadNum4 = this.postsData.length;
                    this.allDone4 = true;
                }
                for(i;i<this.loadNum4;i++){
                    this.showPostsData[i] = this.postsData[i];
                }
            },
            logout(){
                // 注销
                const GArea = GlobelArea();
                Messager.requestLogout();
                GArea.$reset();
                router.push('/');
            },
            getAndShowUser(){
                //获取并显示小兽空间
                // 以下情况才能渲染页面
                // 1 无username且已登录 显示自己 
                // 2 有username 显示指定的username主页
                //重置data
                this.showWatchersData = {};
                this.showMyWatchsData = {};
                this.showGallerysData = {};
                this.showPostsData = {};
                this.loadNum1=0,this.loadNum2=0,this.loadNum3=0,this.loadNum4=0;
                this.allDone1=false,this.allDone2=false,this.allDone3=false,this.allDone4=false;
                const GArea = GlobelArea();
                if(GArea.furryUser.isLog==false && this.username==null){
                    // 用户刷新页面时状态GArea被重置 判定未登录进入此逻辑
                    // 询问是否登录 若是则重新调用此函数
                    Messager.checkLogin().then(res=>{if(res==1){this.getAndShowUser();}});
                    return;
                }
                if(this.username!=null){
                    // 显示指定粉糖账号主页
                    this.showControl = false;
                    this.showWatchButton = true;
                    Messager.getUserData(this.username).then(res=>{
                        this.userData=res;
                        document.title = "小兽空间 - "+this.userData.name;
                        this.loadMoreWatcher();
                        this.loadMoreMyWatchs();
                    });
                    Messager.getGallerysData(3,this.username).then(res=>{
                        this.gallerysData = res.mainData;
                        this.loadMoreGallery();
                    });
                    Messager.getPostsData(3,this.username).then(res=>{
                        this.postsData = res.mainData;
                        this.loadMorePost();
                    });
                }
                else{
                    // 显示自己
                    this.showControl = true;
                    this.showWatchButton = false;
                    if(GArea.furryUser.isLog){
                        Messager.getUserData().then(res=>{
                            this.userData=res;
                            document.title = "小兽空间 - "+this.userData.name;
                            this.loadMoreWatcher();
                            this.loadMoreMyWatchs();
                            this.changeUserForm.username = this.userData.username,
                            this.changeUserForm.email = this.userData.email,
                            this.changeUserForm.name = this.userData.name,
                            this.changeUserForm.sex = this.userData.sex,
                            this.changeUserForm.species = this.userData.species,
                            this.changeUserForm.info = this.userData.info;
                        });
                        Messager.getGallerysData(4).then(res=>{
                            this.gallerysData = res.mainData;
                            this.loadMoreGallery();
                        });
                        Messager.getPostsData(2).then(res=>{
                            this.postsData = res.mainData;
                            this.loadMorePost();
                        });
                    }
                }
            },
            addHeadImageToForm(event){
                // 将头像装入表单
                this.changeUserForm = addFileToForm(this.changeUserForm,event,"headImage");
                this.showImg();
            },
            addBackImageToForm(event){
                // 将背景墙装入表单
                this.changeUserForm = addFileToForm(this.changeUserForm,event,"backImage");
            },
            changeUserData(){
                // 修改小兽信息
                Messager.requestChangeUser(this.changeUserForm).then(res=>{
                    if(res==1){router.push('/user');showNotice(12);}
                    else{showNotice(11);}
                    this.getAndShowUser();
                });
            },
            showImg(){
                // 显示要上传的图片
                let reads = new FileReader();
                let file = document.getElementById("theImageFile").files[0];
                reads.readAsDataURL(file);
                reads.onload=function(e){document.getElementById("showImage").src=this.result;}
            },
        },
        mounted(){
            this.username = this.$route.query.username;
            this.getAndShowUser();
        },
        watch: {
            $route(to,from){
                this.username = this.$route.query.username;
                if(this.$route.query.username){this.showTheZone();}
                this.getAndShowUser();
            }
        },
    }
</script>

<style scoped>
</style>