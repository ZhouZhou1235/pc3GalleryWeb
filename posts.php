<?php
    require_once "./lib/examineClass.php";
    require_once "./lib/outClass.php";
    $userState = new userState;
    $homePage = new homePage;
    $Posts = new Posts();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 小兽花园</title>"; $homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menu();
        if($num<1){$homePage->entry();}else{$homePage->furryUser();}
        $look = $_GET['postId'];
        if($look){echo $Posts->showPost($look);}
    ?>
</body>
</html>