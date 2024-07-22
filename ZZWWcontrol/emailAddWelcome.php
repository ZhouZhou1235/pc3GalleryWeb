<!DOCTYPE html>
<?php
// ZZWW 自动邮件程序 欢迎

// 导入PHPMailer类
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once '../phpClass/PHPMailer.php';
require_once '../phpClass/SMTP.php';
require_once '../phpClass/Exception.php';

// session会话和连接数据库
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');

// 验证管理兽身份
$username = $_SESSION['username'];
$sql = "
select *
from account
where username='$username'
";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];
if($controlnum!=1){die('非法操作');}

// 获取用户信息
$sayHello = $_POST['sayHello'];
if($sayHello==null){die('获取username失败');}
$sql = "
select *
from account
where username='$sayHello'
";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$username = $resultArray['username'];
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
        </span>
        加入时间>>>$time<br>
        QQ>>>$qq<br>
        QQ无效的账号不能长期保留<br>
    </p>
    <p>
        <span style="color: red;">
        粉糖账号>>>$username<br>
        密码已重置>>>000000<br>
        可以在个兽空间更改信息，别忘记了哦。owo<br>
        </span>
    </p>
    <p style="text-align: right;">
        发件兽 ZZWW邮件程序<br>
        兽工处理 粉糖粒子周周
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
    $mail->addAddress('3551851286@qq.com', 'ZZWWcontrol');

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

?>