<!DOCTYPE html>
<?php
session_start();
$username = $_SESSION['username'];
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
if($username==null){
    exit("<h2>ZZWW 请先登录</h2>");
}

$tag = $_POST['tag'];
if($tag==null){exit('<h1>ZZWW 标签不能为空</h1>');}

$sql = "
select *
from tags
where tag='$tag' or id='$tag'
";
$result = mysqli_query($link,$sql);
if($result->num_rows==0){exit('<h1>ZZWW 该标签不存在 你可以到标签墙纸创建新标签</h1>');}
$resultArray = mysqli_fetch_array($result);
$tagid = $resultArray['Id'];
$galleryid = $_POST['theWork'];

$sql = "
select *
from tagsgallery
where tagid='$tagid' and galleryid='$galleryid'
";
$result = mysqli_query($link,$sql);
if($result->num_rows>0){exit('<h1>ZZWW 已添加此标签</h1>');}

$sql = "
insert into tagsgallery(tagid,galleryid)
values('$tagid','$galleryid')
";
$result = mysqli_query($link,$sql);

echo "<h1>ZZWW 标签添加成功</h1>";
?>