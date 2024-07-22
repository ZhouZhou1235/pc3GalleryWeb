<!DOCTYPE html>
<?php
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$furryUser = $_SESSION['username'];
if(!$furryUser){echo"<h2>ZZWW 请先登录</h2>";exit;}

$editWhat = $_POST['editWhat'];
$collectionId = $_POST['collectionId'];
if(!$collectionId){$collectionId = $_GET['collectionId'];}
$galleryid = $_POST['galleryid'];

$sql = "select controlnum from account where username='$furryUser'";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];
$sql = "select username from collections where id='$collectionId'";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$creator = $resultArray['username'];
if($controlnum==1 || $controlnum==2 || $creator==$furryUser){null;}
else{echo"<h1>ZZWW 只有合集创建者或管理兽可执行该操作</h1>";exit;}

if(!$editWhat){$editWhat = $_GET['editWhat'];}
if($editWhat == 1){
    $sql = "select img from furrygallery where id='$galleryid'";
    $result = mysqli_query($link,$sql);
    if($result->num_rows==0){echo"<h1>ZZWW 找不到画廊ID为 $galleryid 的作品</h1>";exit;}
    $sql = "select * from gallerycollections where galleryid='$galleryid' and collectionid='$collectionId'";
    $result = mysqli_query($link,$sql);
    if($result->num_rows>0){echo"<h1>ZZWW 已添加画廊ID为 $galleryid 的作品</h1>";exit;}

    $sql = "
    insert into gallerycollections(galleryid,collectionid,username)
    values('$galleryid','$collectionId','$furryUser')
    ";
    $result = mysqli_query($link,$sql);
    echo "<script>window.history.go(-1);</script>";
    exit;
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 编辑画廊合集</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>编辑画廊合集</h1>
        </div>
        <div class="divBasic">
            <?php
                session_start();
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $furryUser = $_SESSION['username'];
                if(!$furryUser){echo"<h2>ZZWW 请先登录</h2>";exit;}

                if($editWhat == 2){
                    $collectionId = $_GET['collectionId'];

                    $sql = "select * from collections where id='$collectionId'";
                    $result = mysqli_query($link,$sql);
                    $collections = mysqli_fetch_array($result);
                    $title = $collections['title'];
                    $info = $collections['info'];
                    $cover = $collections['cover'];
                    $creator = $collections['username'];
                    $time = $collections['time'];

                    $editCollection = 1;
                    $delAdd = 2;
                    echo <<<ZHOU
                        <div class="leftSide">
                            <img src="./furrygalleryimg/$cover" alt="$cover" width="100%">
                            <h2>$title</h2>
                            <p>$info</p>
                            <p>$creator</p>
                            $time
                            <form action='runEditCollection.php' method='POST'>
                                <h2>编辑合集信息</h2>
                                <input type="hidden" name="editWhat" value="$editCollection">
                                <input type="hidden" name="collectionId" value="$collectionId">
                                <input type='text' name='title' placeholder='合集标题' value="$title">
                                <textarea type="text" name="info" cols="20" rows="2" placeholder="合集说明">$info</textarea>
                                <input type='text' name='cover' placeholder='合集封面（画廊ID）'>
                                <button type='submit'>修改</button>
                            </form>
                        </div>
                    ZHOU;
    
                    echo "<div class='divSpectial'><div class='divScreen'>";
    
                    $sql = "select * from gallerycollections where collectionId='$collectionId' order by id DESC";
                    $result = mysqli_query($link,$sql);
                    while($gallerycollections = mysqli_fetch_array($result)){
                        $delId = $gallerycollections['Id'];
                        $galleryid = $gallerycollections['galleryid'];
                        $adder = $gallerycollections['username'];
    
                        $sqlGalleay = "select username,title,img from furrygallery where id='$galleryid'";
                        $resultGallery = mysqli_query($link,$sqlGalleay);
                        $furrygallery = mysqli_fetch_array($resultGallery);
                        $username = $furrygallery['username'];
                        $title = $furrygallery['title'];
                        $img = $furrygallery['img'];
                        echo <<<ZHOU
                            <div class='divShow50'>
                                <img src='./furrygalleryimg/$img' alt='$galleryid $username $title $img' width='100%'>
                                <p>$galleryid $username $title</p>
                                <a href='runEditCollection.php?editWhat=$delAdd&delId=$delId&collectionId=$collectionId'>
                                <button onclick="return confirm('确认移除 $username $title ？')">移除</button>
                                </a>
                            </div>
                        ZHOU;
                    }
    
                    echo "</div></div>";    
                }
            ?>
        </div>
    </div>
</body>
</html>