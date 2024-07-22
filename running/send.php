<?php
// send todo 1留言板发送 2画廊评论 3添加和贴上标签 4搜索标签 5给爪记印爪 6帖子跟贴 7回复跟帖 8给帖子印爪 9给跟贴印爪
include_once "../lib/userClass.php";
include_once "../lib/examineClass.php";
include_once "../lib/outClass.php";
$userState = new userState;
$userAction = new userAction;
$Statement = new Statement;
$userInput = new userInput;
$dataExist = new dataExist;
$num1 = $userState->checkLogin();
$todo = $_POST['todo'];if(!$todo){$todo=$_GET['todo'];}
$todo = $userInput->inputFilter($todo);
if($todo==1){
    $num2 = $userAction->inputBoard();
    if($num1+$num2<2){echo $Statement->insert1();}
    else{header("location:../board.php");}
}
else if($todo==2){
    $comment = $userInput->inputFilter($_POST['comment']);
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $num2 = $userAction->sendComments($comment,$galleryId);
    if($num1+$num2<2){echo $Statement->insert1();}
    else{header("location:../gallery.php?galleryId=$galleryId");}
}
else if($todo==3){
    $galleryId = $userInput->inputFilter($_POST['galleryId']);
    $tags = $userInput->inputFilter($_POST['tags']);
    $num2 = $dataExist->checkGalleryExist($galleryId);
    if($num1+$num2<2){echo $Statement->insert1();exit;}
    $num3 = $userAction->addTagsAndConnect($tags,$galleryId);
    if($num1+$num2+$num3<3){echo $Statement->insert1();}
    else{header("location:../tags.php");}
}
else if($todo==4){
    $search = $userInput->inputFilter($_POST['search']);
    $userAction->searchTagsAndShow($search);
}
else if($todo==5){
    $username = $_SESSION['username'];
    $essayId = $userInput->inputFilter($_GET['essayId']);
    if($num1<1){echo $Statement->ok1();exit;}
    $num2 = $userAction->addPaw_essay($username,$essayId);
    if($num2<1){echo $Statement->ok1();exit;}
    else{echo"<script>window.history.go(-1)</script>";}
}
else if($todo==6){
    $furryUser = $_SESSION['username'];
    $postId = $_POST['postId'];
    $num2 = $userAction->commentToPost($furryUser,$postId);
    if($num1+$num2<2){echo $Statement->insert3();}
    else{header("location:../posts.php?postId=$postId");}
}
else if($todo==7){
    $furryUser = $_SESSION['username'];
    $postId = $_POST['postId'];
    $num2 = $userAction->replyPostComment($furryUser,$postId);
    if($num1+$num2<2){echo $Statement->insert4();}
    else{header("location:../posts.php?postId=$postId");}
}
else if($todo==8){
    $furryUser = $_SESSION["username"];
    $postId = $_GET['postId'];
    $num2 = $userAction->addPaw_post($furryUser,$postId);
    if($num1+$num2<2){echo $Statement->ok1();}
    else{header("location:../posts.php?postId=$postId");}
}
else if($todo==9){
    $furryUser = $_SESSION["username"];
    $commentId = $_GET["commentId"];
    $postId = $_GET['postId'];
    $num2 = $userAction->addPaw_postComment($furryUser,$commentId);
    if($num1+$num2<2){echo $Statement->ok1();}
    else{header("location:../posts.php?postId=$postId");}
}
else if(!$todo){
    $preSearch = $userInput->inputFilter($_POST['preSearch']);
    $userAction->preSearchTags($preSearch);
}