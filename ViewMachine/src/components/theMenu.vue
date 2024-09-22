<!-- 组件 导航栏 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    import Search from './search.vue';
    import TagBox from './tagBox.vue';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 导航 -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <RouterLink to="/" class="navbar-brand">
                <img :src="GArea.staticFiles['webLogo']" alt="webLogo" height="50">
            </RouterLink>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#websiteMenu"
                aria-controls="#websiteMenu"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="websiteMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <RouterLink to="/about">
                            <button class="btn btn-outline-secondary">
                                大门
                            </button>
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <RouterLink to="/garden">
                            <button class="btn btn-outline-secondary">
                                花园
                            </button>
                        </RouterLink>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#searchModal">
                            &nbsp;&nbsp;&nbsp;&nbsp;搜索&nbsp;&nbsp;&nbsp;&nbsp;
                        </button>
                        <div class="modal fade" id="searchModal">
                            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">搜索粉糖</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" v-model="tags"
                                            @keyup="showSearchPreview()">
                                            <button class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                            @click="doSearch()">搜索</button>
                                        </div>
                                        <div class="container">
                                            <div>最新标签</div>
                                            <span v-for="item in latestTagData">
                                                <span v-if="item[1]==1">
                                                    <span class="badge text-bg-secondary"
                                                    @click="putTagText(item[0])">{{ item[0] }}</span>
                                                </span>
                                                <span v-else-if="item[1]==2">
                                                    <span class="badge text-bg-warning"
                                                    @click="putTagText(item[0])">{{ item[0] }}</span>
                                                </span>
                                                <span v-else-if="item[1]==3">
                                                    <span class="badge text-bg-info"
                                                    @click="putTagText(item[0])">{{ item[0] }}</span>
                                                </span>
                                                <span v-else-if="item[1]==4"
                                                @click="putTagText(item[0])">
                                                    <span class="badge text-bg-success">{{ item[0] }}</span>
                                                </span>
                                                <span v-else-if="item[1]==5"
                                                @click="putTagText(item[0])">
                                                    <span class="badge text-bg-danger">{{ item[0] }}</span>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="container">
                                            <TagBox :theData="showTagsData" :key="tagBoxKey"></TagBox>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <span class="justify-content-end">
                    <RouterLink to="/add">
                        <span v-if="GArea.furryUser.isLog">
                            <button class="btn btn-outline-secondary">
                                &nbsp;&nbsp;&nbsp;&nbsp;添加&nbsp;&nbsp;&nbsp;&nbsp;
                            </button>
                        </span>
                    </RouterLink>
                    <RouterLink to="/user">
                        <img :src="showMenuHeadImage()" alt="headImage" width="50" height="50">
                    </RouterLink>
                </span>
            </div>
        </div>
    </nav>
    <!-- 网站入口 -->
    <div class="container-fluid" v-if="!GArea.furryUser.isLog">
        <RouterLink to="/enter">
            <div class="d-grid">
                <button type="button" class="btn btn-warning">
                    登录后才能使用功能
                </button>
            </div>
        </RouterLink>
    </div>
    <!-- 搜索粉糖 -->
    <Search v-if="searchShow" :theTags="tags" :key="searchKey"></Search>
</template>

<script>
    export default {
        data(){return{
            tagsData: {},
            showTagsData: {},
            latestTagData: {},
            tags: "",
            tagBoxKey: 0,
            searchKey: 0,
            searchShow: false,
        }},
        methods: {
            showMenuHeadImage(){
                // 显示导航栏的头像
                let myArea = GlobelArea();
                if(myArea.furryUser.isLog){
                    if(myArea.furryUser.headImage==null){
                        return myArea.staticFiles.defaultHead;
                    }
                    return myArea.furryUser.headImage;
                }
                return myArea.staticFiles.defaultHead;
            },
            loadLatestTag(){
                // 加载最新标签
                let num = 10;
                for(let i=0;i<num;i++){
                    this.latestTagData[i] = this.tagsData[i];
                }
            },
            showSearchPreview(){
                // 检索 显示搜索预览
                if(this.tags!=""){
                    let tagsArray = this.tags.split(" ");
                    for(let i=0;i<tagsArray.length;i++){
                        let tag = tagsArray[i];
                        if(tag=="" || tag==" " || tag==null){continue;}
                        for(let i=0;i<this.tagsData.length;i++){
                            if(this.tagsData[i][0].includes(tag)){this.showTagsData[i]=this.tagsData[i];}
                        }
                    }
                }
                else{this.showTagsData={}}
                this.tagBoxKey++;
            },
            getTagsData(){
                // 获取标签数据
                Messager.getTagsData(2).then(res=>{
                    if(res!=undefined){
                        this.tagsData = res;
                        this.tagBoxKey += 1;
                        this.loadLatestTag();
                    }
                });
            },
            putTagText(tag){
                // 加标签到输入框
                if(this.tags==""){this.tags=tag}
                else{this.tags += " "+tag;}
                this.showSearchPreview();
            },
            doSearch(){
                // 执行搜索
                this.searchKey++;
                this.searchShow = true;
            },
        },
        mounted(){
            const GArea = GlobelArea();
            GArea.getAndSetUserState();
            this.getTagsData();
        },
    }
</script>

<style scoped>
</style>