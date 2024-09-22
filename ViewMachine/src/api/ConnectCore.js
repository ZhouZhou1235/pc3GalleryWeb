// ConnetCore 通信连接
// 前后端交互

import axios from "axios";
import { ElMessage,ElMessageBox,ElNotification } from "element-plus";

// 后端入口地址
// vite配置 解决跨域通信问题
// server: {
//     proxy: {
//         '/api': {
//             target: 'http://localpc3gallery',
//             changeOrigin: true,
//             rewrite: (path)=>path.replace(/^\/api/,''),
//         }
//     }
// },

const coreUrl = "/api/core/ProcessMachine.php"; // 开发环境
// const coreUrl = "/core/ProcessMachine.php"; // 运行环境

/**
 * ### 标准发送
 * 发送数据并收听回复
 */
async function sender(obj){
    // obj 发送对象 如{action:1,todo:1}
    // then(res=>{})接收回传的数据
    let params = new FormData();
    for(let key in obj){params.append(key,obj[key])};
    let echoThing = null;
    await axios
    .post(coreUrl,params)
    .then(res=>{echoThing=res.data});
    return echoThing;
}

/**
 * ### 文件发送
 * 携带文件发送数据且收听回复
 */
async function fileSender(obj){
    // obj 携带文件的发送对象
    // 添加混合传输请求头
    let header = {headers: {'Content-Type':'mutipart/form-data'}};
    let params = new FormData();
    for(let key in obj){params.append(key,obj[key])};
    let echoThing = null;
    await axios
    .post(coreUrl,params,header)
    .then(res=>{echoThing=res.data});
    return echoThing;
}

/**
 * 将一个文件放入发送表单
 */
export function addFileToForm(obj,event,fileKey="file"){
    // obj 发送对象 event 文件输入事件$event fileKey input标签属性名
    // return obj
    // obj例 {action:2,todo:1,file:"",info:"",tags:""}
    let theFile = event.target.files[0];
    obj[fileKey] = theFile;
    return obj;
}

/**
 * ### 简单发送
 * 发送数据 没有多余动作
 */
function simpleSender(obj){
    // obj 发送对象
    let params = new FormData();
    for(let key in obj){params.append(key,obj[key])};
    axios.post(coreUrl,params);
}

/**
 * ## Messager 消息员
 * ### 与后端交互 收发数据
 * - 内含大量动作箭头函数 "actionName":()=>{}
 * - 调用 Messager.actionName();
 * - 调用并收听后端回复 Messager.actionName().then(res=>{});
 */
