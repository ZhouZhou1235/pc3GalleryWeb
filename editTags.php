<!DOCTYPE html>
<?php
session_start();
$username = $_SESSION['username'];
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$sql = "select controlnum from account where username='$username'";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];
$oldTag = $_POST['oldTag'];
$newTag = $_POST['newTag'];
$type = $_POST['type'];
echo "$controlnum $oldTag $newTag $type";
if($controlnum==1 || $controlnum==2){null;}else{exit('<h1>ZZWW 只有管理兽可以编辑标签哦</h1>');}
if($oldTag!=null && $newTags!=null && $type!=null){null;}else{exit('<h1>ZZWW 输入不为空</h1>');}
$sql = "
update tags
set tag='$newTag',type='$type'
where id='$oldTag'
";
$result = mysqli_query($link,$sql);
echo "ZZWW update done";
?>