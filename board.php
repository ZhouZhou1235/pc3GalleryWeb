<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $homePage = new homePage;
    $otherPage = new otherPage;
    $userState = new userState;
    $Statement = new Statement;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 留言板</title>"; $homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menu();
        if($num<1){$homePage->entry();echo $Statement->homePage1();}
        $otherPage->boardForm();
        $otherPage->board();
    ?>
</body>
</html>