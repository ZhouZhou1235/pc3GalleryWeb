<!DOCTYPE html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once './phpClass/PHPMailer.php';
require_once './phpClass/SMTP.php';
require_once './phpClass/Exception.php';

session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww') or die('ZZWW database error');

$qq = $_POST['qq'];
// 检查qq
$sql = "
select qq
from account
where qq='$qq'
";
$result = mysqli_query($link,$sql);
if(!is_numeric($qq)){
    die('<h1>ZZWW qq必须为数字！</h1>');
}
if($result->num_rows>0){
    die('<h1>ZZWW 一个qq对应一个粉糖账号，请重新注册！若存在qq被他兽使用请联系总管理兽pinkcandyzhou@qq.com</h1>');
}
$_SESSION['qq'] = $qq;

if($_SESSION['checkNum']==null){$checkNum = random_int(1000,9999);$_SESSION['checkNum'] = $checkNum;}
else{echo"<h1>ZZWW 本次网络会话结束前不能重复发送验证码</h1>";exit;}

// 设置邮件内容
$emailContent = <<<ZHOU
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <h1 style="color: pink;">粉糖粒子网站邮件</h1>
    <h2>正在使用QQ $qq 尝试注册粉糖账号</h2>
    <p>
        <span style="color: red;">
        验证码>>>$checkNum<br>
        </span>
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

    $mail->isHTML(true);
    $mail->Subject = '-=ZZWW注册验证码=-';
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
    alert('ZZWW 验证码发送成功 QQ邮箱注意接收');
    window.history.go(-1);
</script>
";
?>