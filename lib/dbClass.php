<?php
namespace {
    $server = "localhost";
    $user = "";
    $user_password = "";
    $dbname = "pinkcandydb";
    $link = mysqli_connect($server,$user,$user_password,$dbname);
    class dbTable {
        // 操作数据库表
        function table_register($pendPassword,$username,$password,$name,$sex,$info,$sort,$email){
            // 增 注册
            global $link;
            $password = password_hash($pendPassword,PASSWORD_DEFAULT);
            $sql = "insert into account(username,password,name,info,sex,sort,email,grade,coin)
            values('$username','$password','$name','$info','$sex','$sort','$email',1,100)";
            $result = mysqli_query($link,$sql);$result->num_rows;
        }
        function table_resetPassword($pendPassword,$email,$username){
            // 改 重置小兽密码
            global $link;
            $password = password_hash($pendPassword,PASSWORD_DEFAULT);
            $sql = "update account set password='$password' where email='$email' and username='$username'";
            $result = mysqli_query($link,$sql);$result->num_rows;
        }
        function table_editUser($pendPassword,$name,$info,$sex,$sort,$email,$furryUser){
            // 改 编辑个兽信息
            global $link;
            if(empty($name)){$name="无名小兽";}
            if(empty($pendPassword)){
                $sql = "update account
                set name='$name',info='$info',sex='$sex',sort='$sort',email='$email'
                where username='$furryUser'";    
            }
            else {
                $password = password_hash($pendPassword,PASSWORD_DEFAULT);
                $sql = "update account
                set name='$name',password='$password',info='$info',sex='$sex',sort='$sort',email='$email'
                where username='$furryUser'";    
            }
            $result = mysqli_query($link,$sql);$result->num_rows;
        }
        function upload_essay($title,$content,$galleryId,$username){
            // 增 发布爪记
            global $link;
            $sql = "insert into essay(title,content,galleryid,username)
            values('$title','$content','$galleryId','$username')";
            $result = mysqli_query($link,$sql);$result->num_rows;
        }
        function delEssay($essayId){
            // 删 删除爪记
            global $link;
            $sql = "delete from essay where Id='$essayId'";
            $result = mysqli_query($link,$sql);$result->num_rows;
        }
        function addPaw_essay($username,$essayId){
            global $link;
            $sql = "insert into paw_essay(username,essayid)
            values('$username','$essayId')";
            $result = mysqli_query($link,$sql);$result->num_rows;
        }
        function db_addPost($username,$title,$subtitle,$content,$galleryId,$postImgId){
            // 增 发布新帖子
            global $link;
            do{
                // 避免postId重复
                $postId = random_int(100000000,999999999);
                $sql = "select postid from posts where postid='$postId'";
                $result = mysqli_query($link,$sql);
            }while($result->num_rows!=0);
            $sql = "insert into posts(username,title,subtitle,content,postid,galleryid,postimgid,pawnum)
            values('$username','$title','$subtitle','$content','$postId','$galleryId','$postImgId',0)";
            mysqli_query($link,$sql);
            return $postId;    
        }
        function db_addPostImg($username,$fileName){
            // 增 添加帖子图片记录
            global $link;
            $sql = "insert into postimg(username,file)
            values('$username','$fileName')";
            mysqli_query($link,$sql);
        }
        function db_addPostComment($username,$postId,$content,$galleryId,$postImgId){
            // 增 添加跟帖记录
            global $link;
            $sql = "insert into postcomments(username,postid,content,galleryid,postimgid,pawnum)
            values('$username','$postId','$content','$galleryId','$postImgId',0)";
            mysqli_query($link,$sql);
            $sql = "update posts set updatetime=CURRENT_TIMESTAMP where postid='$postId'";
            mysqli_query($link,$sql);
        }
        function db_addPostReply($username,$reply,$commentId,$postId){
            // 增 添加跟帖回复
            global $link;
            $sql = "insert into postreply(username,content,commentid,postid)
            values('$username','$reply','$commentId','$postId')";
            mysqli_query($link,$sql);
        }
        function db_addPawToPost($username,$postId){
            // 增 添加帖子印爪
            global $link;
            $sql = "select * from paw_posts where username='$username' and postid='$postId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){
                $selectData = new selectData;
                $thePostList = $selectData->getPost($postId);
                $pawNum = $thePostList[6];
                $pawNum++;
                $sql = "update posts set pawnum='$pawNum' where postid='$postId'";
                mysqli_query($link,$sql);
                $sql = "insert into paw_posts(username,postid)
                values('$username','$postId')";
                mysqli_query($link,$sql);
            }
        }
        function db_addPawToPostComment($username,$commentId){
            // 增 添加跟贴印爪
            global $link;
            $sql = "select * from paw_postcomments where username='$username' and commentid='$commentId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){
                $selectData = new selectData;
                $thePostCommentList = $selectData->getPostComment($commentId);
                $pawNum = $thePostCommentList[5];
                $pawNum++;
                $sql = "update postcomments set pawnum='$pawNum' where Id='$commentId'";
                mysqli_query($link,$sql);
                $sql = "insert into paw_postcomments(username,commentid)
                values('$username','$commentId')";
                mysqli_query($link,$sql);
            }
        }
        function db_addPostStar($username,$postId){
            // 增 添加帖子收藏
            global $link;
            $sql = "select * from poststar where username='$username' and postid='$postId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){
                $sql = "insert into poststar(username,postid)
                values('$username','$postId')";
                mysqli_query($link,$sql);
            }
        }
        function db_delPostStar($username,$postId){
            // 删 删除帖子收藏
            global $link;
            $sql = "delete from poststar where username='$username' and postid='$postId'";
            mysqli_query($link,$sql);
        }
        function db_delBadge($code){
            // 删 删除徽章
            global $link;
            if($code!=10000){ // 10000为总管理兽特殊徽章
                $sql = "delete from badges where code='$code'";
                mysqli_query($link,$sql);
                $sql = "delete from badges_account where code='$code'";
                mysqli_query($link,$sql);
            }
        }
        function db_renameBadge($code,$badgeName){
            // 改 更改徽章名称
            global $link;
            $sql = "update badges set badge='$badgeName' where code='$code'";
            mysqli_query($link,$sql);
        }
        function db_compensateCoin($username,$coin){
            // 改 补偿小兽硬币
            global $link;
            $sql = "select username,coin from account where username='$username'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return;}
            $account = mysqli_fetch_array($result);
            $theCoin = $account["coin"];
            $theCoin += $coin;
            $sql = "update account set coin='$theCoin' where username='$username'";
            mysqli_query($link,$sql);
        }
    }
    class selectData {
        // 查询数据库
        function get_gallery($galleryId){
            // 用Id查询画廊
            global $link;
            $sql = "select * from gallery where Id='$galleryId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            $gallery = mysqli_fetch_array($result);
            $file=$gallery["file"];$visit=$gallery["visit"];$username=$gallery["username"];
            if($visit==4){return 0;}
            $outList = [$file,$username];
            return $outList;
        }
        function get_postImg($postImgId){
            // 用Id查询帖子图片
            global $link;
            $sql = "select * from postimg where Id='$postImgId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            $postImg = mysqli_fetch_array($result);
            $file=$postImg["file"];$username=$postImg["username"];
            $outList = [$file,$username];
            return $outList;
        }
        function get_star($username,$galleryId){
            // 是否已收藏
            global $link;
            $sql = "select username,galleryid from star where username='$username' and galleryid='$galleryId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
        function get_pawForEssay($username,$essayId){
            global $link;
            $sql = "select username,essayid from paw_essay where username='$username' and essayid='$essayId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            return 1;
        }
        function get_name($username,$num){
            // 获取小兽信息
            global $link;
            $sql = "select * from account where username='$username'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $name = $account["name"];
            $info = $account["info"];
            $sex = $account["sex"];
            $sort = $account["sort"];
            $email = $account["email"];
            $outList = [$name,$info,$sex,$sort,$email];
            if($num==1){$outStr = $outList[0];}
            else if($num==2){return $outList;}
            else if($num==3){$outStr = $outList[-1];}
            else{$outStr = "null";}
            return $outStr;
        }
        function get_essayPaw($essayId){
            // 获取给爪记印爪的小兽
            global $link;
            $sql_paw_essay = "select username,essayid from paw_essay where essayid='$essayId'";
            $result_paw_essay = mysqli_query($link,$sql_paw_essay);
            $outStr = "";
            while($paw_essay = mysqli_fetch_array($result_paw_essay)){
                $username = $paw_essay["username"];
                $theList = $this->get_name($username,2);
                $outStr .= "<a href='/user.php?look=$username'>".$theList[2].$theList[3].$theList[0]."</a> ";
            }
            return $outStr;
        }
        function getMaxId($tableName){
            // 获取目前的自增Id
            global $link;
            $sql = "select Id from $tableName order by Id DESC";
            $result = mysqli_query($link,$sql);
            $theTable = mysqli_fetch_array($result);
            $outStr = $theTable["Id"];
            return $outStr;
        }
        function getTags($num=1){
            // 获取标签
            global $link;
            $sql = "select tag,type from tags order by id DESC";
            $result = mysqli_query($link,$sql);
            $viewNum=$num;$loadNum=0;
            $tagList = array();
            while($tags = mysqli_fetch_array($result)){
                if($loadNum>=$viewNum){break;}$loadNum++;
                array_push($tagList,$tags['tag']);
            }
            return $tagList;
        }
        function getPost($postId){
            // 获取帖子的信息
            global $link;
            $sql = "select * from posts where postid='$postId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            $thePost = mysqli_fetch_array($result);
            $username = $thePost['username'];
            $title = $thePost['title'];
            $subtitle = $thePost['subtitle'];
            $content = $thePost['content'];
            $galleryId = $thePost['galleryid'];
            $postImgId = $thePost['postimgid'];
            $pawNum = $thePost['pawnum'];
            $createdTime = $thePost['createdtime'];
            $updateTime = $thePost['updatetime'];
            $outList = [$username,$title,$subtitle,$content,$galleryId,$postImgId,$pawNum,$createdTime,$updateTime];
            return $outList;
        }
        function getPostComments($postId){
            // 根据帖子ID获取所有的跟帖
            global $link;
            $sql = "select * from postcomments where postid='$postId' order by id DESC";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            $outList = array();
            while($theComment=mysqli_fetch_array($result)){
                $username = $theComment["username"];
                $content = $theComment["content"];
                $galleryId = $theComment["galleryid"];
                $postImgId = $theComment["postimgid"];
                $pawNum = $theComment["pawnum"];
                $time = $theComment["time"];
                $commentId = $theComment["Id"];
                $tmpList = array($username,$content,$galleryId,$postImgId,$pawNum,$time,$commentId);
                array_push($outList,$tmpList);
            }
            return $outList;
        }
        function getPostComment($commentId){
            // 获取跟帖信息
            global $link;
            $sql = "select * from postcomments where Id='$commentId'";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            $thePostComment = mysqli_fetch_array($result);
            $username = $thePostComment["username"];
            $postId = $thePostComment["postid"];
            $content = $thePostComment["content"];
            $galleryId = $thePostComment["galleryid"];
            $postImgId = $thePostComment["postimgid"];
            $pawNum = $thePostComment["pawnum"];
            $time = $thePostComment["time"];
            $outList = [$username,$postId,$content,$galleryId,$postImgId,$pawNum,$time];
            return $outList;            
        }
        function getPostReply($postId,$commentId){
            // 获取跟帖回复
            global $link;
            $sql = "select * from postreply where postid='$postId' and commentid='$commentId' order by id DESC";
            $result = mysqli_query($link,$sql);
            if($result->num_rows==0){return 0;}
            $outList = array();
            while($theReply=mysqli_fetch_array($result)){
                $username = $theReply["username"];
                $content = $theReply["content"];
                $time = $theReply["time"];
                $tmpList = array($username,$content,$time);
                array_push($outList,$tmpList);
            }
            return $outList;
        }
        function get_pawsFromPost($postId){
            // 获取向帖子印爪的小兽
            global $link;
            $sql = "select * from paw_posts where postid='$postId' order by id DESC";
            $result = mysqli_query($link,$sql);
            $outList = array();
            while($furryUserPaw=mysqli_fetch_array($result)){
                $username = $furryUserPaw["username"];
                array_push($outList,$username);
            }
            return $outList;
        }
        function get_pawsFromPostComment($commentId){
            // 获取向跟帖印爪的小兽
            global $link;
            $sql = "select * from paw_postcomments where commentid='$commentId' order by id DESC";
            $result = mysqli_query($link,$sql);
            $outList = array();
            while($furryUserPaw=mysqli_fetch_array($result)){
                $username = $furryUserPaw["username"];
                array_push($outList,$username);
            }
            return $outList;
        }
        function get_postStar($username){
            // 获取小兽收藏的帖子ID
            global $link;
            $sql = "select username,postid from poststar where username='$username' order by id DESC";
            $result = mysqli_query($link,$sql);
            $outList = array();
            while($postStar=mysqli_fetch_array($result)){
                $postId = $postStar['postid'];
                array_push($outList,$postId);
            }
            return $outList;
        }
    }
}