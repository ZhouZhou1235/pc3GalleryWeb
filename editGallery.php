<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $homePage = new homePage;
    $gallery = new gallery;
    $userState = new userState;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 编辑画廊</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menu();
        if($num<1){$homePage->entry();exit;}
        $galleryId = $_POST['galleryId'];
        echo $gallery->editGalleryForm($galleryId);
    ?>
</body>
</html>