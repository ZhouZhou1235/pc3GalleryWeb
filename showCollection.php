<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 浏览画廊合集</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>浏览画廊合集</h1>
        </div>
        <div class="divBasic">
            <?php
                session_start();
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $furryUser = $_SESSION['username'];
                if(!$furryUser){echo"<h2>ZZWW 请先登录</h2>";exit;}

                $collectionId = $_GET['collectionId'];
                $addGallery = 1;
                $editCollection = 2;

                $sql = "select * from collections where id='$collectionId'";
                $result = mysqli_query($link,$sql);
                $collections = mysqli_fetch_array($result);
                $title = $collections['title'];
                $info = $collections['info'];
                $cover = $collections['cover'];
                $creator = $collections['username'];
                $time = $collections['time'];
                echo <<<ZHOU
                    <div class="leftSide">
                        <img src="./furrygalleryimg/$cover" alt="$cover" width="100%">
                        <h2>$title</h2>
                        <p>$info</p>
                        <p>$creator</p>
                        $time
                        <form action='editCollection.php' method='POST'>
                            <h2>添加作品</h2>
                            <input type='hidden' name='collectionId' value='$collectionId'>
                            <input type='hidden' name='editWhat' value='$addGallery'>
                            <input type='text' name='galleryid' placeholder='在这个合集中添加作品（画廊ID）'>
                            <button type='submit'>添加</button>
                        </form>
                        <a href="editCollection.php?collectionId=$collectionId&editWhat=$editCollection">编辑</a>
                    </div>
                ZHOU;

                echo "<div class='divSpectial'><div class='divScreen'>";

                $sql = "select * from gallerycollections where collectionId='$collectionId' order by id DESC";
                $result = mysqli_query($link,$sql);
                while($gallerycollections = mysqli_fetch_array($result)){
                    $galleryid = $gallerycollections['galleryid'];
                    $adder = $gallerycollections['username'];

                    $sqlGalleay = "select username,title,img from furrygallery where id='$galleryid'";
                    $resultGallery = mysqli_query($link,$sqlGalleay);
                    $furrygallery = mysqli_fetch_array($resultGallery);
                    $username = $furrygallery['username'];
                    $title = $furrygallery['title'];
                    $img = $furrygallery['img'];
                    echo "
                    <div class='divShow50'>
                        <img src='./furrygalleryimg/$img' alt='$galleryid $username $title $img' width='100%'>
                        <p>$galleryid $username $title</p>
                    </div>
                    ";
                }

                echo "</div></div>";
            ?>
        </div>
    </div>
</body>
</html>