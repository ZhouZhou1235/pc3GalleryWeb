<?php
// enter todo 1注册 2登录 3注销 4获取重置验证码 5重置密码
include_once "../lib/userClass.php";
include_once "../lib/outClass.php";
include_once "../lib/examineClass.php";
$access = new access;
$Statement = new Statement;
$userInput = new userInput;
$todo = $userInput->inputFilter($_POST['todo']);
if($todo==1){
    $out = $access->register();
    if($out==1){header("location:../index.php");}
    else{echo $Statement->register1();}
}
else if($todo==2){
    $out = $access->login();
    if($out==1){header("location:../index.php");}
    else{echo $Statement->login1();exit;}    
}
else if($todo==3){
    $out = $access->logout();
    if($out==1){header("location:../index.php");}
    else{echo"---===ZZWW 注销失败===---";exit;}
}
else if($todo==4){
    $email = $userInput->inputFilter($_POST["email"]);
    $num = $access->getResetCode($email);
    if($num<1){echo $Statement->login2();exit;}
    header("location:../login.php");
}
else if($todo==5){
    $pendPassword = $userInput->inputFilter($_POST["password"]);
    $resetCode = $userInput->inputFilter($_POST["resetCode"]);
    $num = $access->resetUser($pendPassword,$resetCode);
    if($num<1){echo $Statement->login2();exit;}
    header("location:../login.php");
}
else{echo"ZZWW 非法操作";exit;}