<?php
// delete todo 1删除留言 2删除评论 3取消画廊收藏 4撕下标签 5取消关注 6删除爪记 7取消帖子收藏
include_once "../lib/userClass.php";
include_once "../lib/examineClass.php";
include_once "../lib/outClass.php";
$userAction = new userAction;
$userState = new userState;
$Statement = new Statement;
$dataExist = new dataExist;
$userInput = new userInput;
$num = $userState->checkLogin();
if($num<1){echo"---===ZZWW 非法操作===---\n可能的触发原因：未登录";exit;}
$todo = $_POST['todo'];if(!$todo){$todo=$_GET['todo'];}
$todo = $userInput->inputFilter($todo);
if($todo==1){
    $boardId = $userInput->inputFilter($_POST['boardId']);
    $num1 = $userAction->delMessage($boardId);
    if($num1<1){echo $Statement->delete1();}
    else{header("location:../editOther.php");}
}
else if($todo==2){
    $commentId = $userInput->inputFilter($_POST['commentId']);
    $num1 = $userAction->delComments($commentId);
    if($num1<1){echo $Statement->delete1();}
    else{header("location:../editOther.php");}
}
else if($todo==3){
    $starId = $userInput->inputFilter($_POST['starId']);
    $num1 = $userAction->delStar($starId);
    if($num1<1){echo $Statement->delete1();}
    else{echo"<script>window.history.go(-1);</script>";}
}
else if($todo==4){
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $tags = $userInput->inputFilter($_POST['tags']);
    $num1 = $dataExist->checkGalleryExist($galleryId);
    if($num1<1){echo"---===ZZWW 找不到ID为 $galleryId 画廊===---";exit;}
    $num2 = $userAction->delConnect($tags,$galleryId);
    if($num1+$num2<2){echo $Statement->delete1();exit;}
    else{header("location:../tags.php");}
}
else if($todo==5){
    $username = $userInput->inputFilter($_GET['username']);
    $num1 = $userAction->unWatch($username);
    if($num1<1){echo $Statement->delete1();exit;}
    else{header("location:../user.php?username=$username");}
}
else if($todo==6){
    $essayId = $userInput->inputFilter($_POST['essayId']);
    $num1 = $userAction->delEssay($essayId);
    if($num1<1){echo $Statement->delete1();exit;}
    header("location:../user.php");
}
else if($todo==7){
    $postId = $_POST['postId'];
    $furryUser = $_POST['username'];
    $num1 = $userAction->delPostStar($furryUser,$postId);
    if($num1<1){echo $Statement->delete1();exit;}
    header("location:../star.php");
}