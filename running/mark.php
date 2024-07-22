<?php
// mark todo 1画廊收藏 2关注 3帖子收藏
include_once "../lib/userClass.php";
include_once "../lib/examineClass.php";
include_once "../lib/outClass.php";
$userState = new userState;
$userAction = new userAction;
$Statement = new Statement;
$userAction = new userAction;
$userInput = new userInput;
$num = $userState->checkLogin();
if($num<1){echo $Statement->login3();exit;}
$todo = $_POST['todo'];if(!$todo){$todo=$_GET['todo'];}
$todo = $userInput->inputFilter($todo);
if($todo==1){
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $num1 = $userAction->addStar($galleryId);
    if($num1<1){echo $Statement->login3();}
    else{echo"<script>window.history.go(-1);</script>";}
}
else if($todo==2){
    $username = $userInput->inputFilter($_GET['username']);
    $num1 = $userAction->watchUser($username);
    if($num1<1){echo $Statement->insert5();}
    else{header("location:../user.php?username=$username");}
}
else if($todo==3){
    $postId = $_POST['postId'];
    $num1 = $userAction->addPostStar($postId);
    if($num1<1){echo $Statement->insert5();}
    else{echo"<script>window.history.go(-1);</script>";}
}