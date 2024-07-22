<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 编辑画廊</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>编辑画廊</h1>
        </div>
        <div class="divBasic">
            <?php
            session_start();
            $username = $_SESSION['username'];
            $link = mysqli_connect('localhost','ZHOU','10171350','zzww');

            $sql = "select controlnum from account where username='$username'";
            $result = mysqli_query($link,$sql);
            $resultArray = mysqli_fetch_array($result);
            $controlnum = $resultArray['controlnum'];

            $galleryid = $_GET['galleryid'];
            $sqlGallery = "select * from furrygallery where id='$galleryid'";
            $resultGallery = mysqli_query($link,$sqlGallery);
            $resultArrayGallery = mysqli_fetch_array($resultGallery);
            $title = $resultArrayGallery['title'];
            $info = $resultArrayGallery['info'];
            $type = $resultArrayGallery['type'];
            $img = $resultArrayGallery['img'];
            $uploader = $resultArrayGallery['username'];

            $editGallery = 1;
            $delTags = 2;

            echo "<div class='divSpectial'>";
            echo <<<ZHOU
                <div class="leftSide" style="width: 75%;">
                    <img src='./furrygalleryimg/$img' alt='$img' width='75%' onerror="this.src='./fileLibrary/images/gallery.png'">
                    <p>画廊ID-$galleryid 当前标题-$title 类型-$type 上传者-$uploader 说明-$info</p>
                </div>
            ZHOU;
            if($username==$uploader || $controlnum==1){
                echo <<<ZHOU
                <div class="rightSide">
                    <form action="runEditGallery.php" method="POST" enctype="multipart/form-data">
                        <h2>编辑作品</h2>
                        <input type="hidden" name="editWhat" value="$editGallery">
                        <input type="hidden" name="galleryid" value="$galleryid">
                        <textarea name="title" id="title" cols="20" rows="2" placeholder="标题">$title</textarea>
                        <textarea name="info" id="info" cols="20" rows="4" placeholder="说明">$info</textarea>
                        <select name="type" id="type">
                            <option value="">选择</option>
                            <option value="原创">原创</option>
                            <option value="二次创作">二次创作</option>
                            <option value="临摹">临摹</option>
                            <option value="描图">描图</option>
                            <option value="转载">转载</option>
                            <option value="照片">照片</option>
                        </select>
                        <button type="submit">确认修改</button>
                    </form>
                </div>
                ZHOU;
            }
            else{echo "<h2>只有发布者或总管理兽可以编辑作品信息</h2>";}
            {
                $sqlTags = "select * from tagsgallery where galleryid='$galleryid'";
                $resultTags = mysqli_query($link,$sqlTags);
                echo <<<ZHOU
                    <div class="rightSide">
                        <h2>编辑标签</h2>
                        <form action="runTagsGallery.php" method="POST" enctype="multipart/form-data">
                            <input type="text" name="tag" placeholder="为此作品贴标签">
                            <input type="hidden" name="theWork" value="$galleryid">
                            <button type="submit">🏷️</button>
                        </form>
                        <table>
                        <thead>
                        <tr><td>标签</td><td>类型</td><td>写签兽</td><td>操作</td></tr>
                        <thead>
                ZHOU;
                while($resultArrayTags = mysqli_fetch_array($resultTags)){
                    $tagid = $resultArrayTags['tagid'];
    
                    $sqlShow = "select * from tags where id='$tagid'";
                    $resultShow = mysqli_query($link,$sqlShow);
                    $resultArrayShow = mysqli_fetch_array($resultShow);
                    $tag = $resultArrayShow['tag'];
                    $type = $resultArrayShow['type'];
                    $creator = $resultArrayShow['creator'];

                    static $typeColor;
                    if($type=="画师"){$typeColor = 'yellow';}
                    else if($type=="系列"){$typeColor = 'blue';}
                    else if($type=="角色"){$typeColor = 'orange';}
                    else if($type=="属性"){$typeColor = 'green';}
                    else if($type=="描述"){$typeColor = 'palevioletred';}
                    else{$typeColor = 'none';}
                    echo <<<ZHOU
                        <tr>
                            <td>$tag</td>
                            <td><span style="color: $typeColor;">$type</td>
                            <td>$creator</td>
                            <td>
                                <a href='runEditGallery.php?delTagId=$tagid&galleryid=$galleryid&editWhat=$delTags'>
                                <button onclick="return confirm('确定撕下 $tag 吗？')">撕下</button>
                                </a>
                            </td>
                        </tr>
                    ZHOU;
                }
                echo "</table></div>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>