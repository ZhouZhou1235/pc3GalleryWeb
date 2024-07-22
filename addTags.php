<!DOCTYPE html>
<?php
session_start();
$username = $_SESSION['username'];
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
if($username==null){
    exit("<h2>ZZWW 请先登录</h2>");
}

$tag = $_POST['tag'];
$type = $_POST['type'];
if($tag==null || $type==null){exit('<h1>ZZWW 标签和标签类型都不能为空</h1>');}

$sql = "
select *
from tags
where tag='$tag' and type='$type'
";
$result = mysqli_query($link,$sql);
if($result->num_rows>0){exit('<h1>ZZWW 该标签已存在</h1>');}

$sql = "
insert into tags(tag,type,creator)
values('$tag','$type','$username')
";
$result = mysqli_query($link,$sql);
header('location:tags.php');
?>