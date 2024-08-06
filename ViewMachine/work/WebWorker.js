// 屏幕显示机 处理区
// 前端逻辑在这里处理

import { Sender,Receiver } from "../api/Messenger";
import { ref } from 'vue';
import { notify } from "@kyvg/vue3-notification";

export class FileMover {
    // 文件搬运工
    // 工作：与邮递员一起完成文件任务
    fileReady(event,obj,fileKey="file"){
        // 文件装入表单
        // event 文件输入事件 obj 表单对象 fileKey 装文件的键名
        let file = ref(null);
        let theFile = event.target.files[0];
        file.value = theFile;
        obj[fileKey] = theFile;
        notify({
            title: "PINKCANDY INFO",
            text: "文件搬运工 我把文件装到发信员的表单里",
            duration: 1000,
        });
        console.log("文件搬运工 我把文件"+JSON.stringify(event)+"装到发信员的表单里");
    }
    fileUpload(obj){
        // 将携带文件的表单上传到到后端
        let sender = new Sender();
        let receiver = new Receiver();
        sender.postSender(obj,2)
        .then(res=>{
            receiver.postReceiver(res);
            notify({
                title: "PINKCANDY INFO",
                text: "文件搬运工 我完成了本次文件搬运",
                duration: 1000,
            });    
            console.log("文件搬运工 我完成了本次文件搬运 出事别找我找发信员");
        });
    }
}

export class Painter {
    // 画家
    // 工作：将收到的数据包变成小兽能看懂的形式
    paint_arr(outArr,showData,loadNum,arrKey="mainData"){
        // 渲染多项数据包
        /*
            outArr 后端回应的数据包
            showData 目前载入的数据包
            loadNum 应加载条数
            arrKey 回应数据包的键名
        */
        if(outArr==null){return 0;}
        if(loadNum>outArr[arrKey].length){
            loadNum=outArr[arrKey].length;
        }
        for(let i=0;i<loadNum;i++){
            var addObj = outArr[arrKey][i];
            showData[i] = addObj;
        }
        notify({
            title: "PINKCANDY INFO",
            text: "画家 owo 我完成了数据包的绘制",
            duration: 1000,
        });    
        console.log("画家 owo 我完成了数据包的绘制");
        // 返回outArr用于载入当前页
        return outArr;
    }
    paint_arrNoKey(outArr,showData,loadNum){
        // 渲染没有key的数据包
        if(loadNum>outArr.length){loadNum=outArr.length;}
        for(let i=0;i<loadNum;i++){showData[i] = outArr[i];}
    }
    loadMore(theOutArr,showData,loadNum,viewNum,num=10,arrKey="mainData"){
        // 点击加载更多
        /*
            theOutArr 数据包
            showData 目前载入的数据包
            loadNum 应加载条数
            viewNum 目前加载数
            num 点击后加载条数
            arrKey 访问theOutArr的键
            返回 number 完成应加载条数 true 完成了所有数据加载或传入数据为空
        */
        var noMore = false;
        if(
            JSON.stringify(theOutArr)=='{}' ||
            JSON.stringify(showData)=='{}' ||
            theOutArr==null ||
            showData==null
        ){
            notify({
                type: "warn",
                title: "PINKCANDY INFO",
                text: "画家 不给我数据包我怎么画画呢",
                duration: 1000,
            });    
            console.log("画家 不给我数据包我怎么画画呢");
            return true;
        }
        if(loadNum<theOutArr[arrKey].length){
            loadNum += num;
            if(loadNum>theOutArr[arrKey].length){
                loadNum=theOutArr[arrKey].length;
                noMore=true;
            } // 全部都加载完毕
        }else{loadNum=theOutArr[arrKey].length;noMore=true;};
        for(let i=viewNum;i<loadNum;i++){
            var addObj = theOutArr[arrKey][i];
            showData[i] = addObj;
        }
        if(noMore){
            notify({
                type: "warn",
                title: "PINKCANDY INFO",
                text: "画家 没有更多的数据包，我下班了！",
            });
            console.log("画家 没有更多的数据包，我下班了！");
            return true;
        }
        notify({
            title: "PINKCANDY INFO",
            text: "画家 -w- 还想看吗？好吧，我完成了更多绘制。",
            duration: 1000,
        });
        console.log("画家 -w- 还想看吗？好吧，我完成了更多绘制。");
        return loadNum;
    }
}