<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="author" content="ZZWW pinkcandyzhou">
    <meta name="description" content="小众幻想动物图片站 A Small Fantasy Furry Character Web Picture Station">
    <meta name="keywords" content="粉糖粒子 周周 幻想动物 图片 画廊 绘画 福瑞 pinkcandyzhou ZHOUZHOU furry art gallery">
    <title>ZZWW 粉糖粒子</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <link rel="manifest" href="manifest.json" />
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <?php
                session_start();
                $furryUser = $_SESSION['username'];
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                if(!$furryUser){
                    $imgA = '<img src="./fileLibrary/images/maleMascot.png" alt="maleMascot" width="100%">';
                    $imgB = '<img src="./fileLibrary/images/femaleMascot.png" alt="femaleMascot" width="100%">';
                    $num = random_int(1,4);
                    if($num==1){echo"<div class='divFullImg'>$imgA</div>";}
                    else if($num==2){echo"<div class='divFullImg'>$imgB</div>";}
                    else{
                        $sql = "select id,username,title,type,img from furrygallery order by rand()";
                        $result = mysqli_query($link,$sql);
                        $furrygallery = mysqli_fetch_array($result);
                        $id = $furrygallery['id'];
                        $username = $furrygallery['username'];
                        $title = $furrygallery['title'];
                        $type = $furrygallery['type'];
                        $img = $furrygallery['img'];
                        $sql = "select name from account where username='$username'";
                        $result = mysqli_query($link,$sql);
                        $account = mysqli_fetch_array($result);
                        $name = $account['name'];
                        echo <<<ZHOU
                            <div class='divUser'>
                                <h2>$title</h2>
                            </div>
                            <div class='divFloor'>
                                <p>画廊ID-$id 类型-$type $name 粉糖账号-$username</p>
                            </div>
                            <div class='divFullImg'>
                                <img src='./furrygalleryimg/$img' alt='$img' width='100%'>
                            </div>
                        ZHOU;

                    }
                    echo <<<ZHOU
                        <div class="divMiddle">
                            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
                            <h1>粉糖粒子</h1>
                            <h2>让世界变成四脚兽的样子xwx</h2>            
                            <div class="divInputZone">
                                <form action="runLogin.php" method="POST" id="login">
                                    <input type="text" name="username" placeholder="粉糖账号">
                                    <input type="password" name="password" placeholder="密码">
                                </form>
                            </div>
                            <div class="divInputZone">
                                <button type="submit" form="login">登录</button>
                                <a href="./register.php"><button>注册</button></a>
                            </div>
                            若忘记密码，请发送邮箱到pinkcandyzhou@qq.com申请重置。
                        </div>
                    ZHOU;
                    exit;
                }
            ?>
        </div>
        <?php
            echo<<<ZHOU
                <div id="divMenu">
                    <a href="#top">ZZWW</a>
                    <a href="./about.php">🏠关于</a>
                    <a href="./lab.php">🔭实验室</a>
                    <a href="./indexView.php">🌐全站速览</a>
                    <a href="./zzwwboard.php">📃留言板</a>
                    <a href="./phpcolumn.php">📰图文专栏</a>
                    <a href="./furrygallery.php">🖼️毛绒画廊</a>
                    <a href="./tags.php">🗃️标签墙纸</a>
                </div>
                <div class="divBasic" id="top">
                    <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
                    <h1>粉糖粒子</h1>
                    <div class="divIndexMenu" style="text-align: center;">
                        <a href="./about.php">🏠关于</a>
                        <a href="./lab.php">🔭实验室</a>
                        <a href="./indexView.php">🌐全站速览</a>
                        <a href="./zzwwboard.php">📃留言板</a>
                        <a href="./phpcolumn.php">📰图文专栏</a>
                        <a href="./furrygallery.php">🖼️毛绒画廊</a>
                        <a href="./tags.php">🗃️标签墙纸</a>
                    </div>
                </div>    
            ZHOU;    
        ?>
        <div class="divBasic">
            <?php
                $username = $_SESSION['username'];
                // 个兽空间
                {
                    $sql = "
                    select *
                    from account
                    where username='$username'
                    ";
                    $result = mysqli_query($link,$sql);
                    $resultArray = mysqli_fetch_array($result);

                    $username = $resultArray['username'];
                    $name = $resultArray['name'];
                    $sex = $resultArray['sex'];
                    $headimg = $resultArray['headimg'];
                    $furrytype = $resultArray['furrytype'];
                    $signature = $resultArray['signature'];
                    $qq = $resultArray['qq'];
                    $id = $resultArray['Id'];
                    echo <<<ZHOU
                    <div class="leftSide">
                    <div class="divTitle"><a href="myPage.php"><h2>$name</h2></a></div>
                    <p>个兽空间 粉糖账号$username</p>
                    <a href="myPage.php"><img src="./headimg/$headimg" width="30%" onerror="this.src='./fileLibrary/images/headimg.png'"></a>
                    <p>$sex $furrytype qq:$qq</p>
                    <p>$signature</p>
                    ZHOU;
                    
                    // 首页时钟
                    echo<<<ZHOU
                        <div class='divSpectial'>
                            <span id='timeClock'><script>timeClock()</script></span><br>
                            <span><script>timeDay()</script></span>|<span><script>timeWeek()</script></span><br>
                        </div>
                    ZHOU;

                    // 留言板
                    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                    $sql = "
                    select account.username,account.name,zzwwboard.id,zzwwboard.username,zzwwboard.content,zzwwboard.img,zzwwboard.time
                    from account,zzwwboard
                    where account.username=zzwwboard.username
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                    <div class='divTitle'><a href='zzwwboard.php'><h2>ZZWW留言板</h2></a></div>
                    ";
                    $showNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){
                        $showNum += 1; 

                        $username = $resultArray['username'];
                        $name = $resultArray['name'];
                        $content = $resultArray['content'];
                        $img = $resultArray['img'];
                        $time = $resultArray['time'];
        
                        echo<<<ZHOU
                            <form action="searchAccount.php" method="POST">
                                <input type="hidden" name="search" value="$username">
                                <button type="submit">$name</button>
                            </form>
                            <p>$content</p>
                            <img src='./zzwwboardimg/$img' width='100%' onerror="this.src='./fileLibrary/images/board.png'">
                            $time
                        ZHOU;
                        if($showNum>19){
                            break;
                        }
                    }
                    echo "
                    <div class='divEnd'><p>仅展示最近20条</p></div>
                    </div>
                    ";
                }
                // 图文专栏
                {
                    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                    $sql = "
                    select phpcolumn.id,account.username,account.name,phpcolumn.username,phpcolumn.content,phpcolumn.title,phpcolumn.img,phpcolumn.time,phpcolumn.claw,account.headimg
                    from account,phpcolumn
                    where account.username=phpcolumn.username
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                    <div class='rightSide'>
                    <div class='divTitle'><a href='phpcolumn.php'><h2>图文专栏</h2></a></div>
                    ";
                    $showNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){
                        $showNum += 1; 
                        $id = $resultArray['id'];
                        $username = $resultArray['username'];
                        $name = $resultArray['name'];
                        $title = $resultArray['title'];
                        $content = $resultArray['content'];
                        $img = $resultArray['img'];
                        $time = $resultArray['time'];
                        $claw = $resultArray['claw'];
                        $theType = 'column';
                        $headimg = $resultArray['headimg'];

                        echo<<<ZHOU
                            <h2>$title</h2>
                            <p>$content</p>
                            <img src='./phpcolumnimg/$img' width='100%' onerror="this.src='./fileLibrary/images/column.png'">
                            <div class='divUser'>
                                <form action="searchAccount.php" method="POST">
                                    <img src='./headimg/$headimg' width='20%' onerror="this.src='./fileLibrary/images/headimg.png'">
                                    <input type="hidden" name="search" value="$username">
                                    <button type="submit">$name</button>
                                </form>
                                <form action="addClaw.php" method="POST">
                                    <input type="hidden" name="theWork" value="$id">
                                    <input type="hidden" name="theType" value="$theType">
                                    <input type="hidden" name="claw" value="$claw">
                                    <p>图文ID:$id 印爪🐾$claw<button type="submit">🐾</button></p>
                                    $time
                                </form>
                            </div>
                        ZHOU;

                        $commentSql = "
                        select phpcolumn.id,comment.sender,comment.work_id,comment.comment,comment.type,comment.time,account.headimg,account.username,account.name
                        from comment,phpcolumn,account
                        where phpcolumn.id=comment.work_id and account.username=comment.sender
                        order by time DESC
                        ";
                        $commentResult = mysqli_query($link,$commentSql);
        
                        echo "
                        <div class='divContentWiden'>
                        ";

                        echo<<<ZHOU
                            <div class="divInputZone">
                                <form action="commentColumn.php" method="POST" enctype="multipart/form-data">
                                    <textarea name="comment" id="comment" cols="20" rows="2" placeholder="评论"></textarea>
                                    <input type="hidden" name="id" value="$id">
                                    <button type="submit">发送</button>
                                </form>
                            </div>
                        ZHOU;

                        while($commentResultArray = mysqli_fetch_array($commentResult)){
                            $sender = $commentResultArray['sender'];
                            $name = $commentResultArray['name'];
                            $comment = $commentResultArray['comment'];
                            $type = $commentResultArray['type'];
                            $commentTime = $commentResultArray['time'];
                            $theId = $commentResultArray['work_id'];
                            $headimg = $commentResultArray['headimg'];
                            if($theId==$id&&$type=='column'){
                                echo "
                                <p><img src='./headimg/$headimg' width='10%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                                时间 $commentTime
                                ";
                            }
                        }
                        echo "</div>";

                        if($showNum>9){
                            break;
                        }
                    }
                    echo "
                    <div class='divEnd'><p>仅展示最近10条</p></div>
                    </div>
                    ";    
                }
                // 毛绒画廊
                {
                    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                    $sql = "
                    select furrygallery.id,account.username,account.name,furrygallery.username,furrygallery.title,furrygallery.info,furrygallery.img,furrygallery.type,furrygallery.time,furrygallery.claw,account.headimg
                    from account,furrygallery
                    where account.username=furrygallery.username
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                    <div class='divContent'>
                    <div class='divTitle'><a href='furrygallery.php'><h2>毛绒画廊</h2></a></div>
                    ";
                    $showNum = 0;
                    while($resultArray = mysqli_fetch_array($result)){
                        $showNum += 1; 
                        $id = $resultArray['id'];
                        $username = $resultArray['username'];
                        $name = $resultArray['name'];
                        $title = $resultArray['title'];
                        $info = $resultArray['info'];
                        $img = $resultArray['img'];
                        $type = $resultArray['type'];
                        $time = $resultArray['time'];
                        $claw = $resultArray['claw'];
                        $theType = 'gallery';
                        $headimg = $resultArray['headimg'];
                        echo<<<ZHOU
                            <h2>$title</h2>
                            <img src='./furrygalleryimg/$img' alt='$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'">
                            <p>$info</p>
                            <div class='divUser'>
                            <p><img src='./headimg/$headimg' alt='$headimg' width='20%' onerror="this.src='./fileLibrary/images/headimg.png'"></p>
                            <p>$name</p>
                            <form action="searchDraw.php" method="POST">
                                <p>
                                <input type="submit" name="search" value="$title">
                                类型 $type
                                </p>
                            </form>
                            <form action="addClaw.php" method="POST">
                                <input type="hidden" name="theWork" value="$id">
                                <input type="hidden" name="theType" value="$theType">
                                <input type="hidden" name="claw" value="$claw">
                                <p>画廊ID:$id 印爪🐾$claw<button type="submit">🐾</button></p>
                            </form>
                            $time
                            </div>
                        ZHOU;

                        $sqlTags = "
                        select *
                        from tagsgallery
                        where galleryid='$id'
                        ";
                        $resultTags = mysqli_query($link,$sqlTags);
                        echo "<div class='divEnd'>";
                        while($resultArrayTags = mysqli_fetch_array($resultTags)){
                            $tagid = $resultArrayTags['tagid'];
                            $showTags = "
                            select *
                            from tags
                            where id='$tagid'
                            ";
                            $resultShow = mysqli_query($link,$showTags);
                            $resultArrayShow = mysqli_fetch_array($resultShow);
                            $tag = $resultArrayShow['tag'];
                            echo <<<ZHOU
                                <form action="searchTags.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="searchTags" value="$tag">
                                    <button type="submit">$tag</button>
                                </form>
                            ZHOU;
                        }
                        echo "</div>";
    
                        $commentSql = "
                        select furrygallery.id,comment.sender,comment.work_id,comment.comment,comment.type,comment.time,account.headimg,account.username,account.name
                        from comment,furrygallery,account
                        where furrygallery.id=comment.work_id and account.username=comment.sender
                        order by time DESC
                        ";
                        $commentResult = mysqli_query($link,$commentSql);
        
                        echo "
                        <div class='divContentWiden'>
                        ";

                        echo<<<ZHOU
                            <div class="divInputZone">
                                <form action="commentGallery.php" method="POST" enctype="multipart/form-data">
                                    <textarea name="comment" id="comment" cols="20" rows="2" placeholder="评论"></textarea>
                                    <input type="hidden" name="id" value="$id">
                                    <button type="submit">发送</button>
                                </form>
                            </div>
                        ZHOU;

                        while($commentResultArray = mysqli_fetch_array($commentResult)){
                            $sender = $commentResultArray['sender'];
                            $name = $commentResultArray['name'];
                            $comment = $commentResultArray['comment'];
                            $type = $commentResultArray['type'];
                            $commentTime = $commentResultArray['time'];
                            $theId = $commentResultArray['work_id'];
                            $headimg = $commentResultArray['headimg'];
                            if($theId==$id&&$type=='gallery'){
                                echo "
                                <p><img src='./headimg/$headimg' width='10%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                                时间 $commentTime
                                ";
                            }
                        }
                        echo "</div>";

                        if($showNum>19){
                            break;
                        }
                    }
                    echo "
                    <div class='divEnd'><p>仅展示最近20条</p></div>
                    </div>
                    ";
                }
                // 加载JS
                {
                    echo "
                        <script>
                            setInterval(timeClock,1000);
                        </script>
                        <script>
                            // 滚动触发事件
                            window.onscroll=function(){
                                const divMenu = document.getElementById('divMenu');
                                const y=document.documentElement.scrollTop||document.body.scrollTop
                                if(y>300){
                                    divMenu.style.visibility='visible';
                                }
                                else{
                                    divMenu.style.visibility='hidden';
                                }
                            }
                        </script>
                    ";
                }
            ?>
            <div class="divBasic">
                <div class="divEnd">
                    <div class="divSpectial">
                        <img src="./fileLibrary/images/theSign.png" width="5%">
                        <img src="./fileLibrary/images/webLogo.png" width="15%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
// 注册service worker
window.addEventListener('load',()=>{
    if('serviceWorker' in navigator){
        navigator.serviceWorker
        .register('./JavaScript/sw.js')
        .then(registration => {
            // console.log(registration)
        })
        .catch(err => {
            console.log(err)
        })
    }
});
</script>
</html>