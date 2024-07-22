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
        $info = $_POST['info'];
        $type = $_POST['type'];

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
            
            if(!file_exists('furrygalleryimg')){
                mkdir('furrygalleryimg');
            }
            $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$filetype;
            move_uploaded_file($temp_name, 'furrygalleryimg/'.$new_filename);    
        }


        if($title==null||$new_filename==null||$type==null){
            die('<h1>标题、图片、类型都不能为空！</h1>');
        }

        $sql = "
        insert into furrygallery(username,title,info,img,type,claw)
        values('$username','$title','$info','$new_filename','$type',0)
        ";
        $result = mysqli_query($link,$sql) or die('ZZWW write error');
        echo "
        <script>
            window.location.href='furrygallery.php';
        </script>
        ";

        $candynum += 20;
        $sql = "
        update account set candynum='$candynum'
        where id='$id'
        ";
        $result = mysqli_query($link,$sql);

    }
    else{
        echo"<h1>ZZWW 获取名称失败！可能原因：未登录</h1>";
    }
?>