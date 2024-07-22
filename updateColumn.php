<!DOCTYPE html>
<?php
    session_start();
    $username = $_SESSION['username'];

    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
    $sql = "
    select *
    from account
    where username='$username'
    ";
    $result = mysqli_query($link,$sql);
    $resultArray = mysqli_fetch_array($result);
    $id = $resultArray['Id'];
    $candynum = $resultArray['candynum'];

    if($username!=null){
        $title = $_POST['title'];
        $content = $_POST['content'];
        if($content==null||$title==null){
            die('<h1>标题和内容都不能为空！</h1>');
        }


        header("content-type:text/html;charset=utf-8");
        date_default_timezone_set('PRC');
        
        $filename = $_FILES['file']['name'];
        if($filename!=null){
            $size = $_FILES['file']['size'];
            $temp_name = $_FILES['file']['tmp_name'];
            
            if ($size>5*1024*1024){
                echo "<script>alert('ZZWW 图片不超过5M大小！');window.history.go(-1);</script>";
                exit();
            }
            $fileArray = pathinfo($filename);
            $filetype = $fileArray['extension'];
            
            $allowtype = array('jpg','gif','jpeg','png');
            if(!in_array($filetype, $allowtype)){
                echo "<script>alert('图片仅支持JPG GIF JPEG PNG');window.history.go(-1);</script>";
                exit();
            }
            
            if(!file_exists('phpcolumnimg')){
                mkdir('phpcolumnimg');
            }
            $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$filetype;
            move_uploaded_file($temp_name, 'phpcolumnimg/'.$new_filename);    
        }


        $sql = "
        insert into phpcolumn(username,title,content,img,claw)
        values('$username','$title','$content','$new_filename',0)
        ";
        $result = mysqli_query($link,$sql) or die('ZZWW write error');

        $candynum += 10;
        $sql = "
        update account set candynum='$candynum'
        where id='$id'
        ";
        $result = mysqli_query($link,$sql);

        echo "
        <script>
            window.location.href='phpcolumn.php';
        </script>
        ";
    }
    else{
        echo"<h1>ZZWW 获取名称失败！可能原因：未登录</h1>";
    }
?>