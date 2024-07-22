// 屏幕显示机 数据收发口
// 与后端的交互在这里完成

import axios from 'axios'
import router from '../router'

var coreUrl = "/core/ProcessMachine.php";

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
        return new Promise((resolve,reject)=>{
            if(mode==2){
                header = {headers: {'Content-Type':'mutipart/form-data'}};
            }
            axios
            .post(coreUrl,params,header)
            .then(function(response){resolve(response.data);})
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
            console.log("pinkcandy core error");
            return 0;
        }
        if(num==1){
            console.log("pinkcandy done");
            return 1;
        }
        if(num==2){
            console.log("pinkcandy done back home");
            router.push("/");
            return 2;
        }
        if(num==3){
            console.log("pinkcandy done but not success");
            return 3;
        }
    }
    postReceiver(outArr){
        // POST方法收信员
        // outArr为 number 或 json
        if(typeof outArr=='number'){
            // outArr是数字
            let num = outArr;
            return this.doNumberAct(num);
        }
        else{
            // outArr是数据包
            try{
                // 数据包处理逻辑
            }
            catch(e){
                console.log("pinkcandy databack error");
                console.log(outArr);
                console.log(e);
                return 0;
            }
        }
    }
    getReceiver(){}
}