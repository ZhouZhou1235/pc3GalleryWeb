<?php
    require_once "./lib/outClass.php";
    $homePage = new homePage;
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 登录</title>"; $homePage->headPart(); ?>
</head>
<body>
    <!-- PINKCANDY -->
    <?php
        $homePage->menuFull();
        $homePage->login();
    ?>
</body>
</html>