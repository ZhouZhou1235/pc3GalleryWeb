<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 搜索标签</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>搜索标签</h1>
        </div>
        <div class="divBasic">
            <?php
                session_start();
                $username = $_SESSION['username'];
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                if($username==null){
                    exit("<h2>ZZWW 请先登录</h2>");
                }

                $searchTags = $_POST['searchTags'];
                if($searchTags==null){exit('<h1>ZZWW 标签不能为空</h1>');}

                $sql = "
                select *
                from tags
                where id='$searchTags' or tag='$searchTags'
                ";
                $result = mysqli_query($link,$sql);
                if($result->num_rows==0){exit('<h1>ZZWW 该标签不存在</h1>');}
                $resultArray = mysqli_fetch_array($result);
                $id = $resultArray['Id'];
                $tag = $resultArray['tag'];
                $type = $resultArray['type'];
                $creator = $resultArray['creator'];
                $time = $resultArray['time'];
                echo "
                <div class='divSpectial'>
                    <div class='divTitle'><h2>$tag</h2></div>
                    <p>标签ID-$id 类型-$type 创建者-$creator 创建时间-$time</p>
                </div>
                ";

                $sql = "
                select *
                from tagsgallery
                where tagid='$id'
                ";
                $result = mysqli_query($link,$sql);
                while($resultArray = mysqli_fetch_array($result)){
                    $galleryid = $resultArray['galleryid'];
                    $sqlGalleay = "
                    select furrygallery.id,furrygallery.username,furrygallery.title,furrygallery.info,furrygallery.img,furrygallery.type,furrygallery.time,furrygallery.claw,account.username,account.name,account.headimg
                    from account,furrygallery
                    where furrygallery.id='$galleryid' and account.username=furrygallery.username
                    ";
                    $resultGallery = mysqli_query($link,$sqlGalleay);
                    while($resultArrayGallery = mysqli_fetch_array($resultGallery)){
                        $username = $resultArrayGallery['username'];
                        $name = $resultArrayGallery['name'];
                        $headimg = $resultArrayGallery['headimg'];
                        $title = $resultArrayGallery['title'];
                        $info = $resultArrayGallery['info'];
                        $img = $resultArrayGallery['img'];
                        $type = $resultArrayGallery['type'];
                        $time = $resultArrayGallery['time'];
                        $claw = $resultArrayGallery['claw'];
                        echo "<div class='leftSide'>";
                        echo<<<ZHOU
                                <img src='./furrygalleryimg/$img' alt='$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'">
                                <h2>$title</h2>
                                <p>$info</p>
                                <img src='./headimg/$headimg' alt='$headimg' width='30%' onerror="this.src='./fileLibrary/images/headimg.png'"><p>$name</p>
                                <form action="searchDraw.php" method="POST">
                                    <input type="submit" name="search" value="$title">
                                    <p>类型 $type 画廊ID $galleryid</p>
                                    $time
                                </form>
                                <form action="runTagsGallery.php" method="POST" enctype="multipart/form-data">
                                    <input type="text" name="tag" placeholder="为此作品贴标签">
                                    <input type="hidden" name="theWork" value="$galleryid">
                                    <button type="submit">🏷️</button>
                                </form>
                                <form action="addClaw.php" method="POST">
                                    <input type="hidden" name="theWork" value="$galleryid">
                                    <input type="hidden" name="theType" value="$theType">
                                    <input type="hidden" name="claw" value="$claw">
                                    <p>印爪🐾$claw<button type="submit">🐾</button></p>
                                </form>
                        ZHOU;

                        $sqlTags = "
                        select *
                        from tagsgallery
                        where galleryid='$galleryid'
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
                        echo "</div></div>";
                    }
                }
                

            ?>
        </div>
    </div>
</body>
</html>