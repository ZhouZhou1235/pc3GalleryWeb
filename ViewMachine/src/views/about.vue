<!-- 大门 -->

<script setup>
    import { Messager } from '@/api/ConnectCore';
    import { GlobelArea } from '@/stores/PiniaBox';
    const GArea = GlobelArea();
</script>

<template>
    <!-- 关于 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div style="font-size: 6em; color: pink;" class="container">3.1.0</div>
                <div style="font-size: 3em; color: skyblue;" class="container">版本大更新</div>
                <p>
                    1 网站前端完全重写
                    2 重新设计了一套UI
                    3 标签系统添加分类 搜索预览优化
                    4 交互体验升级
                    <br>
                    站长周周 2024.9.22
                </p>
                <p>
                    白白的QQbot机叶会从此处收集画廊图片哦👀
                </p>
                <h1>幻想动物画廊</h1>
                <p>
                    嘿！在互联网中发现了一座中文毛绒绒城堡？！
                    欢迎来到幻想动物画廊。
                    本网站系统由粉糖粒子周周独立编写完成，
                    无任何广告或商业活动，为非盈利兴趣站点。
                    因为周想和伙伴们一同分享毛绒绒艺术作品，
                    再加上周学习的专业是网络工程，建站一定是必做项目。
                    让我们堆积更多的毛绒绒吧！
                    <br>
                    始于 2023.10.1
                </p>
                <h2>粉糖粒子规则</h2>
                <p>
                    1 遵守我国的基本法律和道德规范<br>
                    2 不要发送18+、恐怖、猎奇、政治相关等敏感信息<br>
                    3 不要网络攻击其他小兽<br>
                    4 不要一次性发送太多或无意义内容<br>
                    5 不要添加错误的标签<br>
                    6 由于是幻想动物主题网站，所以不要发布与毛绒绒无关的图像。<br>
                    免责声明：<br>
                    幻想动物画廊提供的任何信息及产生的效应由其发布者负责，本网站不提供任何保证也不承担任何法律责任。<br>
                </p>
                <h2>什么是毛绒绒？</h2>
                <p>
                    毛绒绒是指由各种除人类以外的动物为主要原型创作出来的角色形象。
                    喜爱毛绒绒的群体称为兽控，兽迷，“福瑞控”等。
                    毛绒绒的兽化程度可以细分为以下等级：<br>
                    - 人类<br>
                    1 仅有耳朵和尾巴作为装饰<br>
                    2 更浓密的动物毛发<br>
                    3 通常的兽人<br>
                    4 以动物骨骼为基础<br>
                    5 有思想的动物<br>
                    - 动物<br>
                </p>
                <h2>用到的计算机技术</h2>
                <p>
                    HTML+CSS+JavaScript 网站前端基础<br>
                    Vue.js 前端JavaScript构建框架<br>
                    Axios JS异步通信模块<br>
                    Bootstrap 用户界面库<br>
                    element-ui vue用户界面库<br>
                    PINKCANDY-CORE PHP编写的幻想动物画廊网站系统<br>
                    MySQL 表结构关系型数据库<br>
                    Linux Ubuntu 服务器操作系统<br>
                    Apache Web服务器<br>
                    2024.9<br>
                </p>
                <h2>赞助粉糖粒子</h2>
                <p>
                    感谢！
                    赞助不会获得任何特权或者效果，
                    无论是赞助还是使用画廊都是对周周很好的支持！
                    <img :src="GArea.staticFiles.donate" alt="donate" width="50%">
                </p>
                <small>
                    工作邮箱 pinkcandyzhou@qq.com<br>
                    版权所有 粉糖粒子周周 保留所有权利<br>
                    Copyright © PinkCandyZhou. All rights reserved.<br> 
                </small>
            </div>
            <div class="col-sm-4">
                <h3>粉糖粒子留言板</h3>
                <ul class="list-group">
                    <li class="list-group-item" v-for="i in showBoardData">
                        <a :href="'/'">{{ i.name }}</a>
                        <p>{{ i.content }}<br>{{ i.time }}</p>
                    </li>
                </ul>
                <div class="d-grid" v-if="!allDone">
                    <button type="button" class="btn btn-outline-secondary" @click="loadMore()">
                        加载更多
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){return{
            boardData: {},
            showBoardData: {},

            loadNum: 0,
            allDone: false,
        }},
        methods: {
            loadMore(){
                // 加载更多留言
                if(this.boardData==undefined){this.allDone=true;return;}
                let i = this.loadNum;
                this.loadNum += 10;
                if(this.loadNum>this.boardData.length){
                    this.loadNum=this.boardData.length;
                    this.allDone = true;
                }
                for(i;i<this.loadNum;i++){
                    this.showBoardData[i] = this.boardData[i];
                }
            },
        },
        mounted(){
            Messager.getBoardData().then(res=>{
                if(typeof res!='number'){
                    this.boardData = res;
                    this.loadMore();
                }
            })
        },
    }
</script>

<style scoped>
</style>