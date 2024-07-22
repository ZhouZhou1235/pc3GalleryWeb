<?php
namespace {
    require_once "dbClass.php";
    class userInput {
        // 输入检查
        function checkRegister($username,$password,$sex,$sort,$email){
            // 检查注册输入
            if(empty($username)||empty($password)||empty($sex)||empty($sort)||empty($email)){return 0;}
            if(!is_numeric($username)){return 0;}
            if(strlen($username)!=5){return 0;}
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){return 0;}
            return 1;
        }
        function avoidRepeat($username,$email){
            // 避免同号
            global $link;
            $sql = "select username,email from account where username='$username' or email='$email'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows>0){return 0;}
            return 1;
        }
        function checkLogin($username,$pendPassword){
            // 核验用户和密码
            global $link;
            $sql = "select username,password from account where username='$username' or email='$username'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            $account = mysqli_fetch_array($result);
            $realPass=$account['password'];
            if(!password_verify($pendPassword,$realPass)){return 0;}
            return 1;
        }
        function checkUploadGallery($file,$title,$type,$visit){
            // 检查上传作品完整性
            if(empty($file)||empty($title)||empty($type)||empty($visit)){return 0;}
            $fileName=$file['name'];$fileSize=$file['size'];
            $fileArray = pathinfo($fileName);$fileType = $fileArray['extension'];
            $allowType = array('jpg','gif','jpeg','png');
            if($fileSize>5*1024*1024){return 0;}
            if(!in_array($fileType,$allowType)){return 0;}
            return 1;
        }
        function checkAddPost($title,$content,$file){
            // 检查帖子内容完整性
            if(empty($title) || empty($content)){return 0;}
            if(is_uploaded_file($file['name'])){
                $fileName=$file['name'];$fileSize=$file['size'];
                $fileArray = pathinfo($fileName);$fileType = $fileArray['extension'];
                $allowType = array('jpg','gif','jpeg','png');
                if($fileSize>5*1024*1024){return 0;}
                if(!in_array($fileType,$allowType)){return 0;}    
            }
            return 1;
        }
        function checkEditGallery($title,$type,$visit){
            // 检查修改作品完整性
            if(empty($title)||empty($type)||empty($visit)){return 0;}
            return 1;
        }
        function checkEditUser($username,$password,$sex,$sort,$email){
            // 检查粉糖账号编辑内容
            if(empty($username)||empty($sex)||empty($sort)||empty($email)){return 0;}
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){return 0;}
            return 1;
        }
        function avoidEmailRepeat($username,$email){
            // 避免用户使用已经绑定的邮箱
            global $link;
            $sql = "select username,email from account where email='$email' and username='$username'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){
                $sql = "select username,email from account where email='$email'";
                $result = mysqli_query($link,$sql);
                if($result->num_rows>0){return 0;}
            }
            return 1;
        }
        function inputFilter($inputStr){
            // 非法字符过滤器
            $inputStr = htmlspecialchars($inputStr);
            $dangerList = array(
                '`','@','#','$','%','^','&','*','(',')',
                '{','}','[',']','|','\\','<','>','/','_',
                '\'','"','/*','//','<>',
            );
            for($i=0;$inputStr[$i];$i++){
                if(in_array($inputStr[$i],$dangerList)){
                    $inputStr = "\"".$inputStr."\"";
                    break;
                };
            }
            // $inputStr = str_replace("","",$inputStr);
            return $inputStr;
        }
    }
    class userState {
        // 用户状态检查
        function checkLogin(){
            // 检查是否登录
            session_start();
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];
            if(!$username||!$password){return 0;}
            return 1;
        }
        function checkMyself($username){
            // 检查是否是用户本兽操作
            session_start();
            $furryUser = $_SESSION['username'];
            if($username!=$furryUser){return 0;}
            return 1;
        }
        function checkUserAndGallery($galleryId){
            // 检查作品上传者和修改者是否一致
            session_start();
            $furryUser = $_SESSION['username'];
            global $link;
            $sql = "select username from gallery where id='$galleryId' and username='$furryUser'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
    }
    class dataExist {
        // 数据存在类
        function checkGalleryExist($galleryId){
            // 检查画廊是否存在
            global $link;
            $sql = "select id from gallery where id='$galleryId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
        function avoidAddTagRepeat($tagId,$galleryId){
            // 避免画廊标签被重复添加到关联表
            global $link;
            $sql = "select tagid,galleryid from connect where tagid='$tagId' and galleryid='$galleryId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows>0){return 0;}
            return 1;
        }
        function checkTagExist($tag){
            // 检查标签是否存在
            global $link;
            $sql = "select tag from tags where tag='$tag'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
        function checkUsername($username){
            // 检查小兽是否存在
            global $link;
            $sql = "select username from account where username='$username'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows<1){return 0;}
            return 1;
        }
        function checkBadge($code){
            // 检查徽章是否存在
            global $link;
            $sql = "select code from badges where code='$code'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows<1){return 0;}
            return 1;
        }
        function avoidGiveBadgeRepeat($code,$username){
            // 避免徽章重复添加
            global $link;
            $sql = "select code,username from badges_account where code='$code' and username='$username'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows>0){return 0;}
            return 1;
        }
        function checkEssayAndUser($username,$essayId){
            // 检查用户和文章是否对应
            global $link;
            $sql = "select username,Id from essay where username='$username' and Id='$essayId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
        function avoidPostTagRepeat($tagId,$postId){
            // 避免帖子标签被重复添加到关联表
            global $link;
            $sql = "select tagid,postid from tags_posts where tagid='$tagId' and postid='$postId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows>0){return 0;}
            return 1;
        }
    }
}