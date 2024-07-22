<?php
// edit todo 1编辑个兽信息 2编辑画廊信息
include_once "../lib/userClass.php";
include_once "../lib/galleryClass.php";
include_once "../lib/examineClass.php";
include_once "../lib/outClass.php";
$userInput = new userInput;
$furryArt = new furryArt;
$userAction = new userAction;
$Statement = new Statement;
$todo = $userInput->inputFilter($_POST['todo']);
if($todo==1){
    $num = $userAction->editMyself();
    if($num<1){echo $Statement->edit1();}
    else{header("location:../user.php");}
}
else if($todo==2){
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $num = $furryArt->editGallery($galleryId);
    if($num<1){echo $Statement->edit2();}
    else{header("location:../user.php");}
}