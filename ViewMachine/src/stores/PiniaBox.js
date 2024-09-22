// PiniaBox vue状态管理

import { defineStore } from "pinia";
import { Messager } from "@/api/ConnectCore";

// 全局空间
export const GlobelArea = defineStore('GArea',{
    state: ()=>{
        // 网站静态文件地址
        const staticFiles = {
            "webLogo": "/src/assets/sign/webLogo.png",
            "webLogoBig": "/src/assets/sign/webLogoBig.png",
            "ZHOUSign4": "/src/assets/sign/ZHOUSign4.png",
            "defaultBack": "/src/assets/images/defaultBack.png",
            "defaultHead": "/src/assets/images/defaultHead.png",
            "image404": "/src/assets/images/image404.png",
            "impression": "/src/assets/images/impression.png",
            "donate": "/src/assets/images/donate.png",
        };
        // 小兽用户
        const furryUser = {
            "isLog": false,
            "username": null,
            "name": null,
            "sex": null,
            "species": null,
            "headImage": null,
        };
        return {staticFiles,furryUser};
    },
    actions: {
        async getAndSetUserState(){
            // 检查登录 设置小兽信息
            let isLog = false;
            await Messager.checkLogin().then(res=>{
                if(res==1){
                    isLog = true;
                    this.furryUser.isLog = true;
                    Messager.getUserData().then(outArr=>{
                        this.furryUser.name = outArr.name
                        this.furryUser.sex = outArr.sex
                        this.furryUser.species = outArr.species
                        this.furryUser.username = outArr.username
                        this.furryUser.headImage = outArr.headImageUrl
                    });
                }
            });
            return isLog;
        }
    },
});