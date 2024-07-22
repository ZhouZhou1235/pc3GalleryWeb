<!DOCTYPE html>
<?php
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$furryUser = $_SESSION['username'];
if(!$furryUser){echo"<h2>ZZWW 请先登录</h2>";exit;}

$collectionId = $_POST['collectionId'];
if(!$collectionId){$collectionId = $_GET['collectionId'];}
$editWhat = $_POST['editWhat'];
if(!$editWhat){$editWhat = $_GET['editWhat'];}

if($editWhat == 1){
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
    update collections
    set title='$title',info='$info',cover='$img'
    where id='$collectionId'
    ";
    $result = mysqli_query($link,$sql);
    
    echo "<h1>ZZWW 合集 $collectionId 修改完成</h1>";
    exit;
}
else if($editWhat == 2){
    $delId = $_GET['delId'];
    $sql = "delete from gallerycollections where id='$delId'";
    $result = mysqli_query($link,$sql);
    echo "<h1>ZZWW 已移除</h1>";
}
?>