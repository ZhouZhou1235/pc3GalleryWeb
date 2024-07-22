<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 查找作品</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>ZZWW 查找作品</h1>
        </div>
        <div class="divBasic">
            <?php
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $search = $_POST["search"];
                $searchDraw = $_POST["searchDraw"];
                if($search!=null){
                    $sql = "
                    select *
                    from furrygallery
                    where furrygallery.title='$search'
                    ";
                    $result = mysqli_query($link,$sql);
                    $resultArray = mysqli_fetch_array($result);
                }
                else if($searchDraw!=null){
                    $sql = "
                    select *
                    from furrygallery
                    where furrygallery.title like '%$searchDraw%' or furrygallery.id='$searchDraw'
                    ";
                    $result = mysqli_query($link,$sql);
                    $resultArray = mysqli_fetch_array($result);
                }
                else{
                    die("<h2>ZZWW 获取搜索文本失败</h2>");
                }
                $id = $resultArray['Id'];
                $uploader = $resultArray['username'];
                $title = $resultArray['title'];
                $img = $resultArray['img'];
                $info = $resultArray['info'];
                $type = $resultArray['type'];
                $time = $resultArray['time'];
                $claw = $resultArray['claw'];

                $sql2 = "
                select *
                from account
                where username='$uploader'
                ";
                $result2 = mysqli_query($link,$sql2);
                $resultArray2 = mysqli_fetch_array($result2);
                $username = $resultArray2['username'];
                $name = $resultArray2['name'];
                $headimg = $resultArray2['headimg'];

                if($id==null){
                    exit("<h2>ZZWW 无此搜索结果</h2>");
                }

                echo<<<ZHOU
                    <div class='divSpectial'>
                        <img src='./furrygalleryimg/$img' width='75%' onerror="this.src='./fileLibrary/images/gallery.png'">
                        <div class='divTitle'><h2>$title</h2></div>
                        <div class='divContentWiden' style='text-align: left;'>
                        <form action="searchAccount.php" method="POST">
                            <input type="hidden" name="search" value="$username">
                            <button type="submit"><img src='./headimg/$headimg' width='10%' onerror="this.src='./fileLibrary/images/headimg.png'"></button>
                        </form>
                        <h2>$name</h2>
                        <p>类型 $type 时间 $time 印爪🐾$claw</p>
                        <p>$info</p>
                        </div>
                    </div>
                ZHOU;
                
                $commentSql = "
                select furrygallery.id,comment.sender,comment.work_id,comment.comment,comment.type,comment.time,account.headimg,account.username,account.name
                from comment,furrygallery,account
                where furrygallery.id=comment.work_id and account.username=comment.sender
                order by time DESC
                ";
                $commentResult = mysqli_query($link,$commentSql);
    
                echo "
                <div class='divBasic' style='display: flex; flex-wrap: wrap;'>
                <div class='divTitle'><h2>评论区</h2></div>
                ";
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
                        <div class='leftSide'>
                        <p><img src='./headimg/$headimg' width='20%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                        时间 $commentTime
                        </div>
                        ";
                    }
                }
                echo "
                </div>
                ";
            ?>
        </div>
    </div>
</body>
</html>
