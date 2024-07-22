<!DOCTYPE html>
<?php
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
    $oldUsername = $_POST['oldUsername'];
    $newUsername = $_POST['newUsername'];
    echo "$oldUsername $newUsername";

    $sql = "
    select username
    from account
    where username='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);
    if($result->num_rows==0){
        die('<h1>ZZWW 该粉糖账号不存在</h1>');
    }

    $sql = "
    select username
    from account
    where username='$newUsername'
    ";
    $result = mysqli_query($link,$sql);
    if(!is_numeric($newUsername)){
        die('<h1>ZZWW 粉糖账号必须为五位数字</h1>');
    }
    if($result->num_rows>0){
        die('<h1>ZZWW 该粉糖账号已被占用</h1>');
    }

    //更新留言板username
    $sql = "
    update zzwwboard
    set username='$newUsername'
    where username='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);

    //更新图文username
    $sql = "
    update phpcolumn
    set username='$newUsername'
    where username='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);

    //更新画廊username
    $sql = "
    update furrygallery
    set username='$newUsername'
    where username='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);

    //更新评论username
    $sql = "
    update comment
    set sender='$newUsername'
    where sender='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);
    
    //更新星星瓶username
    $sql = "
    update sendcandy
    set sender='$newUsername'
    where sender='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);

    //最后更新account表username
    $sql = "
    update account
    set username='$newUsername'
    where username='$oldUsername'
    ";
    $result = mysqli_query($link,$sql);

    echo "ZZWW update done";
}
?>