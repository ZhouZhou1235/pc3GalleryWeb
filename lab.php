<?php
require_once "./lib/outClass.php";
$homePage = new homePage;
?>
<html lang="zh">
<head>
    <?php echo"<title>粉糖粒子 实验室</title>";$homePage->headPart(); ?>
</head>
<body>
    <?php
        $homePage->menu();
    ?>
    <div class="screen">
            <p>PHP打印杨辉三角</p>
            <?php
                function printYanghuiTriangle(int $row){
                    // PHP 打印杨辉三角
                    if($row==1){echo"1";}
                    else if($row==2){echo"1 1";}
                    else{
                        $line = [1,1];
                        $lastLine = [];
                        echo "1<br>1 1<br>";
                        $i = 3;
                        while($i<=$row){
                            $lastLine = $line;
                            $line = [1];
                            for($j=0;$j<$i-1;$j++){
                                $line[$j+1] += $lastLine[$j]+$lastLine[$j+1];
                            }
                            for($k=0;$k<count($line);$k++){echo $line[$k]." ";}echo"<br>";
                            $i++;
                        }
                    }
                }
                printYanghuiTriangle(10);
            ?>
        </div>
    </div>
</body>
</html>