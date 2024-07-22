<?php
// control todo 
/*
1管理兽修改画廊 2管理兽覆盖上传图片 3创建徽章 4创建特殊徽章 5给予小兽徽章
6撤下小兽徽章 7删除徽章 8更改徽章名称 9补偿小兽金币 10向小兽发送邮件
11 自定义发送邮件
*/
include_once "../lib/examineClass.php";
include_once "../lib/adminClass.php";
$userState = new userState;
$chiefAdmin = new chiefAdmin;
$userInput = new userInput;
$num = $userState->checkLogin();
if($num<1){echo"---===ZZWW 非法操作===---\n可能的触发原因：未登录";exit;}
$todo = $_POST['todo'];if(!$todo){$todo=$_GET['todo'];}
$todo = $userInput->inputFilter($todo);
if($todo==1){
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $num1 = $chiefAdmin->editGallery($galleryId);
    if($num1<1){echo"---===ZZWW 非法操作===---\n可能的触发原因：非管理兽 填写不完整 找不到画廊";}
    else{header("location:../admin.php");}
}
else if($todo==2){
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $file = $_FILES['file'];
    $num1 = $chiefAdmin->reUploadGallery($galleryId,$file);
    if($num1<1){echo"---===ZZWW 非法操作===---\n可能的触发原因：非管理兽 图片不支持 找不到画廊";}
    else{header("location:../admin.php");}
}
else if($todo==3){
    $badge = $userInput->inputFilter($_POST["badge"]);
    $type = $userInput->inputFilter($_POST["type"]);
    $num1 = $chiefAdmin->addBadge($badge,$type);
    if($num1<1){echo"---===ZZWW 创建失败===---\n可能的触发原因：徽章号码冲突 徽章不完整";}
    else{header("location:../admin.php");}
}
else if($todo==4){
    $badge = $userInput->inputFilter($_POST["badge"]);
    $type = "spectial";
    $num1 = $chiefAdmin->addBadge($badge,$type);
    if($num1<1){echo"---===ZZWW 创建失败===---\n可能的触发原因：徽章号码冲突 徽章不完整";}
    else{header("location:../admin.php");}
}
else if($todo==5){
    $username = $userInput->inputFilter($_POST["username"]);
    $code = $userInput->inputFilter($_POST["code"]);
    $num1 = $chiefAdmin->giveBadge($username,$code);
    if($num1<1){echo"PINKCANDY给予失败 可能的触发原因：$username 已拥有徽章 $code ，找不到用户，信息不完整";}
    else{header("location:../admin.php");}
}
else if($todo==6){
    $username = $userInput->inputFilter($_POST["username"]);
    $code = $userInput->inputFilter($_POST["code"]);
    $num1 = $chiefAdmin->backBadge($username,$code);
    if($num1<1){echo"PINKCANDY撤下失败";}
    else{header("location:../admin.php");}
}
else if($todo==7){
    $username = $_SESSION["username"];
    $code = $userInput->inputFilter($_POST["code"]);
    $num1 = $chiefAdmin->delBadge($username,$code);
    if($num1<1){echo"PINKCANDY 删除失败";}
    else{header("location:../admin.php");}
}
else if($todo==8){
    $username = $_SESSION["username"];
    $code = $userInput->inputFilter($_POST["code"]);
    $badgeName = $userInput->inputFilter($_POST["badgeName"]);
    $num1 = $chiefAdmin->renameBadge($username,$code,$badgeName);
    if($num1<1){echo"PINKCANDY 更改失败";}
    else{header("location:../admin.php");}
}
else if($todo==9){
    $username = $userInput->inputFilter($_POST["username"]);
    $coin = $userInput->inputFilter($_POST["coin"]);
    $num1 = $chiefAdmin->compensateCoin($username,$coin);
    if($num1<1){echo"PINKCANDY 补偿失败";}
    else{header("location:../admin.php");}
}
else if($todo==10){
    $adminUser = $_SESSION["username"];
    $username = $_POST["username"];
    $outStr = $chiefAdmin->sendEmailForUser($adminUser,$username);
    echo $outStr;
}
else if($todo==11){
    $adminUser = $_SESSION["username"];
    $email = $_POST["email"];
    $outStr = $chiefAdmin->customizeSendEmail($adminUser,$email);
    echo $outStr;
}