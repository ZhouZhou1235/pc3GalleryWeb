<!DOCTYPE html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once './phpClass/PHPMailer.php';
require_once './phpClass/SMTP.php';
require_once './phpClass/Exception.php';

$link = mysqli_connect('localhost','ZHOU','10171350','zzww') or die('ZZWW database error');

session_start();

$end = $_GET['end'];
if($end==1){session_unset();header('location:index.php');exit;}

$username = $_POST['username'];
$qq = $_SESSION['qq'];

$sql = "
select username
from account
where username='$username'
";
$result = mysqli_query($link,$sql);
if(!is_numeric($username)){
    die('<h1>ZZWW 粉糖账号必须为五位数字！</h1>');
}
if($result->num_rows>0){
    die('<h1>ZZWW 该粉糖账号已被占用，请重新注册！</h1>');
}

$password = $_POST['password'];
$name = $_POST['name'];
$sex = $_POST['sex'];
$furrytype = $_POST['furrytype'];
$signature = $_POST['signature'];

$checkNum = $_POST['checkNum'];
$rightNum = $_SESSION['checkNum'];
if($checkNum!=$rightNum){echo"<h1>ZZWW 验证码错误</h1>";exit;}

if(!$name){$name = $username;};

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
// 密码哈希加密
$hashedPassword = password_hash($password,PASSWORD_DEFAULT);
if(!password_verify($password,$hashedPassword)){exit('ZZWW password hash error');}
if($username!=null && $hashedPassword!=null && $qq!=null){
    $sql = "
    insert into account(username,password,name,sex,furrytype,headimg,signature,qq,controlnum,starnum,candynum)
    values('$username','$hashedPassword','$name','$sex','$furrytype','$new_filename','$signature','$qq',0,0,100)
    ";
    $result = mysqli_query($link,$sql) or die('ZZWW read error');
}
else{
    echo "$username $password $hashedPassword $name $sex $furrytype $new_filename $signature $qq";
    die('ZZWW write error');
}
{
    // 获取用户信息
    $sql = "
    select *
    from account
    where username='$username'
    ";
    $result = mysqli_query($link,$sql);
    $resultArray = mysqli_fetch_array($result);
    $username = $resultArray['username'];
    $hashedPassword = $resultArray['password'];
    $name = $resultArray['name'];
    $time = $resultArray['jointime'];
    $qq = $resultArray['qq'];
    if($name==null){$name = $username;}

    // 设置邮件内容
    $emailContent = <<<ZHOU
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <h1 style="color: pink;">粉糖粒子网站邮件</h1>
        <h1>欢迎加入ZZWW</h1>
        <h2>小兽 $name</h2>
        <p>
            这里是粉糖粒子，站长周周创建的一个小众幻想动物图片站。<br>
            你可以发布或自由浏览留言板、图文专栏和画廊等板块，<br>
            该网站非盈利目的，让我们堆积更多好看的毛绒绒吧！<br>
        </p>
        <p>
            请确认和记住你的账号信息<br>
            <span style="color: red;">
            粉糖账号>>>$username<br>
            密码>>>$password<br>
            </span>
            加入时间>>>$time<br>
            QQ>>>$qq<br>
            QQ无效的账号不能长期保留<br>
        </p>
        <p style="text-align: right;">
            发件兽 ZZWW邮件程序
        </p>
    </body>
    </html>
    ZHOU;

    // 开始执行
    $mail = new PHPMailer(true);
    $furryUserQQ = "$qq@qq.com";
    try{
        // SMTP服务器
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->isSMTP();

        // 发送终端
        $mail->Host = 'smtp.qq.com';
        $mail->Username = '1479499289@qq.com';
        $mail->Password = 'vekwlolkzqztibag';
        $mail->Port = 465;

        // 邮件传输
        $mail->setFrom('1479499289@qq.com', 'ZZWWpinkcandy');
        $mail->addAddress($furryUserQQ, 'furryUser');
        $mail->addAddress('3551851286@qq.com', 'ZZWW');

        $mail->isHTML(true);
        $mail->Subject = '-=粉糖粒子网站邮件=-';
        $mail->Body = $emailContent;
        $mail->AltBody = 'plain-text';

        // 发送
        $mail->send();
        echo 'ZZWW email send success';
    }
    catch(Exception $e){
        echo "ZZWW email error {$mail->ErrorInfo}";
    }
    echo "
    <script>
        window.location.href='index.php';
    </script>
    ";
}
?>
