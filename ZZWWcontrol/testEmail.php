<!DOCTYPE html>
<?php
// 总管理兽操作 谨慎执行
// ZZWW 自动邮件程序 功能测试

// 导入PHPMailer类
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once '../phpClass/PHPMailer.php';
require_once '../phpClass/SMTP.php';
require_once '../phpClass/Exception.php';

// session会话 验证管理兽身份
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$username = $_SESSION['username'];
$sql = "
select *
from account
where username='$username'
";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];

// 设置邮件内容
$emailContent = <<<ZHOU
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1>总管理兽$username</h1>
    <p>继续开发粉糖粒子！</p>
</body>
</html>
ZHOU;

// 开始执行
$mail = new PHPMailer(true);
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
    $mail->addAddress('3551851286@qq.com', 'furryUser');

    $mail->isHTML(true);
    $mail->Subject = '-=粉糖粒子网站邮件=-';
    $mail->Body = $emailContent;
    $mail->AltBody = 'plain-text';
    if($controlnum==1){
        $mail->send();
    }
    else{
        exit('exit');
    }
    echo 'ZZWW email send success';
}
catch(Exception $e){
    echo "ZZWW email error {$mail->ErrorInfo}";
}

?>