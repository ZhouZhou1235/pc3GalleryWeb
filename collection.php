<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 画廊合集</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>毛绒画廊合集</h1>
        </div>
        <div class="divBasic">
            <?php
            session_start();
            $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
            $furryUser = $_SESSION['username'];
            if(!$furryUser){echo"<h2>ZZWW 请先登录</h2>";exit;}

            echo <<<ZHOU
                <div class="divSpectial">
                    <div class="divInputZone">
                        <form action="addCollection.php" method="POST">
                            <h2>创建合集</h2>
                            <input type="text" name="cover" placeholder="合集封面（画廊ID）">
                            <input type="text" name="title" placeholder="合集标题">
                            <textarea type="text" name="info" cols="20" rows="2" placeholder="合集说明"></textarea>
                            <button type="submit">创建</button>
                        </form>
                    </div>
                </div>
            ZHOU;

            $sql = "select * from collections order by id DESC";
            $result = mysqli_query($link,$sql);
            echo "<div class='divScreen'>";
            while($collections = mysqli_fetch_array($result)){
                $collectionId = $collections['Id'];
                $title = $collections['title'];
                $info = $collections['info'];
                $cover = $collections['cover'];
                $creator = $collections['username'];
                $time = $collections['time'];
                echo "
                    <div class='divShow25'>
                        <img src='./furrygalleryimg/$cover' alt='$cover' width='100%'>
                        <div class='divTitle'><a href='showCollection.php?collectionId=$collectionId'><h2>$title</h2></a></div>
                        <p>$info</p>
                        创建者-$creator <br> 时间-$time
                    </div>
                ";
            }
            echo "</div>";
            ?>
        </div>
    </div>
</body>
</html>