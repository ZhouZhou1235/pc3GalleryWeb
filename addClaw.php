<!DOCtheType html>
<?php
session_start();
$username = $_SESSION['username'];

if($username==null){
    die('<h1>ZZWW 获取名称失败</h1>');
}

$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$sql = "
select *
from account
where username='$username'
";
$result = mysqli_query($link, $sql);
$resultArray = mysqli_fetch_array($result);
$candynum = $resultArray['candynum'];
if($candynum<=0){
    die('<h1>ZZWW 没有糖果了！>w<</h1>');
}
else{
    $candynum -= 1;
    $sql = "
    update account set candynum='$candynum'
    where username='$username'
    ";
    $result = mysqli_query($link,$sql) or die('ZZWW write error');

    $theType = $_POST['theType'];
    if($theType=='column'){
        $claw = $_POST['claw'];
        $theWork = $_POST['theWork'];
    
        $sql = "
        select phpcolumn.id,phpcolumn.claw
        from phpcolumn
        where phpcolumn.id='$theWork'
        ";
        $result = mysqli_query($link, $sql);
        $resultArray = mysqli_fetch_array($result);
    
        $claw += 1;
        $sql = "
        update phpcolumn set claw='$claw'
        where id='$theWork'
        ";
        $result = mysqli_query($link,$sql) or die('ZZWW write error');
        echo "
        <script>
            window.history.go(-1);
        </script>
        ";    
    }
    else if($theType=='gallery'){
        $claw = $_POST['claw'];
        $theWork = $_POST['theWork'];
    
        $sql = "
        select furrygallery.id,furrygallery.claw
        from furrygallery
        where furrygallery.id='$theWork'
        ";
        $result = mysqli_query($link, $sql);
        $resultArray = mysqli_fetch_array($result);
    
        $claw += 1;
        $sql = "
        update furrygallery set claw='$claw'
        where id='$theWork'
        ";
        $result = mysqli_query($link,$sql) or die('ZZWW write error');
        echo "
        <script>
            window.history.go(-1);
        </script>
        ";
    }
    else{
        die('ZZWW get theType error');
    }
}
?>