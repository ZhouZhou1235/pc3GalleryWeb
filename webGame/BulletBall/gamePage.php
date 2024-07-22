<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 打砖块</title>
    <link href="../../fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="../../CSS/style.css?version=<?php echo date('YmdHi');?>">
    <style>
        #canvas1 {
            border: 5px solid black;
            background-color: whitesmoke;
        }
    </style>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="../../index.php"><img src="../../fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>打砖块</h1>
        </div>
        <div class="divBasic">
            <canvas id="canvas1" width="800" height="600">canvas1</canvas>
            <?php
                session_start();
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');

                $username = $_SESSION['username'];
                if($username){
                    echo <<<ZHOU
                        <script src="./gameJS.js" type="text/javascript"></script>
                    ZHOU;
                    $sql = "
                    select *
                    from account
                    where username='$username'
                    ";
                    $result = mysqli_query($link,$sql);
                    $resultArray = mysqli_fetch_array($result);
                    $userId = $resultArray['id'];
            
                    $userScore = $_COOKIE['userScore'];
                    echo "<h1>玩家小兽$username</h1>";
                    if($userScore){
                        $userLives = $_COOKIE['userLives'];
                        if($userScore >= 60){
                            $sql = "
                            insert into bulletball(userid,username,score,lives)
                            values('$userId','$username','$userScore','$userLives')
                            ";
                            $result = mysqli_query($link,$sql);
                            setcookie('userScore',0,time()-1);
                        }
                    };    
                }
                else{
                    echo "<h1>游戏加载失败 原因：未<a href='../../index.php'>登录</h1>";
                }

                $sql = "
                select *
                from bulletball
                order by score DESC
                ";
                $result = mysqli_query($link,$sql);

                echo "
                <div class='divSpectial'>
                <table>
                <thead>
                    <th>玩家小兽</th>
                    <th>得分</th>
                    <th>剩余机会</th>
                    <th>时间</th>
                </thead>
                ";
                while($resultArray = mysqli_fetch_array($result)){
                    $player = $resultArray['username'];
                    $score = $resultArray['score'];
                    $lives = $resultArray['lives'];
                    $time = $resultArray['time'];
                    echo "
                        <tr>
                            <td>$player</td>
                            <td>$score</td>
                            <td>$lives</td>
                            <td>$time</td>
                        </tr>
                    ";
                }
                echo "</table></div>";
            ?>
        </div>
    </div>
</body>
</html>