<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 毛绒画廊</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div id="divMenu">
            <a href="#top">ZZWW</a>
            <a href="./zzwwboard.php">📃留言板</a>
            <a href="./phpcolumn.php">📰图文专栏</a>
            <a href="./tags.php">🗃️标签墙纸</a>
            <a href="./collection.php">📚画廊合集</a>
        </div>
        <div class="divBasic" id="top">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>毛绒画廊</h1>
            <div class="divIndexMenu" style="text-align: center;">
                <a href="./zzwwboard.php">📃留言板</a>
                <a href="./phpcolumn.php">📰图文专栏</a>
                <a href="./tags.php">🗃️标签墙纸</a>
                <a href="./collection.php">📚画廊合集</a>
            </div>
        </div>
        <div class="leftSide">
            <div class=divTitle><h2>发布作品</h2></div>
            <div class="divInputZone">
                <form action="searchDraw.php" method="POST">
                    <input type="text" name="searchDraw">
                    <button type="submit">搜索作品</button>
                </form>
                <form action="updateGallery.php" method="POST" enctype="multipart/form-data">
                    <textarea name="title" id="title" cols="20" rows="2" placeholder="标题"></textarea><br>
                    <textarea name="info" id="info" cols="20" rows="4" placeholder="说明"></textarea><br>
                    <p>作品类型<select name="type" id="type">
                        <option value="">选择</option>
                        <option value="原创">原创</option>
                        <option value="二次创作">二次创作</option>
                        <option value="临摹">临摹</option>
                        <option value="描图">描图</option>
                        <option value="转载">转载</option>
                        <option value="照片">照片</option>
                    </select></p>
                    <p>上传图片<input type="file" name="file"><button type="submit">发送</button></p>
                </form>
            </div>
            <?php
                session_start();
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');

                $sql = "
                select *
                from tags
                order by id DESC
                ";
                $result = mysqli_query($link,$sql);
                echo "
                <div class=divTitle><a href='tags.php'><h2>最近标签</h2></a></div>
                <div class='divSpectial' style='text-align: left;'>
                <ul>
                ";
                $showNum = 0;
                while($resultArray = mysqli_fetch_array($result)){
                    $type = $resultArray['type'];
                    $tag = $resultArray['tag'];
                    if($type=="画师"){echo "<li><p><span style='color: yellow;'>$type</span> $tag</p></li>";}
                    else if($type=="系列"){echo "<li><p><span style='color: blue;'>$type</span> $tag</p></li>";}
                    else if($type=="角色"){echo "<li><p><span style='color: orange;'>$type</span> $tag</p></li>";}
                    else if($type=="属性"){echo "<li><p><span style='color: green;'>$type</span> $tag</p></li>";}
                    else if($type=="描述"){echo "<li><p><span style='color: palevioletred;'>$type</span> $tag</p></li>";}
                    else{echo "<li><p><span style='color: none;'>$type</span> $tag</p></li>";}
                    $showNum += 1;
                    if($showNum>39){break;}
                }
                echo "</ul></div>";
            ?>
        </div>
        <div class="divSpectial">
            <?php
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $furryUser = $_SESSION['username'];
                if($furryUser==null){exit("<h2>ZZWW 请先登录</h2>");}

                $sql = "
                select furrygallery.id,account.username,account.name,furrygallery.username,furrygallery.title,furrygallery.info,furrygallery.img,furrygallery.type,furrygallery.time,furrygallery.claw,account.headimg
                from account,furrygallery
                where account.username=furrygallery.username
                order by id DESC
                ";
                $result = mysqli_query($link,$sql);
                
                echo "
                <div class='divTitle'><a href='furrygallery.php'><h2>毛绒画廊</h2></a></div>
                <div class='divContentWiden' style='display: flex; flex-wrap: wrap;'>
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

                    $myself = $_SESSION['username'];

                    echo "<div class='leftSide'>";
                    if($username==$myself){
                        echo<<<ZHOU
                            <h2>$title</h2>
                            <img src='./furrygalleryimg/$img' alt='$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'">
                            <p>$info</p>
                            <div class='divSpectial'>
                                <img src='./headimg/$headimg' alt='$headimg' width='30%' onerror="this.src='./fileLibrary/images/headimg.png'"><p>$name</p>
                                <form action="searchDraw.php" method="POST">
                                    <input type="submit" name="search" value="$title">
                                    <p>类型 $type 画廊ID $id</p>
                                    $time
                                </form>
                                <form action="addClaw.php" method="POST">
                                    <input type="hidden" name="theWork" value="$id">
                                    <input type="hidden" name="theType" value="$theType">
                                    <input type="hidden" name="claw" value="$claw">
                                    <p>印爪🐾$claw<button type="submit">🐾</button></p>
                                </form>
                                <form action="runTagsGallery.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="tag" placeholder="为此作品贴标签">
                                    <input type="hidden" name="theWork" value="$id">
                                    <button type="submit">🏷️</button>
                                </form>
                                <form action="delContent.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('确认删除？这将丢失25个糖果！')">
                                    <input type="hidden" name="delId" value="$id">
                                    <input type="hidden" name="delType" value="gallery">
                                    <button type="submit">删除</button>
                                </form>
                                <a href="editGallery.php?galleryid=$id">编辑</a>
                            </div>
                        ZHOU;   
                    }
                    else{
                        echo<<<ZHOU
                            <h2>$title</h2>
                            <img src='./furrygalleryimg/$img' alt='$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'">
                            <p>$info</p>
                            <div class='divSpectial'>
                                <img src='./headimg/$headimg' alt='$headimg' width='30%' onerror="this.src='./fileLibrary/images/headimg.png'"><p>$name</p>
                                <form action="searchDraw.php" method="POST">
                                    <input type="submit" name="search" value="$title">
                                    <p>类型 $type 画廊ID $id</p>
                                    $time
                                </form>
                                <form action="addClaw.php" method="POST">
                                    <input type="hidden" name="theWork" value="$id">
                                    <input type="hidden" name="theType" value="$theType">
                                    <input type="hidden" name="claw" value="$claw">
                                    <p>印爪🐾$claw<button type="submit">🐾</button></p>
                                </form>
                                <form action="runTagsGallery.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="tag" placeholder="为此作品贴标签">
                                    <input type="hidden" name="theWork" value="$id">
                                    <button type="submit">🏷️</button>
                                </form>
                                <a href="editGallery.php?galleryid=$id">编辑</a>
                            </div>
                        ZHOU;
                    }

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
                    <div class='divSpectial'>
                    ";

                    echo<<<ZHOU
                        <form action="commentGallery.php" method="POST" enctype="multipart/form-data">
                            <textarea name="comment" id="comment" cols="20" rows="2" placeholder="评论"></textarea>
                            <input type="hidden" name="id" value="$id">
                            <button type="submit">发送</button>
                        </form>
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
                            <p><img src='./headimg/$headimg' width='20%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                            时间 $commentTime
                            ";
                        }
                    }
                    echo "
                    </div>
                    </div>
                    ";
                    if($showNum>39){
                        break;
                    }
                }
                echo "
                </div>
                <div class='divEnd'><p>仅展示最近40条</p></div>
                ";  
            ?>
        </div>
    </div>
</body>
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
</html>