<?php
    require_once "./lib/examineClass.php";
    require_once "./lib/outClass.php";
    require_once "./lib/adminClass.php";
    $userState = new userState;
    $homePage = new homePage;
    $chiefAdmin = new chiefAdmin;
    $Statement = new Statement;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 管理兽</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num1 = $userState->checkLogin();
        $homePage->menu();
        if($num1<1){$homePage->entry();exit;}
        $num2 = $chiefAdmin->checkIdentity();
        if($num2<1){echo $Statement->admin1();exit;}
        echo $chiefAdmin->outUserControl();
        echo $chiefAdmin->outGalleryControl();
        echo $chiefAdmin->outBadgeControl();
    ?>
</body>
</html>