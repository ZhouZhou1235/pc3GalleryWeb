<?php
namespace {
    // PHPMailer类库 https://github.com/PHPMailer/PHPMailer/
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $emailHost = "smtp.qq.com";
    $emailUsername = "1479499289@qq.com";
    $emailEnterPassword = "";
    $emailPort = "465";
    $defaultSenderName = "PINKCANDY EMAIL";
    $defaultSenderSubject = "粉糖粒子邮件";
    $emailList = array($emailHost,$emailUsername,$emailEnterPassword,$emailPort,$defaultSenderName,$defaultSenderSubject);
    require_once "dbClass.php";
    class chiefAdmin {
        // 总管理兽
        function checkIdentity(){
            // 检查总管理兽身份
            $furryUser = $_SESSION['username'];
            global $link;
            // 定义有总管理兽徽章的小兽为总管理兽 徽章号10000
            $sql = "select * from badges_account where code='10000' and username='$furryUser' and approve='10000'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
        function editGallery($galleryId){
            // 管理兽编辑画廊
            global $link;
            $title=$_POST['title'];$info=$_POST['info'];$type=$_POST['type'];$visit=$_POST['visit'];
            $userInput = new userInput;
            $dataExist = new dataExist;
            $num1 = $this->checkIdentity();
            $num2 = $userInput->checkEditGallery($title,$type,$visit);
            $num3 = $dataExist->checkGalleryExist($galleryId);
            if($num1+$num2+$num3<3){return 0;}
            $sql = "update gallery set title='$title',info='$info',type='$type',visit='$visit' where id='$galleryId'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function reUploadGallery($galleryId,$file){
            // 管理兽覆盖上传画廊
            require_once "galleryClass.php";
            global $link;
            $dataExist = new dataExist;
            $furryArt = new furryArt;
            $num1 = $this->checkIdentity();
            $num2 = $dataExist->checkGalleryExist($galleryId);
            {
                if($num1+$num2<2){return 0;}if(empty($file)){return 0;}
                $fileName=$file['name'];$fileSize=$file['size'];
                $fileArray = pathinfo($fileName);$fileType = $fileArray['extension'];
                $allowType = array('jpg','gif','jpeg','png');
                if($fileSize>5*1024*1024){return 0;}
                if(!in_array($fileType,$allowType)){return 0;}
            }
            {
                $sql = "select * from gallery where id='$galleryId'";
                $result = mysqli_query($link,$sql);
                $gallery = mysqli_fetch_array($result);
                $oldFile = $gallery['file'];$username = $gallery['username'];
                $url_gallery = "../gallery/$username/$oldFile";
                $url_thumbnail = "../galleryThumbnail/$username/$oldFile";
                unlink($url_gallery);unlink($url_thumbnail);
            }
            {
                $fileName=$file['name'];$tempName=$file['tmp_name'];
                $fileArray = pathinfo($fileName);$fileType = $fileArray['extension'];
                $furryUser = $_SESSION['username'];
                $newFileName = $furryUser."reupload"."-".date('YmdHis',time())."-".rand(1,100).".".$fileType;
                $sql = "update gallery set file='$newFileName' where id='$galleryId'";
                $result = mysqli_query($link,$sql);$result->num_rows;
                if(!file_exists("../gallery")){mkdir("../gallery");}
                if(!file_exists("../gallery/$username")){mkdir("../gallery/$username");}
                move_uploaded_file($tempName,"../gallery/$username/".$newFileName);
                $furryArt->compress("../gallery/$username/".$newFileName,$newFileName,$username);
            }
            return 1;
        }
        function outUserControl(){
            // 显示小兽控制表单
            $url = "./resource/template/userControl.html";
            $outStr = file_get_contents($url);
            return $outStr;
        }
        function outGalleryControl(){
            // 显示画廊控制表单
            $url = "./resource/template/galleryControl.html";
            $outStr = file_get_contents($url);
            return $outStr;
        }
        function entry(){
            // 管理界面入口
            echo "
                <div class='screen'>
                    <div class='userBoxIndex'>
                        <a href='admin.php'>进入管理兽控制页面</a>
                    </div>
                </div>
            ";
            return;
        }
        function outBadgeControl(){
            // 显示徽章管理
            global $link;
            include_once "outClass.php";
            $userZone = new userZone;
            $url = "./resource/template/badgeControl.html";
            $outStr = file_get_contents($url);
            $sql = "select * from badges order by id DESC";
            $result = mysqli_query($link,$sql);
            $outStr = $outStr."<div class='screen'><div class='txtBox'><table><tr><td>徽章号码</td><td>徽章</td><td>类型</td><td>时间</td></tr>";
            while($badges = mysqli_fetch_array($result)){
                $code = $badges["code"];
                $badge = $badges["badge"];
                $type = $badges["type"];
                $theBadge = $userZone->outBadge($badge,$type);
                $outType = $userZone->outBadgeType($type);
                $time = $badges["time"];
                $addStr = <<<EOF
                    <tr>
                        <td>$code</td>
                        <td>$theBadge</td>
                        <td>$outType</td>
                        <td>$time</td>
                    </tr>
                EOF;
                $outStr = $outStr.$addStr;
            }
            $outStr = $outStr."</table></div></div>";
            return $outStr;
        }
        function addBadge($badge,$type){
            // 创建新徽章
            $dataExist = new dataExist;
            $num1 = $this->checkIdentity();
            global $link;
            if($type == "spectial"){
                $code = random_int(10000,99999);
                $num2 = $dataExist->checkBadge($code);
                if($num1<1 || $num2>0 || !$badge){return 0;}
                $sql = "insert into badges(code,badge,type) values('$code','$badge','$type')";
                $result = mysqli_query($link,$sql);$result->num_rows;
                return 1;
            }else{
                $code = random_int(100000,999999);
                $num2 = $dataExist->checkBadge($code);
                if($num1<1 || $num2>0 || !$badge || !$type){return 0;}
                $sql = "insert into badges(code,badge,type) values('$code','$badge','$type')";
                $result = mysqli_query($link,$sql);$result->num_rows;
                return 1;
            }
        }
        function giveBadge($username,$code){
            // 给予徽章
            $furryUser = $_SESSION["username"];
            $dataExist = new dataExist;
            global $link;
            $num1 = $this->checkIdentity();
            $num2 = $dataExist->checkUsername($username);
            $num3 = $dataExist->checkBadge($code);
            $num4 = $dataExist->avoidGiveBadgeRepeat($code,$username);
            if($num1+$num2+$num3+$num4<4){return 0;}
            $sql = "insert into badges_account(code,username,approve) values('$code','$username','$furryUser')";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function backBadge($username,$code){
            // 撤下徽章
            global $link;
            $num1 = $this->checkIdentity();
            if($num1<1){return 0;}
            $sql = "delete from badges_account where username='$username' and code='$code'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function delBadge($username,$code){
            // 删除徽章
            $dbTable = new dbTable;
            $num1 = $this->checkIdentity();
            if($num1<1){return 0;} // 检查管理员身份
            if(!is_numeric($code)){return 0;} // code是数字
            $dbTable->db_delBadge($code);
            return 1;
        }
        function renameBadge($username,$code,$badgeName){
            // 更改徽章名称
            $dbTable = new dbTable;
            $num1 = $this->checkIdentity();
            if($num1<1){return 0;} // 检查管理员身份
            if(!is_numeric($code) || !$badgeName){return 0;} // code是数字 名称不为空
            $dbTable->db_renameBadge($code,$badgeName);
            return 1;
        }
        function compensateCoin($username,$coin){
            // 补偿金币
            $dbTable = new dbTable;
            $num1 = $this->checkIdentity();
            if($num1<1){return 0;}
            if(!is_numeric($coin) || !$username){return 0;}
            $dbTable->db_compensateCoin($username,$coin);
            return 1;
        }
        function sendEmailForUser($adminUser,$receiver){
            // 向小兽发送邮件
            global $emailList;
            $emailHost = $emailList[0];
            $emailUsername = $emailList[1];
            $emailEnterPassword = $emailList[2];
            $emailPort = $emailList[3];
            $defaultSenderName = $emailList[4];
            $defaultSenderSubject = $emailList[5];
            include_once "../externalLib/PHPMailer.php";
            include_once "../externalLib/Exception.php";
            include_once "../externalLib/SMTP.php";
            include_once "examineClass.php";
            $mail = new PHPMailer(true);
            $selectData = new selectData;
            $dataExist = new dataExist;
            $adminUserList = $selectData->get_name($adminUser,2);
            $adminName=$adminUserList[0];$adminSex=$adminUserList[2];$adminSort=$adminUserList[3];
            $userList = $selectData->get_name($receiver,2);
            $name=$userList[0];$sex=$userList[2];$sort=$userList[3];$receiverEmail=$userList[4];
            $title = $_POST["title"];
            $content = $_POST["content"];
            $extra = $_POST["extra"];
            $num1 = $dataExist->checkUsername($receiver);
            if(!$title || !$content || $num1<1){return 0;}
            $css = file_get_contents("../css/SSB_pinkcandy.css");
            $time = date('Y-m-d');
            $emailContent = <<<EOF
                <!DOCTYPE html>
                <html lang="zh">
                <head>
                    <meta charset="UTF-8">
                    <title>PINKCANDY EMAIL</title>
                    <style>$css</style>
                </head>
                <body>
                    <div id="menuFull">
                        <span>粉糖粒子邮件</span>
                    </div>
                    <div class="screenFull">
                        <div class="infoBox">
                            <h1>$title</h1>
                            <h2>至小兽 $name $sex $sort</h2>
                            <p>$content</p>
                            <p style="font-size: 1.2em;color: palevioletred;">$extra</p>
                            <div class="txtBox">
                                <p>总管理兽 $adminName $adminSex $adminSort</p>
                                <p>$time</p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            EOF;
            try{
                // SMTP服务器
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;
                $mail->isSMTP();
                // 发送终端
                $mail->Host = $emailHost;
                $mail->Username = $emailUsername;
                $mail->Password = $emailEnterPassword;
                $mail->Port = $emailPort;
                // 邮件传输
                $mail->setFrom($emailUsername,$defaultSenderName);
                $mail->addAddress($receiverEmail,$receiver);
                $mail->isHTML(true);
                $mail->Subject = $defaultSenderSubject;
                $mail->Body = $emailContent;
                $mail->AltBody = 'plain-text';
                // 发送
                $mail->send();
            }
            catch(Exception $e){
                $outStr = "pinkcandy email error {$mail->ErrorInfo}";
            }
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/SSB_pinkcandy.css"></head>
                <div class="screen">
                    <div class="userBoxIndex">PINKCANDY邮件模块</div>
                    <div class="statementBox">
                    管理兽 $adminName $adminSex $adminSort<br>
                    向小兽 $name $sex $sort 发送了一份邮件<br>
                    <div class="infoBox">
                        <h1>$title</h1>
                        <p>$content</p>
                    </div>
                    </div>
                </div>
            EOF;
            return $outStr;
        }
        function customizeSendEmail($adminUser,$email){
            global $emailList;
            $emailHost = $emailList[0];
            $emailUsername = $emailList[1];
            $emailEnterPassword = $emailList[2];
            $emailPort = $emailList[3];
            $defaultSenderName = $emailList[4];
            $defaultSenderSubject = $emailList[5];
            include_once "../externalLib/PHPMailer.php";
            include_once "../externalLib/Exception.php";
            include_once "../externalLib/SMTP.php";
            $nameStr = $_POST["nameStr"];
            $title = $_POST["title"];
            $content = $_POST["content"];
            $extra = $_POST["extra"];
            $css = file_get_contents("../css/SSB_pinkcandy.css");
            $time = date('Y-m-d');
            $mail = new PHPMailer(true);
            $selectData = new selectData;
            $dataExist = new dataExist;
            $adminUserList = $selectData->get_name($adminUser,2);
            $adminName=$adminUserList[0];$adminSex=$adminUserList[2];$adminSort=$adminUserList[3];
            $receiverEmail = $email;
            $receiver = $nameStr;
            $emailContent = <<<EOF
                <!DOCTYPE html>
                <html lang="zh">
                <head>
                    <meta charset="UTF-8">
                    <title>PINKCANDY EMAIL</title>
                    <style>$css</style>
                </head>
                <body>
                    <div id="menuFull">
                        <span>粉糖粒子邮件</span>
                    </div>
                    <div class="screenFull">
                        <div class="infoBox">
                            <h1>$title</h1>
                            <h2>至小兽 $nameStr</h2>
                            <p>$content</p>
                            <p style="font-size: 1.2em;color: palevioletred;">$extra</p>
                            <div class="txtBox">
                                <p>粉糖粒子管理兽 $adminName $adminSex $adminSort</p>
                                <p>$time</p>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            EOF;
            try{
                // SMTP服务器
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;
                $mail->isSMTP();
                // 发送终端
                $mail->Host = $emailHost;
                $mail->Username = $emailUsername;
                $mail->Password = $emailEnterPassword;
                $mail->Port = $emailPort;
                // 邮件传输
                $mail->setFrom($emailUsername,$defaultSenderName);
                $mail->addAddress($receiverEmail,$receiver);
                $mail->isHTML(true);
                $mail->Subject = $defaultSenderSubject;
                $mail->Body = $emailContent;
                $mail->AltBody = 'plain-text';
                // 发送
                $mail->send();
            }
            catch(Exception $e){
                $outStr = "pinkcandy email error {$mail->ErrorInfo}";
            }
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/SSB_pinkcandy.css"></head>
                <div class="screen">
                    <div class="userBoxIndex">PINKCANDY邮件模块</div>
                    <div class="statementBox">
                    管理兽 $adminName $adminSex $adminSort<br>
                    使用自定义邮件模块向小兽 $nameStr 发送了一份邮件<br>
                    <div class="infoBox">
                        <h1>$title</h1>
                        <p>$content</p>
                    </div>
                    </div>
                </div>
            EOF;
            return $outStr;
        }
    }
}