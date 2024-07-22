<?php
namespace {
    // PHPMailer类库 https://github.com/PHPMailer/PHPMailer/
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once "dbClass.php";
    class access {
        // 用户通道
        function register(){
            // 注册
            require_once "examineClass.php";
            $userInput = new userInput;
            $dbTable = new dbTable;
            $username = $_POST['username'];
            $pendPassword = $_POST['password'];
            $name = $_POST['name'];
            $info = $_POST['info'];
            $sex = $_POST['sex'];
            $sort = $_POST['sort'];
            $email = $_POST['email'];
            if(empty($name)){$name=$username;}
            $num1 = $userInput->checkRegister($username,$pendPassword,$sex,$sort,$email);
            $num2 = $userInput->avoidRepeat($username,$email);
            if($num1+$num2==2){
                $dbTable->table_register($pendPassword,$username,$password,$name,$sex,$info,$sort,$email);
            }else{return 0;}
            return 1;
        }
        function login(){
            // 登录
            require_once "examineClass.php";
            $username = $_POST['username'];
            $pendPassword = $_POST['password'];
            $userInput = new userInput;
            $num1 = $userInput->checkLogin($username,$pendPassword);
            if($num1<1){return 0;}
            global $link;
            $sql = "select username,name,password from account where username='$username' or email='$username'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            $account = mysqli_fetch_array($result);
            $furryUser = $account['username'];$name = $account['name'];$password=$account['password'];
            session_start();
            $lifeTime = 72*3600;ini_set('session.gc_maxlifetime',$lifeTime);
            $_SESSION['username'] = $furryUser;
            $_SESSION['password'] = $password;
            $_SESSION['name'] = $name;
            $_SESSION['view'] = 40;
            return 1;
        }
        function logout(){
            // 注销
            session_start();
            session_unset();
            session_destroy();
            return 1;
        }
        function getResetCode(string $email){
            // 获取重置密码
            global $link;
            $sql = "select username,name,email from account where email='$email'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $username = $account['username'];
            $name = $account['name'];
            if($result->num_rows<1){return 0;}
            {
                // 生成验证码
                $resetCode = random_int(1000,9999);
                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["username"] = $username;
                $_SESSION["resetCode"] = $resetCode;
            }
            {
                // 发送邮件
                require_once "../externalLib/PHPMailer.php";
                require_once "../externalLib/Exception.php";
                require_once "../externalLib/SMTP.php";
                $emailContent = <<<EOF
                    <html>
                    <head>
                        <title>pinkcandy getResetCode</title>
                    </head>
                    <body>
                        <h1>粉糖粒子 账号密码重置</h1>
                        <h2>正在通过邮箱 $email 重置粉糖账号 $username $name</h2>
                        <h2 style="color: red;">重置验证码 $resetCode</h2>
                        <h3>请勿泄露给其他小兽</h3>
                    </body>
                    </html>
                EOF;
                $mail = new PHPMailer(true);
                try{
                    // SMTP服务器
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->SMTPAuth = true;
                    $mail->isSMTP();
            
                    // 发送终端
                    $mail->Host = 'smtp.qq.com';
                    $mail->Username = '1479499289@qq.com';
                    $mail->Password = '';
                    $mail->Port = 465;
            
                    // 邮件传输
                    $mail->setFrom('1479499289@qq.com', 'ZZWWpinkcandy');
                    $mail->addAddress($email, 'furryUser');
            
                    $mail->isHTML(true);
                    $mail->Subject = '-=粉糖粒子邮件=-';
                    $mail->Body = $emailContent;
                    $mail->AltBody = 'plain-text';
            
                    // 发送
                    $mail->send();
                    echo 'pinkcandy email send success';
                }
                catch(Exception $e){
                    echo "pinkcandy email error {$mail->ErrorInfo}";
                }
            }
            return 1;
        }
        function resetUser($pendPassword,$resetCode){
            // 小兽重置密码
            session_start();
            global $link;
            $dbTable = new dbTable;
            $realCode = $_SESSION["resetCode"];
            $username = $_SESSION["username"];
            $email = $_SESSION["email"];
            if($realCode != $resetCode){return 0;}
            if(empty($pendPassword)){return 0;}
            $dbTable->table_resetPassword($pendPassword,$email,$username);
            session_unset();
            return 1;
        }
    }
    class userAction {
        // 用户操作类
        function editMyself(){
            // 编辑个兽信息
            include_once "examineClass.php";
            include_once "coinClass.php";
            global $link;
            $userInput = new userInput;
            $userState = new userState;
            $coinChange = new coinChange;
            $dbTable = new dbTable;
            $userState->checkLogin();
            $furryUser = $_SESSION['username'];
            $pendPassword = $_POST['password'];
            $name = $_POST['name'];
            $info = $_POST['info'];
            $sex = $_POST['sex'];
            $sort = $_POST['sort'];
            $email = $_POST['email'];
            $num1 = $userInput->checkEditUser($furryUser,$pendPassword,$sex,$sort,$email);
            $num2 = $userInput->avoidEmailRepeat($furryUser,$email);
            $num3 = $userState->checkMyself($furryUser);
            if($num1+$num2+$num3==3){
                $dbTable->table_editUser($pendPassword,$name,$info,$sex,$sort,$email,$furryUser);
                $coinChange->coinSubtract($furryUser,2);
            }else{return 0;}
            return 1;
        }
        function inputBoard(){
            // 留言板输入
            $furryUser = $_SESSION['username'];
            $message = $_POST['message'];
            if(!$message||!$furryUser){return 0;}
            global $link;
            $sql = "insert into board(username,message) values('$furryUser','$message')";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function delMessage($boardId){
            // 删除留言
            $furryUser = $_SESSION['username'];
            global $link;
            {
                $sql = "select username from board where username='$furryUser' and id='$boardId'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows==0){return 0;}
            }
            {
                $sql = "delete from board where id='$boardId'";
                $result = mysqli_query($link,$sql);$result->num_rows;
            }
            return 1;
        }
        function delComments($commentId){
            // 删除评论
            $furryUser = $_SESSION['username'];
            global $link;
            {
                $sql = "select username from comments where username='$furryUser' and id='$commentId'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows==0){return 0;}
            }
            {
                $sql = "delete from comments where id='$commentId'";
                $result = mysqli_query($link,$sql);$result->num_rows;
            }
            return 1;
        }
        function sendComments($comment,$point){
            // 向画廊发送评论
            $furryUser = $_SESSION['username'];
            if(!$comment||!$furryUser){return 0;}
            global $link;
            $sql = "insert into comments(username,comment,point) values('$furryUser','$comment','$point')";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function addStar($galleryId){
            // 用户收藏画廊
            $furryUser = $_SESSION['username'];
            global $link;
            {
                $sql = "select username,galleryId from star where username='$furryUser' and galleryId='$galleryId'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows>0){return 0;}
            }
            $sql = "insert into star(username,galleryid) values('$furryUser','$galleryId')";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function addPostStar($postId){
            $dbTable = new dbTable;
            $furryUser = $_SESSION['username'];
            if(!$postId){return 0;}
            $dbTable->db_addPostStar($furryUser,$postId);
            return 1;
        }
        function delStar($starId){
            // 用户取消收藏
            $furryUser = $_SESSION['username'];
            global $link;
            {
                $sql = "select username from star where username='$furryUser' and id='$starId'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows==0){return 0;}
            }
            {
                $sql = "delete from star where id='$starId'";
                $result = mysqli_query($link,$sql);$result->num_rows;
            }
            return 1;
        }
        function addTagsAndConnect($tags,$galleryId){
            // 用户添加标签并关联到画廊
            $dataExist = new dataExist;
            $num1 = substr_count($tags,"\n");
            if(!$tags || $num1!=0){return 0;}
            $tagsArray = explode(" ",$tags);
            for($i=0;$tagsArray[$i];$i++){
                $tag = $tagsArray[$i];
                {
                    global $link;
                    $num3 = $dataExist->checkTagExist($tag);
                    if($num3==0){
                        $sqlAdd = "insert into tags(tag,type) values('$tag',1)";
                        $resultAdd = mysqli_query($link,$sqlAdd);$resultAdd->num_rows;
                    }
                    {
                        $sql = "select Id from tags where tag='$tag'";
                        $result = mysqli_query($link,$sql);
                        $getTagId = mysqli_fetch_array($result);
                        $tagId = $getTagId['Id'];
                    }
                    $num4 = $dataExist->avoidAddTagRepeat($tagId,$galleryId);
                    if($num4==1){
                        $sql = "insert into connect(tagid,galleryid) values('$tagId','$galleryId')";
                        $result = mysqli_query($link,$sql);$result->num_rows;
                    }
                }
            }
            return 1;
        }
        function addTagsToPost($tags,$postId){
            // 为帖子添加标签
            global $link;
            $dataExist = new dataExist;
            $num1 = substr_count($tags,"\n");
            if(!$tags || $num1!=0){return 0;}
            $tagsArray = explode(" ",$tags);
            for($i=0;$tagsArray[$i];$i++){
                $tag = $tagsArray[$i];
                {
                    $num3 = $dataExist->checkTagExist($tag);
                    if($num3==0){
                        $sqlAdd = "insert into tags(tag,type) values('$tag',1)";
                        $resultAdd = mysqli_query($link,$sqlAdd);$resultAdd->num_rows;
                    }
                    {
                        $sql = "select Id from tags where tag='$tag'";
                        $result = mysqli_query($link,$sql);
                        $getTagId = mysqli_fetch_array($result);
                        $tagId = $getTagId['Id'];
                    }
                    $num4 = $dataExist->avoidPostTagRepeat($tagId,$postId);
                    if($num4==1){
                        $sql = "insert into tags_posts(tagid,postid) values('$tagId','$postId')";
                        $result = mysqli_query($link,$sql);$result->num_rows;
                    }    
                }
            }
            return 1;
        }
        function delConnect($tags,$galleryId){
            // 用户撕下标签
            $num1 = substr_count($tags,"\n");
            if(!$tags || $num1!=0){return 0;}
            $tagsArray = explode(" ",$tags);
            for($i=0;$tagsArray[$i];$i++){
                $tag = $tagsArray[$i];
                {
                    global $link;
                    {
                        $sql = "select Id from tags where tag='$tag'";
                        $result = mysqli_query($link,$sql);
                        $getTagId = mysqli_fetch_array($result);
                        $tagId = $getTagId['Id'];
                    }
                    {
                        $sql = "delete from connect where tagid='$tagId' and galleryid='$galleryId'";
                        $result = mysqli_query($link,$sql);$result->num_rows;
                    }
                }
            }
            return 1;
        }
        function preSearchTags($preSearch){
            // 用户预搜索标签
            if(!$preSearch){return 0;}
            global $link;
            $tagsArray = explode(" ",$preSearch);
            {
                $sql = "";
                for($i=0;$tagsArray[$i];$i++){
                    $tag = $tagsArray[$i];
                    if($i==0){
                        $sql = $sql."(select * from tags where tag like '%$tag%')";
                    }
                    else if($i<count($tagsArray)){
                        $sql = $sql." union (select * from tags where tag like '%$tag%')";
                    }
                }
                $sql = $sql." order by id DESC";    
            }
            $result = mysqli_query($link,$sql);
            while($tags = mysqli_fetch_array($result)){
                $foundTag = $tags['tag'];
                echo "#$foundTag ";
            }
            return 1;
        }
        function searchTagsAndShow($search){
            // 搜索标签并显示画廊
            if(!$search){return 0;}
            require_once "galleryClass.php";
            $furryArt = new furryArt;
            $loadNum = 0;
            global $link;
            $galleryIdArray = [];
            $tagsArray = explode(" ",$search);
            echo "<div class='galleryBox'>";
            for($i=0;$tagsArray[$i];$i++){
                $tag = $tagsArray[$i];
                {
                    $sqlTagId = "select * from tags where tag='$tag'";
                    $resultTagId = mysqli_query($link,$sqlTagId);
                    $tags=mysqli_fetch_array($resultTagId);$tagId = $tags['Id'];    
                }
                {
                    $sqlConnect = "select * from connect where tagid='$tagId' order by id DESC";
                    $resultConnect = mysqli_query($link,$sqlConnect);
                    while($connect=mysqli_fetch_array($resultConnect)){
                        $galleryId=$connect['galleryid'];
                        if(!in_array($galleryId,$galleryIdArray)){
                            $sqlGallery = "select * from gallery where id='$galleryId'";
                            $resultGallery = mysqli_query($link,$sqlGallery);
                            $all = mysqli_fetch_array($resultGallery);
                            $username = $all['username'];
                            $file = $all['file'];
                            $title = $all['title'];
                            $info = $all['info'];
                            $type = $all['type'];
                            $visit = $all['visit'];
                            $sqlAcc = "select name,sex,sort,grade from account where username='$username'";
                            $resultAcc = mysqli_query($link,$sqlAcc);
                            $account = mysqli_fetch_array($resultAcc);
                            $name=$account['name'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];
                            {
                                $sqlStar = "select galleryid from star where galleryid='$galleryId'";
                                $resultStar = mysqli_query($link,$sqlStar);
                                $starNum = mysqli_num_rows($resultStar);
                            }
                            $imgSrc = $furryArt->identifyVisit($visit,$username,$file);
                            $outType = $furryArt->identifyType($type);
                            echo <<<EOF
                                <div class="showGalleryIndex">
                                    <a href="gallery.php?galleryId=$galleryId"><img src="$imgSrc" alt="$imgSrc"></a>
                                    <a href="gallery.php?galleryId=$galleryId"><h1>$title</h1></a>
                                    <a href="user.php?username=$username"><h2>$name $sex $sort</h2></a>
                                    <p>画廊ID$galleryId $outType 收藏$starNum</p>
                                    <p>$info</p>
                                </div>
                            EOF;
                            $galleryIdArray[] = $galleryId;
                        }
                    }
                }
            }
            echo"</div>";
            if($loadNum>40){return;}
            $loadNum++;
        }
        function watchUser($username){
            // 用户关注用户
            global $link;
            $furryUser = $_SESSION['username'];
            {
                $sql = "select * from watch where watcher='$furryUser' and username='$username'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows>0){return 0;}
                else if($username == $furryUser){return 0;}
            }
            $sql = "insert into watch(watcher,username) values('$furryUser','$username')";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function unWatch($username){
            // 用户取消关注
            global $link;
            $furryUser = $_SESSION['username'];
            echo "$username $furryUser";
            if(empty($furryUser) || empty($username)){return 0;}
            $sql = "delete from watch where watcher='$furryUser' and username='$username'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function upload_essay($username){
            // 发布爪记
            global $link;
            $dbTable = new dbTable;
            $title = $_POST['title'];
            $content = $_POST['content'];
            $galleryId = $_POST['galleryId'];
            if(empty($username) || empty($title) || empty($content)){return 0;}
            $dbTable->upload_essay($title,$content,$galleryId,$username);
            return 1;
        }
        function delEssay($essayId){
            // 删除爪记
            global $link;
            $dbTable = new dbTable;
            $userState = new userState;
            $dataExist = new dataExist;
            $furryUser = $_SESSION['username'];
            $num1 = $userState->checkMyself($furryUser);
            $num2 = $dataExist->checkEssayAndUser($furryUser,$essayId);
            if($num1+$num2<2){return 0;}
            $dbTable->delEssay($essayId);
            return 1;
        }
        function addPaw_essay($username,$essayId){
            // 给爪记印爪
            $dbTable = new dbTable;
            $selectData = new selectData;
            if($selectData->get_pawForEssay($username,$essayId)==1){return 0;}
            $dbTable->addPaw_essay($username,$essayId);
            return 1;
        }
        function commentToPost($username,$postId){
            // 跟帖
            include_once "examineClass.php";
            include_once "postClass.php";
            $userInput = new userInput;
            $userState = new userState;
            $furryGargen = new furryGarden();
            $dbTable = new dbTable;
            $selectData = new selectData;
            $dataExist = new dataExist;
            $content = $userInput->inputFilter($_POST['content']);
            $galleryId = $userInput->inputFilter($_POST['galleryId']);
            $file = $_FILES['postImg'];
            // 检查输入
            if(!$username || !$postId){return 0;}
            if(!$content && !$galleryId && empty($file['name'])){return 0;}
            $num1 = $userState->checkLogin();
            if($galleryId){$num2 = $dataExist->checkGalleryExist($galleryId);}
            else{$num2 = 1;}
            if($num1+$num2<2){return 0;}
            if(!empty($file['name'])){
                // 检查图片
                $fileName=$file['name'];$fileSize=$file['size'];
                $fileArray = pathinfo($fileName);$fileType = $fileArray['extension'];
                $allowType = array('jpg','gif','jpeg','png');
                if($fileSize>5*1024*1024){return 0;}
                if(!in_array($fileType,$allowType)){return 0;}
                // 上传图片
                if($file['size']<=0.5*1024*1024){$furryGargen->uploadNewPostImg($username,$file,1);}
                else{$furryGargen->uploadNewPostImg($username,$file);}
                $postImgId = $selectData->getMaxId("postimg");
            }
            // 跟帖信息写入数据库
            $dbTable->db_addPostComment($username,$postId,$content,$galleryId,$postImgId);
            return 1;
        }
        function replyPostComment($username,$postId){
            // 回复跟帖
            include_once "examineClass.php";
            $userInput = new userInput;
            $dbTable = new dbTable;
            $userState = new userState;
            $num1 = $userState->checkLogin();
            if($num1<1){return 0;}
            $reply = $userInput->inputFilter($_POST['reply']);
            $commentId = $userInput->inputFilter($_POST['commentId']);
            if(empty($reply)){return 0;}
            $dbTable->db_addPostReply($username,$reply,$commentId,$postId);
            return 1;
        }
        function addPaw_post($username,$postId){
            // 给帖子印爪
            include_once "examineClass.php";
            $dbTable = new dbTable;
            $userState = new userState;
            $num1 = $userState->checkLogin();
            if($num1<1){return 0;}
            $dbTable->db_addPawToPost($username,$postId);
            return 1;
        }
        function addPaw_postComment($username,$commentId){
            // 给跟贴印爪
            include_once "examineClass.php";
            $dbTable = new dbTable;
            $userState = new userState;
            $num1 = $userState->checkLogin();
            if($num1<1){return 0;}
            $dbTable->db_addPawToPostComment($username,$commentId);
            return 1;
        }
        function delPostStar($username,$postId){
            // 取消帖子收藏
            include_once "dbClass.php";
            $furryUser = $_SESSION['username'];
            if($username!=$furryUser){return 0;}
            $dbTable = new dbTable;
            $dbTable->db_delPostStar($username,$postId);
            return 1;
        }
    }
    class userBadges {
        // 用户徽章类
        function printClaw($username){
            // 闪星徽章 印爪！
            global $link;
            $sqlBoard = "select message from board where username='$username'";
            $resultBoard = mysqli_query($link,$sqlBoard);
            $sqlGallery = "select file from gallery where username='$username'";
            $resultGallery = mysqli_query($link,$sqlGallery);
            if($resultBoard->num_rows>=3 && $resultGallery->num_rows>0){
                $sql = "select code from badges_account where username='$username' and code='377523'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows==0){
                    $sql = "insert into badges_account(code,username,approve) values('377523','$username','10000')";
                    $result = mysqli_query($link,$sql);$result->num_rows;    
                }
            }else{return 0;}
            return 1;
        }
        function jiemi($username){
            // 闪星徽章 解密兽
            global $link;
            $str1 = $_POST["str1"];$str2 = $_POST["str2"];$str3 = $_POST["str3"];
            if(
                $str1 == "伊布们为什么这么可爱？！" &&
                $str2 == "小兽们的鼓励就是对粉糖最大的支持" &&
                $str3 == "希望毛绒绒能够陪伴着你度过难关"
            ){
                $sql = "select code from badges_account where username='$username' and code='594372'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows==0){
                    $sql = "insert into badges_account(code,username,approve) values('594372','$username','10000')";
                    $result = mysqli_query($link,$sql);$result->num_rows;    
                }
                return 1;
            }else{return 0;}
        }
    }
}