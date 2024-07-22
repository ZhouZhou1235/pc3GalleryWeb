<!DOCTYPE html>
<?php
// 总管理兽操作 谨慎执行
// 将account表的username值复制到name值
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$username = $_SESSION['username'];
$sql = "
select *
from account
where username='$username'
";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];

if($controlnum==1){
    $sql = "
    select username
    from account
    ";
    $result = mysqli_query($link,$sql);
    while($resultArray = mysqli_fetch_array($result)){
        $username = $resultArray['username'];
        $name = $username;
        $sql2 = "
        update account
        set name='$name'
        where username='$username'
        ";
        $result2 = mysqli_query($link,$sql2);    
    }
    echo "ZZWW update done";
}
?>