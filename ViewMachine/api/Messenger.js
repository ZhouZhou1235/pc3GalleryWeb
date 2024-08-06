// 屏幕显示机 数据收发口
// 与后端的交互在这里完成

import axios from 'axios';
import router from '../router';
import { g_vars } from '../configure';
import { notify } from "@kyvg/vue3-notification";

var coreUrl = g_vars["coreUrl"];

export class Sender {
    // 发信员
    // 工作：把请求发给后端
    constructor(){}
    postSender(obj,mode=1){
        // POST方法发信员
        // mode 1普通发送 2携带文件发送
        // 信件格式obj例
        // obj: {action: 1,todo: 1,}
        // 返回Promise对象 收信员访问值 .then(res=>{});
        var header;
        var params = new FormData();
        for(var key in obj){params.append(key,obj[key])};
        // 操作表提示
        if(obj["action"]==1){
            notify({
                title: "PINKCANDY CORE 网站入口",
                text: "发送操作",
                duration: 1000,
            });    
        }
        if(obj["action"]==2){
            notify({
                type: "warn",
                title: "PINKCANDY CORE 添加",
                text: "发送添加请求",
                duration: 1000,
            });
        }
        if(obj["action"]==3){
            notify({
                title: "PINKCANDY CORE 展示主持",
                text: "正在请求粉糖粒子核心给出数据包",
                duration: 1000,
            });
        }
        if(obj["action"]==4){
            notify({
                type: "warn",
                title: "PINKCANDY CORE 修改",
                text: "发送修改请求",
                duration: 1000,
            });    
        }
        if(obj["action"]==5){
            notify({
                title: "PINKCANDY CORE 简单回复",
                text: "正在收听粉糖粒子核心的回复",
                duration: 1000,
            });    
        }
        return new Promise((resolve,reject)=>{
            if(mode==2){
                console.log("发信员 本次发信携带文件");
                header = {headers: {'Content-Type':'mutipart/form-data'}};
            }
            axios
            .post(coreUrl,params,header)
            .then(function(response){
                console.log("发信员 我把"+JSON.stringify(obj)+"发给流程处理机了");
                resolve(response.data);
            })
            .catch(function(error){console.log(error);reject(error.data)});
        })
        // 此写法也可
        //     var outArr;
        //     await axios
        //     ......
        //     return outArr;
    }
    getSender(){}
}

export class Receiver {
    // 收信员
    // 工作：接收结果给处理区
    doNumberAct(num){
        // 命令数字执行员
        if(num==0){
            notify({
                type: "error",
                title: "PINKCANDY CORE 0",
                text: "粉糖粒子核心报告错误",
                duration: 5000,
            });
            console.log("收信员 粉糖粒子核心报告错误");
            return 0;
        }
        if(num==1){
            notify({
                type: "success",
                title: "PINKCANDY CORE 1",
                text: "粉糖粒子核心完成了任务",
                duration: 5000,
            });
            console.log("收信员 粉糖粒子核心完成了任务");
            return 1;
        }
        if(num==2){
            notify({
                type: "success",
                title: "PINKCANDY CORE 2",
                text: "粉糖粒子核心完成任务并要求回到主页",
                duration: 5000,
            });
            console.log("收信员 粉糖粒子核心完成任务并要求我回到主页");
            router.push("/");
            return 2;
        }
        if(num==3){
            notify({
                type: "warn",
                title: "PINKCANDY CORE 3",
                text: "粉糖粒子核心没有完成我说的任务或者没有数据",
                duration: 5000,
            });
            console.log("收信员 粉糖粒子核心没有完成我说的任务或者没有数据");
            return 3;
        }
    }
    postReceiver(outArr){
        // POST方法收信员
        // outArr为 number 或 json
        if(typeof outArr=='number'){
            // outArr是数字
            console.log("收信员 流程处理机回应命令数字");
            let num = outArr;
            this.doNumberAct(num);
        }
        else{
            // outArr是数据包
            try{
                console.log("收信员 流程处理机回应数据包，下面是内容......");
                console.log(outArr);
                var number = outArr["number"];
                this.doNumberAct(number);
                return outArr;
            }
            catch(e){
                notify({
                    type: "error",
                    title: "PINKCANDY UNKNOWN ERROR",
                    text: "不能理解流程处理机的回应",
                    duration: 5000,
                });
                console.log("收信员 我不能理解流程处理机的回应");
                console.log(outArr);
                console.log(e);
                return 0;
            }
        }
    }
    getReceiver(){}
}