<!DOCTYPE html>
<body>
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
        $controlnum = $resultArray['controlnum'];
        $oldQQ = $resultArray['qq'];
        
        if($username==null){
            die("<h1>ZZWW 获取名称失败</h1>");
        }

        $name = $_POST['name'];
        $password = $_POST['password'];
        // 密码哈希加密
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        if(!password_verify($password,$hashedPassword)){exit('ZZWW password hash error');}
        $sex = $_POST['sex'];
        $furrytype = $_POST['furrytype'];
        $signature = $_POST['signature'];
        $qq = $_POST['qq'];


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
            
            if(!file_exists('headimg')){
                mkdir('headimg');
            }
            $new_filename = date('YmdHis',time()).rand(100,1000).'.'.$filetype;
            move_uploaded_file($temp_name, 'headimg/'.$new_filename);    
        }

        $openEdit = $_POST['openEdit'];
        if($controlnum==1 && $openEdit==1){
            $theId = $_POST['theId'];
            $theControlnum = $_POST['theControlnum'];

            $sql = "
            update account set password='$hashedPassword',name='$name',sex='$sex',furrytype='$furrytype',signature='$signature',qq='$qq',controlnum='$theControlnum'
            where id='$theId'
            ";
            $result = mysqli_query($link,$sql) or die('ZZWW read error');
            echo "
            <script>
                window.location.href='ZZWWcontrol.php';
            </script>
            ";
        }
        else{
            if($new_filename){
                $sql = "
                update account set password='$hashedPassword',name='$name',sex='$sex',furrytype='$furrytype',signature='$signature',headimg='$new_filename'
                where username='$username'
                ";    
            }
            else{
                $sql = "
                update account set password='$hashedPassword',name='$name',sex='$sex',furrytype='$furrytype',signature='$signature'
                where username='$username'
                ";    
            }
            $result = mysqli_query($link,$sql) or die('ZZWW read error');
            echo "
            <script>
                window.location.href='index.php';
            </script>
            "; 
        }
    ?>
</body>
