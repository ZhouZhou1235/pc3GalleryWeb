<?php
    require_once "./lib/outClass.php";
    require_once "./lib/examineClass.php";
    $homePage = new homePage;
    $userState = new userState;
    $Statement = new Statement;
    $Posts = new Posts();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 发布帖子</title>";$homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $num = $userState->checkLogin();
        $homePage->menu();
        if($num<1){$homePage->entry();echo $Statement->homePage1();}
        echo $Posts->posts_addForm();
    ?>
</body>
</html>