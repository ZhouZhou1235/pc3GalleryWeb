<!-- 页面 入口 -->

<script setup>
import { faBuildingShield, faEnvelope, faFileSignature, faHouseMedical, faKey, faQuestion, faRightToBracket, faShieldDog } from '@fortawesome/free-solid-svg-icons';
import { Receiver,Sender } from '../api/Messenger';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
</script>

<template>
    <!-- 入口 -->
    <div class="container-sm p-3">
        <div class="card">
            <div class="row">
                <div class="col-md-4">
                    <img src="/ViewMachine/assets/Images/wolf.png" class="img-fluid rounded-start" alt="">
                </div>
                <div class="col-md-8">
                    <div class="container-sm p-3">
                        <div v-if="haveLog">
                            <div class="container text-center">
                                <h4>已登录，在小兽空间注销。</h4>
                            </div>
                        </div>
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                        <font-awesome-icon :icon="faRightToBracket" />
                                        登录粉糖粒子
                                    </a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <form @submit.prevent="login()">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faShieldDog" />
                                                    账号
                                                </span>
                                                <input type="text" class="form-control" placeholder="输入粉糖账号或邮箱" name="username" v-model="formLogin.username">    
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faKey" />
                                                    密码
                                                </span>
                                                <input type="password" class="form-control" placeholder="输入密码" name="pendPassword" v-model="formLogin.pendPassword">
                                                <button class="btn btn-outline-secondary" type="submit" :class="{'disabled': haveLog}">登录</button>
                                            </div>
                                        </form>
                                        <h3>登录例</h3>
                                        <p>
                                            粉糖粒子是五位数字<br>
                                            密码是5-20长度的字母数字<br>
                                            例如<br>
                                            粉糖账号 10000<br>
                                            密码 123456<br>
                                            如果忘记粉糖账号 可以用绑定的邮箱替代<br>
                                            粉糖账号 pinkcandyzhou@qq.com<br>
                                            密码 123456<br>
                                            忘记密码请点重置<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                                        <font-awesome-icon :icon="faHouseMedical" />
                                        注册粉糖账号
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <form @submit.prevent="register()">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faShieldDog" />
                                                    粉糖账号
                                                </span>
                                                <input type="text" class="form-control" placeholder="创建一个五位数字粉糖账号 粉糖账号不可更改" v-model="formRegister.username">  
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faEnvelope" />
                                                    登记邮箱
                                                </span>
                                                <input type="text" class="form-control" placeholder="粉糖账号需要与一个有效邮箱对应" v-model="formRegister.email">  
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faKey" />
                                                    设置密码
                                                </span>
                                                <input type="text" class="form-control" placeholder="设置粉糖账号密码用于验证身份" v-model="formRegister.pendPassword">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faFileSignature" />
                                                    起个名称
                                                </span>
                                                <input type="text" class="form-control" placeholder="其他小兽怎么称呼您？" v-model="formRegister.name">
                                                <button class="btn btn-outline-secondary" :class="{'disabled': haveLog}">注册</button>
                                            </div>
                                        </form>
                                        <h3>注册说明</h3>
                                        <p>
                                            欢迎加入粉糖粒子<br>
                                            创建一个五位数字粉糖账号 粉糖账号不可更改<br>
                                            密码只能是5-20的字母数字<br>
                                            粉糖账号需要与一个有效邮箱对应。确保邮箱正确可用，因为这是唯一可找回账号密码的途径。<br>
                                            设置粉糖账号密码用于验证身份<br>
                                            名称、头像、背景墙等内容稍后可以到小兽空间设置。<br>
                                            若发现邮箱被占用，请联系总管理兽修改。<br>
                                            开发者邮箱 pinkcandyzhou@qq.com<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseThree">
                                        <font-awesome-icon :icon="faQuestion" />
                                        忘记密码
                                    </a>
                                </div>
                                <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
                                    <div class="card-body">
                                        <form @submit.prevent="resetPassword()">
                                            <p>先</p>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faEnvelope" />
                                                    邮箱
                                                </span>
                                                <input type="text" class="form-control" placeholder="输入粉糖账号对应的邮箱获取验证码" v-model="formGetCode.email">
                                                <span class="btn btn-outline-secondary" :class="{'disabled': buttonClick1||haveLog}" @click="getCode">获取</span>
                                            </div>
                                            <p>后</p>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faKey" />
                                                    重置密码
                                                </span>
                                                <input type="text" class="form-control" placeholder="重置粉糖账号的密码" v-model="formResetPassword.pendPassword">
                                            </div>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <font-awesome-icon :icon="faBuildingShield" />
                                                    验证码
                                                </span>
                                                <input type="text" class="form-control" placeholder="输入验证码" v-model="formResetPassword.code">
                                                <button class="btn btn-outline-secondary" :class="{'disabled': haveLog}">重置</button>
                                            </div>
                                        </form>
                                        <h3>重置密码</h3>
                                        <p>
                                            先输入绑定的邮箱获取验证码<br>
                                            然后重新设置一个新密码<br>
                                            不要再忘记粉糖账号和密码啦！<br>
                                        </p>
                                    </div>
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
            haveLog: false,
            buttonClick1: false,
            formLogin: {
                action: 1,
                todo: 1,
                username: "",
                pendPassword: "",
            },
            formRegister: {
                action: 1,
                todo: 2,
                username: "",
                email: "",
                pendPassword: "",
                name: "",
            },
            formGetCode: {
                action: 1,
                todo: 3,
                email: "",
            },
            formResetPassword: {
                action: 1,
                todo: 4,
                pendPassword: "",
                code: "",
            },
        };},
        methods: {
            login(){
                // 登录动作
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(this.formLogin)
                .then(res=>{
                    receiver.postReceiver(res);
                });
            },
            register(){
                // 注册动作
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(this.formRegister)
                .then(res=>{
                    receiver.postReceiver(res);
                });
            },
            getCode(){
                // 获取重置验证码
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(this.formGetCode)
                .then(res=>{
                    receiver.postReceiver(res);
                });
                this.buttonClick1 = true;
            },
            resetPassword(){
                // 重置密码动作
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(this.formResetPassword)
                .then(res=>{
                    receiver.postReceiver(res);
                });
            }
        },
        mounted(){
            { // 是否登录
                var obj = {action:1,todo:5};
                let sender = new Sender();
                let receiver = new Receiver();
                sender.postSender(obj)
                .then(res=>{
                    if(res==1){this.haveLog=true;}
                    receiver.doNumberAct(res);
                });
            }
        },
    }
</script>

<style scoped>
</style>