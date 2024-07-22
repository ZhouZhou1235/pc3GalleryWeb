<?php
// upload todo 1画廊上传 2发布爪记 3发布帖子
require_once "../lib/examineClass.php";
require_once "../lib/galleryClass.php";
require_once "../lib/userClass.php";
require_once "../lib/outClass.php";
require_once "../lib/postClass.php";
$userState = new userState;
$userInput = new userInput;
$furryArt = new furryArt;
$userAction = new userAction;
$Statement = new Statement;
$furryGargen = new furryGarden();
$num1 = $userState->checkLogin();
$todo = $userInput->inputFilter($_POST['todo']);
if($todo==1){
    $file = $_FILES['file'];
    $title = $userInput->inputFilter($_POST['title']);
    $info = $userInput->inputFilter($_POST['info']);
    $type  = $userInput->inputFilter($_POST['type']);
    $visit = $userInput->inputFilter($_POST['visit']);
    $tags = $userInput->inputFilter($_POST['tags']);
    $num2 = $userInput->checkUploadGallery($file,$title,$type,$visit);
    if($num1+$num2<2){echo $Statement->insert1();exit;}
    $furryArt->upload($file,$title,$info,$type,$visit,$tags);
    header("location:../index.php");
}
else if($todo==2){
    $furryUser = $_SESSION['username'];
    $num2 = $userAction->upload_essay($furryUser);
    if($num1+$num2<2){echo $Statement->insert1();exit;}
    header("location:../user.php");
}
else if($todo==3){
    $furryUser = $_SESSION["username"];
    $num2 = $furryGargen->addNewPost($furryUser);
    if($num1+$num2<2){echo $Statement->insert2();exit;}
    header("location:../addPost.php");
}