<!DOCTYPE html>
<?php
    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
    $sql = "
    select *
    from account
    ";
    $result = mysqli_query($link,$sql);
    $resultArray = mysqli_fetch_array($result);
    session_start();
    $username = $_SESSION['username'];
    if($username!=null){
        $sender = $_SESSION['username'];
        $work_id = $_POST['id'];
        $comment = $_POST['comment'];
        if($comment==null){
            die('<h1>ZZWW 评论不能为空<h1>');
        }
        $type = 'column';
        $sql = "
        insert into comment(sender,work_id,comment,type)
        values('$sender','$work_id','$comment','$type')
        ";
        $result = mysqli_query($link,$sql) or die('ZZWW write error');
        echo "
        <script>
            window.history.go(-1);
        </script>
        ";
    }
    else{
        die("<h1>ZZWW 获取名称失败</h1>");
    }
?>