<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $userZone = new userZone;
    $homePage = new homePage;
    $userState = new userState;
    $Statement = new Statement;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 个兽空间</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num=$userState->checkLogin();
        $homePage->menu();
        $look = $_GET['username'];
        if($num==1 && !$look){
            $furryUser = $_SESSION['username'];
            echo $userZone->myPage();
        }
        else{
            if($num<1){$homePage->entry();echo $Statement->homePage1();}
            if($look){echo $userZone->lookUser($look);}
        }
    ?>
</body>
</html>