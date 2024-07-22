<?php
    require_once "./lib/outClass.php";
    require_once "./lib/galleryClass.php";
    require_once "./lib/examineClass.php";
    $gallery = new gallery;
    $homePage = new homePage;
    $userState = new userState;
    $Statement = new Statement;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 上传作品</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menu();
        if($num<1){$homePage->entry();echo $Statement->homePage1();}
        $gallery->uploadForm();
    ?>
</body>
</html>