<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 关于</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>关于</h1>
        </div>
        <div class="divSpectial">
            <?php
                session_start();
                $furryUser = $_SESSION['username'];
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');

                if($furryUser!=null){
                    echo "<h2>粉糖账号$furryUser 欢迎</h2>";

                    $sql = "select id from account order by id DESC ";
                    $result = mysqli_query($link,$sql);
                    $accountNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){$accountNum += 1;}
                    $sql = "select id from zzwwboard order by id DESC ";
                    $result = mysqli_query($link,$sql);
                    $boardNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){$boardNum += 1;}
                    $sql = "select id from phpcolumn order by id DESC ";
                    $result = mysqli_query($link,$sql);
                    $columnNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){$columnNum += 1;}
                    $sql = "select id from furrygallery order by id DESC ";
                    $result = mysqli_query($link,$sql);
                    $galleryNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){$galleryNum += 1;}
    
                    echo "
                    <h2>粉糖粒子统计</h2>
                    <p>加入了 <span style='color: palevioletred;'>$accountNum</span> 只小兽</p>
                    <p>留下了 <span style='color: palevioletred;'>$boardNum</span> 条留言</p>
                    <p>发布了 <span style='color: palevioletred;'>$columnNum</span> 篇图文</p>
                    <p>发布了 <span style='color: palevioletred;'>$galleryNum</span> 幅作品</p>
                    ";    
                }
                else{
                    echo "<a href='index.php'><h2>登录粉糖粒子查看</h2></a>";
                }
            ?>
        </div>
        <div class="divContentWiden">
            <div class="divTitle"><h2>粉糖粒子规则</h2></div>
            <p>
                1 请遵守我国的基本法律和道德规范<br>
                2 不要在粉糖粒子（公网）发布18+（允许幼兽不宜）、恐怖、猎奇、政治相关等敏感信息，一经发现可作出删除、删号等操作。<br>
                3 不要网络攻击其他小兽<br>
                4 不要一次性发送太多或无意义内容<br>
                5 尽可能不要添加和贴上错误的标签<br>
                <br>
                免责声明：<br/>
                ZZWW网站提供的任何信息及产生的效应由其发布者负责，<br/>
                本网站不提供任何保证也不承担任何法律责任。<br/>
            </p>
            <div class="divTitle"><h2>ZZWW简介</h2></div>
            <p>网站名称：粉糖粒子</p>
            <p>别称：ZZWW，ZHOUZHOU Web World</p>
            <p>
                恭喜发现互联网中的这处角落！
                粉糖粒子是站长周周创建的小众幻想动物图片站，
                本网站无广告和任何商业活动，为非盈利兴趣网站，
                主要提供各种毛绒绒艺术作品的发布和交流分享，
                当然也接受其它类型，开放包容是粉糖粒子的基本原则。
                让我们堆积更多的毛绒绒吧！
            </p>
            <div class="divTitle"><h2>ZZWW功能介绍</h2></div>
            <h2>毛绒画廊</h2>
            <p>
                这是ZZWW最核心的功能，用于作品发布展示。
                进入毛绒画廊找到发布作品即可发布，
                标题、类型和上传的图片为必须的信息。
                作品支持标签和评论。
            </p>
            <h2>标签墙纸</h2>
            <p>
                标签墙纸用于毛绒画廊的作品分类浏览，
                你可以在画廊中为作品贴标签。
                点击标签显示相关的作品。
                如果你输入的标签不存在，可以到这里添加新标签。
            </p>
            <h2>图文专栏</h2>
            <p>
                能够发布一篇简单含附图的文章，支持在文章下面评论。
                提出一个话题聊聊吧？
            </p>
            <h2>ZZWW留言板</h2>
            <p>
                ZZWW实现的第一个功能，在这里留下你的第一个爪印！
            </p>
            <h2>个兽空间</h2>
            <p>
                每只小兽都有自己的空间，能更改头像、名称、背景墙等信息。
                别的小兽也可以访问你的空间。
            </p>
            <h2>糖果</h2>
            <p>
                新小兽加入自动赠送100个糖果，发布内容可以获得糖果。
                糖果可以用来赠送给其他小兽，每赠送五颗糖果，他/她的星星瓶将添加一颗星星。
                注意，删除你发布的内容会损失糖果！
                糖果还可以用来干什么呢？未来将加入更多内容。欢迎小兽提出意见。
            </p>
            <div class="divEnd">
                <p>
                    <a href="https://zhouzhouwebworld.lofter.com">周周的LOFTER</a><br>
                    <a href="https://space.bilibili.com/63629388?spm_id_from=333.1007.0.0">周周的B站主页</a><br>
                    <a href="https://www.zhouzhouwebworld.online">粉糖粒子-万维网入口</a><br>
                </p>
                <p>
                    工作邮箱&nbsp;pinkcandyzhou@qq.com<br>
                    交流QQ群&nbsp;751711878
                </p>
            </div>
        </div>
    </div>
</body>
</html>