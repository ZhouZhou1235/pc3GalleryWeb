<!-- 页面 种植盆栽 -->

<script setup>
import smallMenu from '../components/smallMenu.vue';
</script>

<template>
    <smallMenu/>
    <!-- 种植盆栽 -->
    <div class="container">
        <div class="row">
            <div class="col-sm-6 p-3">
                <h1>种植新盆栽</h1>
                <form action="">
                    <div class="input-group">
                        <div class="input-group-text">主题帖标题</div>
                        <input type="text" class="form-control" placeholder="主题帖标题" id="title" :onchange="showText">
                    </div>
                    <div class="input-group">
                        <div class="input-group-text">镇楼图</div>
                        <input type="file" class="form-control" :onchange="showImg" id="theImageFile">
                    </div>
                    <div class="p-3">
                        <textarea class="form-control" placeholder="内容" rows="5" id="content" :onchange="showText"></textarea>
                        <textarea class="form-control" placeholder="标签" rows="3"></textarea>    
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-light">发布</button>
                    </div>
                    <div class="container-sm border border-warning rounded border-3 mt-3">
                        <p>
                            所有小兽都可以发布帖子<br>
                            至少包含：标题和内容<br>
                            可以贴上标签，搜索标签能发现相关帖子。如有多个用空格隔开<br>
                        </p>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 p-3">
                <div class="card">
                    <div class="card-img-top">
                        <img src="" id="show" width="100%">
                    </div>
                    <div class="card-header"><h4><span id="showTitle"></span></h4></div>
                    <div class="card-body">
                        <p>
                            <span id="showContent"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    function showImg(){
        // 显示要上传的图片
        var reads = new FileReader();
        var file = document.getElementById("theImageFile").files[0];
        reads.readAsDataURL(file);
        reads.onload=function(e){document.getElementById("show").src=this.result;}
    };

    function showText(){
        // 显示要发布的帖子文本
        var title = document.getElementById("title").value;
        var content = document.getElementById("content").value;
        document.getElementById("showTitle").innerHTML=title;
        document.getElementById("showContent").innerHTML=content;
    };
</script>

<style scoped>
</style>
