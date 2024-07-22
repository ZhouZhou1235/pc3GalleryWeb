<!DOCTYPE html>
<?php
session_start();
$username = $_SESSION['username'];
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');

$galleryid = $_POST['galleryid'];
if(!$galleryid){$galleryid = $_GET['galleryid'];}

$sql = "select controlnum from account where username='$username'";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];

$sqlGallery = "select * from furrygallery where id='$galleryid'";
$resultGallery = mysqli_query($link,$sqlGallery);
$resultArrayGallery = mysqli_fetch_array($resultGallery);
$uploader = $resultArrayGallery['username'];

if($username==$uploader || $controlnum==1){
    $editWhat = $_POST['editWhat'];
    if(!$editWhat){$editWhat = $_GET['editWhat'];}
    if($editWhat == 1){
        $title = $_POST['title'];
        $info = $_POST['info'];
        $type = $_POST['type'];
        if($title==null || $type==null){exit('<h1>ZZWW 标题和类型不为空</h1>');}
        $sql = "
        update furrygallery
        set title='$title',info='$info',type='$type'
        where id='$galleryid'
        ";
        $result = mysqli_query($link,$sql);
        echo "<h1>ZZWW 画廊 $galleryid 修改完成</h1>";
        exit;
    }
    else if($editWhat == 2){
        $delTagId = $_GET['delTagId'];
        $sql = "delete from tagsgallery where tagid='$delTagId' and galleryid='$galleryid'";
        $result = mysqli_query($link,$sql);
        echo "<h1>ZZWW 画廊 $galleryid 的标签ID $delTagId 已删除</h1>";
        exit;
    }
}
else{
    $editWhat = $_GET['editWhat'];
    if($editWhat == 2){
        $delTagId = $_GET['delTagId'];
        $sql = "delete from tagsgallery where tagid='$delTagId' and galleryid='$galleryid'";
        $result = mysqli_query($link,$sql);
        echo "<h1>ZZWW 画廊 $galleryid 的标签ID $delTagId 已删除</h1>";
        exit;
    }
}
?>