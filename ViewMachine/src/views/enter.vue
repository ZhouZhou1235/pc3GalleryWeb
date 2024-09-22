<!-- 网站入口 -->

<script setup>
    import { Messager, showNotice } from '@/api/ConnectCore';
    import router from '@/router';
    import { GlobelArea } from '@/stores/PiniaBox';
    
    const GArea = GlobelArea();
</script>

<template>
    <div class="container">
        <div class="row border border-secondary border-3 rounded">
            <div class="col-sm-4">
                <img :src="GArea.staticFiles.impression" class="img-fluid rounded-start" alt="begin">
            </div>
            <div class="col-sm-8">
                <div id="accordion">
                    <div class="row">
                        <div class="cow">
                            <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                登录
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                            <div class="container">
                                <div class="input-group">
                                    <span class="input-group-text">账号</span>
                                    <input type="text" class="form-control" placeholder="输入粉糖账号或邮箱" v-model="username">    
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">密码</span>
                                    <input type="password" class="form-control" placeholder="输入密码" v-model="pendPassword">
                                    <button class="btn btn-outline-secondary" @click="login()">登录</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                                注册
                            </a>
                        </div>
                        <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                            <div class="container">
                                <div class="input-group">
                                    <span class="input-group-text">粉糖账号</span>
                                    <input type="text" class="form-control" placeholder="创建五位数字粉糖账号" v-model="newUsername">  
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">登记邮箱</span>
                                    <input type="text" class="form-control" placeholder="粉糖账号需要绑定一个有效邮箱" v-model="newEmail">  
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">设置密码</span>
                                    <input type="password" class="form-control" placeholder="设置粉糖账号密码用于验证身份" v-model="newPendPassword">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">起个名称</span>
                                    <input type="text" class="form-control" placeholder="其他小兽怎么称呼您？" v-model="newName">
                                    <button class="btn btn-outline-secondary" @click="register()">注册</button>
                                </div>
                            </div>
                            <div class="border border-3 border-warning rounded">
                                粉糖账号是<span style="color: red;">五位数字</span>，注册成功后不能修改。<br>
                                粉糖账号<span style="color: red;">必须</span>与一个有效邮箱绑定，用于通知和重置密码。<br>
                                密码必须是<span style="color: red;">5-20位字母及数字</span>的集合<br>
                                名称即该粉糖账号的昵称，任意~ 但<span style="color: red;">不能不输入</span>，小兽不能没有名字。<br>
                                <span style="font-weight: bold;">填正确后仍然注册失败？</span><br>
                                1 粉糖账号或者邮箱可能已被使用，如果认为邮箱被占用请联系总管理兽（周周）修改。<br>
                                2 可能被网站系统监察控制机阻止，不要输入非法字符。<br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseThree">
                                忘记密码
                            </a>
                        </div>
                        <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
                            <div class="container">
                                <div class="input-group">
                                    <span class="input-group-text">邮箱</span>
                                    <input type="text" class="form-control" placeholder="输入粉糖账号绑定的邮箱获取验证码" v-model="theEmail">
                                    <button class="btn btn-outline-secondary" :class="{'disabled':button1Clicked}"
                                    @click="getACode()">获取</button>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">重置密码</span>
                                    <input type="password" class="form-control" placeholder="此粉糖账号的新密码" v-model="theNewPendPassword">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">验证码</span>
                                    <input type="text" class="form-control" placeholder="输入验证码" v-model="theResetCode">
                                    <button class="btn btn-outline-secondary"
                                    @click="resetPassword()">重置</button>
                                </div>
                            </div>
                            <div class="border border-3 border-warning rounded">
                                每次进入只能获取一次<br>
                                先输入绑定的邮箱再点击按钮获取验证码以证明小兽身份<br>
                                输入验证码以及重新设置一个新密码<br>
                                不要再忘记啦！<br>
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
            username: "",
            pendPassword: "",

            newUsername: "",
            newPendPassword: "",
            newEmail: "",
            newName: "",

            theEmail: "",
            theNewPendPassword: "",
            theResetCode: "",

            button1Clicked: false, // 获取验证码只能按一次
        }},
        methods: {
            login(){
                // 登录
                Messager.requestLogin(this.username,this.pendPassword).then(res=>{
                    if(res==0){showNotice(1);return;}
                    if(res==2){
                        const GArea = GlobelArea();
                        GArea.getAndSetUserState().then(router.push('/'));
                        showNotice(6);
                    }
                });
            },
            register(){
                // 注册
                Messager.requestRegister(
                    this.newUsername,
                    this.newEmail,
                    this.newPendPassword,
                    this.newName
                ).then(res=>{
                    if(res==0){showNotice(2);return;}
                    if(res==2){router.push('/');}
                });
            },
            getACode(){
                // 获取重置验证码
                if(this.theEmail==""){showNotice(3);return;}
                else{
                    Messager.requestResetCode(this.theEmail);
                    this.button1Clicked = true;
                    showNotice(4);
                }
            },
            resetPassword(){
                // 重置密码
                Messager.requestResetPassword(this.theNewPendPassword,this.theResetCode).then(res=>{
                    if(res==0){showNotice(5);return;}
                    if(res==2){router.push('/');}
                });
            },
        },
        mounted(){
            
        },
    }
</script>

<style scoped>
</style>