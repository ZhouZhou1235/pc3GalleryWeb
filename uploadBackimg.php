<!DOCTYPE html>
<body>
    <?php
        session_start();
        $username = $_SESSION['username'];
        
        if($username==null){
            die("<h1>ZZWW 获取名称失败</h1>");
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
            
            if(!file_exists('backimg')){
                mkdir('backimg');
            }
            $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$filetype;
            move_uploaded_file($temp_name, 'backimg/'.$new_filename);    
        }
        else{
            die("<h2>ZZWW 未找到上传的背景图片！</h2>");
        }


        $link = mysqli_connect('localhost','ZHOU','10171350','zzww') or die('ZZWW database error');
        $sql = "
        update account set backimg='$new_filename'
        where username='$username'
        ";
        $result = mysqli_query($link,$sql) or die('ZZWW read error');
        echo "
        <script>
            window.location.href='index.php';
        </script>
        "
    ?>
</body>
