<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $homePage = new homePage;
    $userState = new userState;
    $gallery = new gallery;
    $Statement = new Statement;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 画廊</title>"; $homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menuFull();
        if($num<1){$homePage->entry();echo $Statement->homePage1();}
        $galleryId = $_GET['galleryId'];
        if(!$galleryId){echo $Statement->show1();}
        echo $gallery->showGallery($galleryId);
    ?>
</body>
</html>