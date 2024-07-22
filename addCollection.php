<!DOCTYPE html>
<?php
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$furryUser = $_SESSION['username'];
if(!$furryUser){echo"<h2>ZZWW 请先登录</h2>";exit;}

$title = $_POST['title'];
$info = $_POST['info'];
$cover = $_POST['cover'];
if($title!=null && $cover!=null){null;}else{echo"<h1>ZZWW 标题和封面（画廊ID）不为空</h1>";exit;}

$sql = "select img from furrygallery where id='$cover'";
$result = mysqli_query($link,$sql);
if($result->num_rows==0){echo"<h1>ZZWW 找不到画廊ID为 $cover 的作品</h1>";exit;}
$furrygallery = mysqli_fetch_array($result);
$img = $furrygallery['img'];

$sql = "
insert into collections(title,info,cover,username)
values('$title','$info','$img','$furryUser')
";
$result = mysqli_query($link,$sql);

header("location:collection.php");
?>