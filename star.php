<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $homePage = new homePage;
    $userState = new userState;
    $otherPage = new otherPage;
    $Statement = new Statement;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 收藏</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menu();
        if($num<1){$homePage->entry();echo $Statement->homePage1();exit;}
        $username = $_GET['username'];if(!$username){$username=$_SESSION['username'];}
        echo $otherPage->showStar($username);
    ?>
</body>
</html>