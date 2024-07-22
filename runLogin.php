<!DOCTYPE html>
<body>
    <?php
        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "
        select username,password
        from account
        where username='$username'
        ";
        $result = mysqli_query($link,$sql);
        $resultArray = mysqli_fetch_array($result);
        $hashedPassword = $resultArray['password'];
        if(password_verify($password,$hashedPassword)){
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            header("location: index.php");
            }
        else{
            echo "
            <script>
                alert('登录失败！请检查账号和密码');
                window.location.href='index.php';
            </script>
            ";
            exit;
        }
    ?>
</body>
