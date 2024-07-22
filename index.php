<?php
    require_once "./lib/examineClass.php";
    require_once "./lib/outClass.php";
    require_once "./lib/adminClass.php";
    $userState = new userState;
    $homePage = new homePage;
    $chiefAdmin = new chiefAdmin;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php $homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        // 检查登录
        $num1 = $userState->checkLogin();
        $homePage->menu(); // 导航栏
        if($num1<1){$homePage->entry();}else{$homePage->furryUser();}
        // 管理兽
        $num2 = $chiefAdmin->checkIdentity();if($num2==1){$chiefAdmin->entry();}
        // 首页主体
        echo $homePage->mainHomePage();
    ?>
</body>
</html>