export const Messager = {
    "checkLogin":()=>{
        // 检查是否登录
        // res 0否 1是
        let myObj = {action:5,todo:4};
        return sender(myObj);
    },
    "getGallerysData":(myMode=1,a=null)=>{
        // 获得多画廊数据包
        // myMode 1时间排序 2随机排序 3按指定的粉糖账号 4按session
        // a 粉糖账号
        let myObj;
        if(myMode==1){myObj={action:3,todo:1,mode:1};}
        if(myMode==2){myObj={action:3,todo:1,mode:6};}
        if(myMode==3){myObj={action:3,todo:1,mode:3,username:a};}
        if(myMode==4){myObj={action:3,todo:1,mode:2};}
        return sender(myObj);
    },
    "getStarData":(myMode=1,a=null)=>{
        // 获得小兽的收藏数据
        // myMode 1 session 2 粉糖账号a指定
        let myObj;
        if(myMode==1){myObj={action:3,todo:6,mode:1};}
        if(myMode==2){myObj={action:3,todo:6,mode:2,username:a};}
        return sender(myObj);
    },
    "getPostsData":(myMode=1,a=null)=>{
        // 获得多盆栽数据包
        // myMode 1直接给出 2按session 3按指定的粉糖账号
        // a 粉糖账号
        let myObj;
        if(myMode==1){myObj={action:3,todo:2,mode:1};}
        if(myMode==2){myObj={action:3,todo:2,mode:2};}
        if(myMode==3){myObj={action:3,todo:2,mode:3,username:a};}
        return sender(myObj);
    },
    "getUserData":(theUsername=null)=>{
        // 获得小兽数据
        // username 粉糖账号
        let myObj;
        if(theUsername==null){myObj = {action:3,todo:3,mode:1};}
        else{myObj = {action:3,todo:3,mode:2,username:theUsername};}
        return sender(myObj);
    },
    "getBoardData":()=>{
        // 获得留言板数据
        let myObj = {action:3,todo:9};
        return sender(myObj);
    },
    "getGalleryData":(id)=>{
        // 获得单个画廊的完整数据
        // id 画廊号码
        let myObj = {action:3,todo:1,mode:4,galleryID:id};
        return sender(myObj);
    },
    "getTagsMask":(myMode,id)=>{
        // 获得标签标记数据
        // myMode 1画廊 2盆栽
        if(myMode==1){
            let myObj = {action:3,todo:4,mode:1,galleryID:id};
            return sender(myObj);
        }
        if(myMode==2){
            let myObj = {action:3,todo:4,mode:2,postID:id};
            return sender(myObj);
        }
    },
    "getCommentData":(myMode,id)=>{
        // 获得画廊评论或叶子
        // myMode 1画廊 2盆栽
        if(myMode==1){
            let myObj = {action:3,todo:5,mode:1,galleryID:id};
            return sender(myObj);
        }
        if(myMode==2){
            let myObj = {action:3,todo:5,mode:2,postID:id};
            return sender(myObj);
        }
    },
    "getUserData":(a=null)=>{
        // 获得小兽用户数据
        // a 粉糖账号 默认为空获取自己的数据
        let myObj;
        if(a==null){myObj={action:3,todo:3,mode:1};}
        else{myObj={action:3,todo:3,mode:2,username:a};}
        return sender(myObj);
    },
    "getMessageData":(a=null)=>{
        // 获得空间消息数据
        // a 粉糖账号 默认获得自己的消息
        let myObj;
        if(a==null){myObj={action:3,todo:7,mode:1};}
        else{myObj={action:3,todo:7,username:a,mode:2};}
        return sender(myObj);
    },
    "getTagsData":(myMode=1)=>{
        // 获得标签数据
        // myMode 1 标签随机 2 标签自增ID排序
        let myObj;
        if(myMode==1){myObj={action:3,todo:10,mode:1};}
        if(myMode==2){myObj={action:3,todo:10,mode:2};}
        return sender(myObj);
    },
    "getSearchThings":(a)=>{
        // 获得搜索数据
        // a tags字符串
        let myObj = {action:3,todo:8,tags:a};
        return sender(myObj);
    },
    "getPostData":(a)=>{
        // 获得一个盆栽的完整数据
        // a 盆栽号码 postID
        let myObj = {action:3,todo:2,mode:4,postID:a};
        return sender(myObj);
    },
    "requestLogin":(a,b)=>{
        // 登录
        let myObj = {action:1,todo:1,username:a,pendPassword:b};
        return sender(myObj);
    },
    "requestRegister":(a,b,c,d)=>{
        // 注册
        // a 粉糖账号 b 邮箱 c 密码 d 名称
        let myObj = {action:1,todo:2,username:a,email:b,pendPassword:c,name:d};
        return sender(myObj);
    },
    "requestResetCode":(a)=>{
        // 获取重置验证码
        // a 邮箱
        let myObj = {action:1,todo:3,email:a};
        simpleSender(myObj);
    },
    "requestResetPassword":(a,b)=>{
        // 重置密码
        // a 新密码 b 验证码
        let myObj = {action:1,todo:4,pendPassword:a,code:b};
        return sender(myObj);
    },
    "requestLogout":()=>{
        // 注销
        let myObj = {action:1,todo:5};
        simpleSender(myObj);
    },
    "requestIsPaw":(myMode,a,b=null)=>{
        // 印爪
        // myMode 1画廊 2画廊评论 3盆栽 4叶子
        // a 号码 b 评论ID
        if(myMode==1){
            let myObj = {action:2,todo:5,mode:1,galleryID:a};
            simpleSender(myObj);
        }
        if(myMode==2){
            let myObj = {action:2,todo:5,mode:1,galleryID:a,commentID:b};
            simpleSender(myObj);
        }
        if(myMode==3){
            let myObj = {action:2,todo:5,mode:2,postID:a};
            simpleSender(myObj);
        }
        if(myMode==4){
            let myObj = {action:2,todo:5,mode:2,postID:a,commentID:b};
            simpleSender(myObj);
        }
    },
    "requestIsStar":(myMode,a)=>{
        // 收藏
        // myMode 1画廊 2盆栽
        // a 号码
        if(myMode==1){
            let myObj = {action:2,todo:6,mode:1,galleryID:a};
            simpleSender(myObj);
        }
        if(myMode==2){
            let myObj = {action:2,todo:6,mode:2,postID:a};
            simpleSender(myObj);
        }
    },
    "requestChangeUser":(theDataList)=>{
        // 修改小兽信息
        // theDataList 携带文件的小兽信息对象
        let a = theDataList.headImage;
        let b = theDataList.backImage;
        theDataList = JSON.stringify(theDataList);
        let myObj = {action:4,todo:1,dataList:theDataList,headImage:a,backImage:b};
        return fileSender(myObj);
    },
    "requestChangeMedia":(myMode,a,b,id)=>{
        // 修改媒体内容
        // myMode 1画廊 2盆栽
        // a 标题 b 说明/内容 id 号码
        let myObj;
        if(myMode==1){myObj={action:4,todo:3,mode:1,galleryID:id,title:a,info:b};}
        if(myMode==2){myObj={action:4,todo:3,mode:2,postID:id,title:a,content:b};}
        return simpleSender(myObj);
    },
    "requestDelGallery":(id,a)=>{
        // 删除画廊
        // id 画廊号码 a 核验本兽身份
        let myObj = {action:4,todo:4,galleryID:id,username:a};
        return sender(myObj);
    },
    "requestDelPost":(id,a)=>{
        // 删除盆栽
        // id 盆栽号码 a 核验本兽身份
        let myObj = {action:4,todo:5,postID:id,username:a};
        return sender(myObj);
    },
    "followUser":(a)=>{
        // 关注小兽
        // a 关注的粉糖账号
        let myObj = {action:2,todo:8,username:a};
        return simpleSender(myObj);
    },
    "sendGalleryComment":(id,theContent)=>{
        // 发送画廊评论
        let myObj = {action:2,todo:4,mode:1,galleryID:id,content:theContent};
        return sender(myObj);
    },
    "sendPostComment":(obj)=>{
        // 生长叶子
        // 携带文件的发送表单对象
        let myObj = {action:2,todo:4,mode:2,postID:obj.postID,content:obj.content,file:obj.file};
        return sender(myObj);
    },
    "sendCommentReply":(a,id)=>{
        // 叶回复
        // a 回复内容 id 叶子号码
        let myObj = {action:2,todo:7,content:a,commentID:id};
        return simpleSender(myObj);
    },
    "sendNewGallery":(obj)=>{
        // 上传新画廊
        // obj格式
        // addGalleryForm: {
        //     file: null,
        //     title: "",
        //     info: "",
        //     tags: "",
        // },
        let myObj = {action:2,todo:1,file:obj.file,title:obj.title,info:obj.info,tags:obj.tags};
        return fileSender(myObj);
    },
    "sendNewPost":(obj)=>{
        // 种植新盆栽
        // obj格式
        // addPostForm: {
        //     file: null,
        //     title: "",
        //     content: "",
        //     tags: "",
        // },
        let myObj = {action:2,todo:2,file:obj.file,title:obj.title,content:obj.content,tags:obj.tags};
        return fileSender(myObj);
    },
    "sendBoardMessage":(a)=>{
        // 粉糖粒子留言板留言
        // a 留言内容
        let myObj = {action:2,todo:9,content:a};
        return simpleSender(myObj);
    },
    "addTags":(myMode,theTags,id)=>{
        // 贴标签
        // myMode 1画廊 2盆栽
        // theTags 标签字符串 id 号码
        let myObj;
        if(myMode==1){myObj = {action:2,todo:3,mode:1,tags:theTags,galleryID:id};}
        if(myMode==2){myObj = {action:2,todo:3,mode:2,tags:theTags,postID:id};}
        return sender(myObj);
    },
    "cancelTags":(myMode,theTags,id)=>{
        // 撕标签
        // myMode 1画廊 2盆栽
        // theTags 标签字符串 id 号码
        let myObj;
        if(myMode==1){myObj = {action:4,todo:2,mode:1,tags:theTags,galleryID:id};}
        if(myMode==2){myObj = {action:4,todo:2,mode:2,tags:theTags,postID:id};}
        return sender(myObj);
    },
}

