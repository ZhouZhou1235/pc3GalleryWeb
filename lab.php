<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 实验室</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW 实验室-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>实验室</h1>
            <table>
                <tr>
                    <td><a href="./zzwwOld/index.php">旧版</a></td>
                    <td><a href="./cssPreview/cssDefault.html">默认主题</a></td>
                    <td><a href="./cssPreview/pinkCandyEmail.html">邮件样式</a></td>
                    <td><a href="./bigclock.html">🕙超大时钟</a></td>                    
                </tr>
            </table>
            <div class="divContent">
                <div class="divTitle"><h2>Web游戏开发</h2></div>
                <a href="./webGame/DodgeBlocks/DodgeBlocks.html">🕹️躲避方块</a>
                <h2>躲避方块</h2>
                <p>介绍</p>
                ZHOUZHOU独立开发的第一款Web游戏，躲避从中央冒出的混沌方块，吃到一定数量的奖励即可过关。<br>
                <p>操作教程</p>
                使用键盘WASD或方向键操作<br>
                <p>计算机语言 JavaScript</p>
                2024.1<br>
                <a href="./webGame/BulletBall/gamePage.php">🕹️打砖块</a>
                <h2>打砖块</h2>
                <p>介绍</p>
                复古经典游戏，键盘或鼠标控制挡板反弹弹珠以撞碎上方的砖块。<br>
                五次机会<br>
                球变色速度变快！<br>
                接住球以后速度也会变快！太快会适当减慢速度重新加速！<br>
                <p>操作教程</p>
                使用鼠标或键盘左右方向键操作<br>
                <p>计算机语言 JavaScript</p>
                2024.2<br>
            </div>
            <div class="divContent">
                <div class="divTitle"><h2>主题</h2></div>
                <a href="./cssPreview/cssDefault.html">默认</a>
                <a href="./cssPreview/cssNewYear.html">新年</a>
            </div>
            <div class="divContent">
                <a href="test.php">php test</a>
                <form action="test.php" method="POST">
                    <input type="text" name="password">
                    <button type="submit">提交</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>