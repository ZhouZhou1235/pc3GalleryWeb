<!-- 导航 用户 -->

<script setup>
import { RouterLink, RouterView } from 'vue-router';
</script>

<template>
    <!-- 小兽操作 -->
    <div class="container">
        <div class="btn-group">
            <button class="btn" data-bs-toggle="modal" data-bs-target="#myModal">修改个兽信息</button>
            <!-- 修改表单模态框 -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-xl">
                    <form action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">修改个兽信息</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="container-sm text-center">
                                            <img src="/ViewMachine/assets/Images/logo_small.svg" alt="headImg" width="100%" id="show">
                                            <h4>名称</h4>
                                            <p>粉糖账号</p>
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">邮箱</span>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">密码</span>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-text">头像</span>
                                            <input type="file" class="form-control" :onchange="showImg" id="theImageFile">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">背景墙</span>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">名称</span>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="input-group">
                                            <span class="input-group-text">介绍</span>
                                            <textarea name="" id="" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>性别</option>
                                                    <option value="1">雌</option>
                                                    <option value="2">雄</option>
                                                    <option value="3">无</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <span class="input-group-text">兽种</span>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-sm border border-warning rounded border-3">
                                            <p>
                                                不要随意改变邮箱和密码，您需要确保：<br>
                                                1 邮箱可用，用于找回账号。<br>
                                                2 记住密码<br>
                                                粉糖粒子允许上传自由宽高比的背景墙图像，
                                                但建议上传形状扁平的背景墙。<br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn">修改</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <RouterLink to="/galleryChange"><button class="btn">管理画廊</button></RouterLink>
            <RouterLink to="/postChange"><button class="btn">管理盆栽</button></RouterLink>
            <RouterLink to="/userMessage"><button class="btn">消息</button></RouterLink>
            <RouterLink to="/userStar"><button class="btn">收藏</button></RouterLink>
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
</script>

<style scoped>
</style>
