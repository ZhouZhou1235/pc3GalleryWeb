<?php
// gain todo 1印爪徽章 2解密兽
include "../lib/examineClass.php";
include "../lib/userClass.php";
$userState = new userState;
$userBadges = new userBadges;
$userInput = new userInput;
$num = $userState->checkLogin();
if($num<1){echo"---===ZZWW 非法操作===---\n可能的触发原因：未登录";exit;}
$todo = $_POST['todo'];if(!$todo){$todo=$_GET['todo'];}
$todo = $userInput->inputFilter($todo);
if($todo==1){
    // 印爪！
    $furryUser = $_SESSION["username"];
    $num1 = $userBadges->printClaw($furryUser);
    if($num1<1){echo "<script>alert('印爪！获得条件未达到哦');</script>";}
    echo "<script>window.history.go(-1);</script>";
}
else if($todo==2){
    // 解密兽
    $furryUser = $_SESSION["username"];
    $num1 = $userBadges->jiemi($furryUser);
    if($num1<1){echo "<script>alert('我觉得可能不是这个意思呢......');</script>";echo "<script>window.history.go(-1);</script>";}
    else{echo "<h1>哇，好厉害！成功破译了</h1>";}
}