/**
 * ## showNotice 操作提示
 * ### element-ui弹出提示信息引导小兽
 * - num 提示标号
 */
export function showNotice(num){
    switch(num){
        case 1:
            ElNotification({
                title: "流程处理机 网站入口",
                message: "登录失败 粉糖账号或密码错误",
                type: "error",
            });break;
        case 2:
            ElNotification({
                title: "流程处理机 网站入口",
                message: "注册失败 仔细阅读注册说明",
                type: "error",
            });break;
        case 3:
            ElNotification({
                title: "流程处理机 网站入口",
                message: "还没输入邮箱呢！",
                type: "warning",
            });break;
        case 4:
            ElNotification({
                title: "流程处理机 网站入口",
                message: "已请求网站系统发出邮件，注意接收验证码。",
                type: "info",
            });break;
        case 5:
            ElNotification({
                title: "流程处理机 网站入口",
                message: "重置密码失败 验证码错误、密码不符合注册要求或空",
                type: "error",
            });break;
        case 6:
            ElNotification({
                title: "流程处理机 网站入口",
                message: "登录成功",
                type: "success",
            });break;
        case 7:
            ElNotification({
                title: "流程处理机 内容添加",
                message: "画廊上传失败 至少要有图片和标题 请阅读上传说明",
                type: "error",
            });break;
        case 8:
            ElNotification({
                title: "流程处理机 内容添加",
                message: "画廊上传成功",
                type: "success",
            });break;
        case 9:
            ElNotification({
                title: "流程处理机 内容添加",
                message: "盆栽种植失败 至少要有盆栽名和内容 请阅读上传说明",
                type: "error",
            });break;
        case 10:
            ElNotification({
                title: "流程处理机 内容添加",
                message: "盆栽种植成功",
                type: "success",
            });break;
        case 11:
            ElNotification({
                title: "流程处理机 内容修改",
                message: "小兽信息修改失败 邮箱必须有效 名称不能为空 性别必须选择，隐藏选无",
                type: "error",
            });break;
        case 12:
            ElNotification({
                title: "流程处理机 内容修改",
                message: "小兽信息修改成功",
                type: "success",
            });break;
        case 13:
            ElNotification({
                title: "流程处理机 内容修改",
                message: "画廊已删除",
                type: "info",
            });break;
        case 14:
            ElNotification({
                title: "流程处理机 内容修改",
                message: "盆栽已删除",
                type: "info",
            });break;
    }
}