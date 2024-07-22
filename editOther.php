<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $homePage = new homePage;
    $userState = new userState;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 编辑其它</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menuFull();
        if($num<1){$homePage->entry();exit;}
        $userZone = new userZone;
        $userZone->editOtherPage();
    ?>
</body>
</html>