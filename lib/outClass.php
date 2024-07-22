<?php
namespace {
    require_once "dbClass.php";
    class homePage {
        // 首页输出
        function entry(){
            // 简易登录入口
            $file_url = "./resource/template/entry.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function menu(){
            // 导航栏
            $file_url = "./resource/template/menu.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function menuFull(){
            // 全宽导航栏
            $file_url = "./resource/template/menuFull.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function headPart(){
            // 头部
            $webTitle = "<title>粉糖粒子</title>";
            $file_url = "resource/template/head.html";
            $zzww = file_get_contents($file_url);
            echo $webTitle.$zzww;
            // 维护状态
            $cause = "服务器维护中";
            $information = "当前网站版本 2.0.2<br>
            很快回来！<br>
            ";
            $maintenance = <<<EOF
                <!DOCTYPE html>
                <html lang="zh">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                    <title>粉糖粒子</title>
                    <link rel="stylesheet" href="./css/style.css">
                    <link rel="icon" href="./resourse/img/logoICO.ico" type="img/x-icon">
                </head>
                <body>
                    <!-- ZZWW -->
                    <div id="menuFull">
                        <a href="./index.php"><img src="./resource/svg/logo_small.svg" alt="logo_small"></a>
                        <img src="./resource/svg/logo.svg" alt="logo">
                        <span>粉糖粒子</span>
                    </div>
                    <div class="screenFull">
                        <div class="txtBox">
                            <div style="color: red;font-size: 2em;text-align: center;">$cause</div>
                            <div style="font-size: 1.5em;">$information</div>
                        </div>
                    </div>
                </body>
                </html>
            EOF;
            // exit($maintenance);
        }
        function furryUser(){
            // 小兽空间
            $furryUser = $_SESSION['username'];
            global $link;
            $sql = "select username,name,sex,sort,grade,coin from account where username='$furryUser'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $name=$account['name'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];$coin=$account['coin'];
            $userZone = new userZone;
            $badges = $userZone->showBadges($furryUser);
            require_once "./resource/template/furryUser.html";
            return 1;
        }
        function register(){
            // 注册页面
            $file_url = "./resource/template/register.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function login(){
            // 登录页面
            $file_url = "./resource/template/login.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function about(){
            // 关于
            $file_url = "./resource/template/about.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function mainHomePage(){
            // 首页主体
            $Gallery = new gallery;
            $Posts = new Posts();
            $outStr = "<div class='screen'><div class='homePageBox'>";
            $outStr .= "<div class='homePage_leftSide'>";
            $outStr .= $Posts->showPostsIndex();$outStr .= "</div>";
            $outStr .= "<div class='homePage_rightSide'>";
            $outStr .= $Gallery->showGalleryIndex();$outStr .= "</div>";
            $outStr .= "</div></div>";
            return $outStr;
        }
    }
    class Posts {
        // 小兽花园
        function __construct(){
            echo <<<EOF
                <script>console.log("Posts 小兽花园");</script>
            EOF;
        }
        function posts_addForm(){
            // 发布新帖表单
            $file_url = "./resource/template/addPostForm.html";
            $outStr = file_get_contents($file_url);
            return $outStr;
        }
        function showPostsIndex(){
            // 在首页展示帖子
            global $link;
            $selectData = new selectData;
            $Statement = new Statement;
            $furryUser = $_SESSION['username'];
            $viewNum = $_SESSION['view'];
            $loadNum = 0;
            $outStr = "<div class='gardenBox'>";
            $sqlPosts = "select * from posts order by updatetime DESC";
            $resultPosts = mysqli_query($link,$sqlPosts);
            $posts=mysqli_fetch_array($resultPosts);
            if(empty($posts)){return;}
            $username = $posts["username"];
            $userList = $selectData->get_name($username,2);
            $name=$userList[0];$sex=$userList[2];$sort=$userList[3];
            $title = $posts["title"];
            $subtitle = $posts["subtitle"];
            $content = $posts["content"];
            $postId = $posts["postid"];
            $galleryId = $posts["galleryid"];
            $postImgId = $posts["postimgid"];
            if(!empty($galleryId)){
                $theGalleryList = $selectData->get_gallery($galleryId);
                $galleryUsername = $theGalleryList[1];
                $galleryFileName = $theGalleryList[0];
                $img_url = "./gallery/$galleryUsername/$galleryFileName";
                if($theGalleryList==0){$img_url="./resource/img/type4.png";}
            }
            else if(!empty($postImgId)){
                $thePostImgList = $selectData->get_postImg($postImgId);
                $postImgUsername = $thePostImgList[1];
                $postImgFileName = $thePostImgList[0];
                $img_url = "./postImg/$postImgUsername/$postImgFileName";
            }
            $pawNum = $posts["pawnum"];
            $updateTime = $posts["updatetime"];
            if(empty($img_url)){
                $outStr .= <<<EOF
                    <div class='theFirstPost'>
                        <a href="./posts.php?postId=$postId">
                            <h1>$title</h1>
                            <h2>$subtitle</h2>
                        </a>
                        <a href="./user.php?username=$username"><h2>$name $sex $sort</h2></a>
                        <h2>$pawNum 只小兽印爪</h2>
                        <p>$content</p>
                        <p>
                            帖子ID $postId
                            更新时间 $updateTime
                        </p>
                    </div>
                EOF;
            }
            else{
                $outStr .= <<<EOF
                    <div class='theFirstPost'>
                        <a href="./posts.php?postId=$postId">
                            <img src="$img_url" alt="$img_url">
                            <h1>$title</h1>
                            <h2>$subtitle</h2>
                        </a>
                        <a href="./user.php?username=$username"><h2>$name $sex $sort</h2></a>
                        <h2>$pawNum 只小兽印爪</h2>
                        <p>$content</p>
                        <p>
                            帖子ID $postId
                            更新时间 $updateTime
                        </p>
                    </div>
                EOF;
            }
            unset($img_url);
            $outStr .= "<div class='theGarden'>";
            while($posts=mysqli_fetch_array($resultPosts)){
                $username = $posts["username"];
                $userList = $selectData->get_name($username,2);
                $name=$userList[0];$sex=$userList[2];$sort=$userList[3];
                $title = $posts["title"];
                $subtitle = $posts["subtitle"];
                $content = $posts["content"];
                $postId = $posts["postid"];
                $galleryId = $posts["galleryid"];
                $postImgId = $posts["postimgid"];
                $updateTime = $posts["updatetime"];
                if(!empty($galleryId)){
                    $theGalleryList = $selectData->get_gallery($galleryId);
                    $galleryUsername = $theGalleryList[1];
                    $galleryFileName = $theGalleryList[0];
                    $img_url = "./gallery/$galleryUsername/$galleryFileName";
                    if($theGalleryList==0){$img_url="./resource/img/type4.png";}
                }
                else if(!empty($postImgId)){
                    $thePostImgList = $selectData->get_postImg($postImgId);
                    $postImgUsername = $thePostImgList[1];
                    $postImgFileName = $thePostImgList[0];
                    $img_url = "./postImg/$postImgUsername/$postImgFileName";
                }
                $pawNum = $posts["pawnum"];
                if(empty($img_url)){
                    $outStr .= <<<EOF
                        <div class='theGardenPost'>
                            <a href="./posts.php?postId=$postId">
                                <h1>$title</h1>
                                <h2>$subtitle</h2>
                            </a>
                            <a href="./user.php?username=$username"><h2>$name $sex $sort</h2></a>
                            <h2>$pawNum 只小兽印爪</h2>
                            <p>$content</p>
                            <p>
                                帖子ID $postId
                                更新时间 $updateTime
                            </p>                 
                        </div>
                    EOF;
                }
                else{
                    $outStr .= <<<EOF
                        <div class='theGardenPost'>
                            <a href="./posts.php?postId=$postId">
                                <img src="$img_url" alt="$img_url">
                                <h1>$title</h1>
                                <h2>$subtitle</h2>
                            </a>
                            <a href="./user.php?username=$username"><h2>$name $sex $sort</h2></a>
                            <h2>$pawNum 只小兽印爪</h2>
                            <p>$content</p>
                            <p>
                                帖子ID $postId
                                更新时间 $updateTime
                            </p>
                        </div>
                    EOF;
                }
                unset($img_url);
                if(!empty($furryUser) && $loadNum>$viewNum){$_SESSION['view'] = $viewNum+5;break;}
                else if(!$furryUser && $loadNum>40){$outStr .= $Statement->login4();break;}
                $loadNum++;
            }
            $outStr .= "</div>";
            $outStr .= "</div>";
            return $outStr;
        }
        function showPostsUser($username){
            // 在个兽空间展示帖子
            include_once "examineClass.php";
            global $link;
            $selectData = new selectData;
            $Statement = new Statement;
            $furryUser = $_SESSION['username'];
            $viewNum = $_SESSION['view'];
            $loadNum = 0;
            $outStr = "<div class='gardenBox'>";
            $sqlPosts = "select * from posts where username='$username' order by updatetime DESC";
            $resultPosts = mysqli_query($link,$sqlPosts);
            $posts=mysqli_fetch_array($resultPosts);
            if(empty($posts)){return;}
            $username = $posts["username"];
            $userList = $selectData->get_name($username,2);
            $name=$userList[0];$sex=$userList[2];$sort=$userList[3];
            $title = $posts["title"];
            $subtitle = $posts["subtitle"];
            $content = $posts["content"];
            $postId = $posts["postid"];
            $galleryId = $posts["galleryid"];
            $postImgId = $posts["postimgid"];
            if(!empty($galleryId)){
                $theGalleryList = $selectData->get_gallery($galleryId);
                $galleryUsername = $theGalleryList[1];
                $galleryFileName = $theGalleryList[0];
                $img_url = "./gallery/$galleryUsername/$galleryFileName";
                if($theGalleryList==0){$img_url="./resource/img/type4.png";}
            }
            else if(!empty($postImgId)){
                $thePostImgList = $selectData->get_postImg($postImgId);
                $postImgUsername = $thePostImgList[1];
                $postImgFileName = $thePostImgList[0];
                $img_url = "./postImg/$postImgUsername/$postImgFileName";
            }
            $pawNum = $posts["pawnum"];
            $updateTime = $posts["updatetime"];
            if(empty($img_url)){
                $outStr .= <<<EOF
                    <div class='theFirstPost'>
                        <a href="./posts.php?postId=$postId"><h1>$title</h1></a>
                        <h2>$subtitle</h2>
                        <h2>$name $sex $sort</h2>
                        <h2>印爪数 $pawNum</h2>
                        <p>$content</p>
                        <p>$postId $updateTime</p>
                    </div>
                EOF;
            }
            else{
                $outStr .= <<<EOF
                    <div class='theFirstPost'>
                        <img src="$img_url" alt="$img_url">
                        <a href="./posts.php?postId=$postId"><h1>$title</h1></a>
                        <h2>$subtitle</h2>
                        <h2>$name $sex $sort</h2>
                        <h2>印爪数 $pawNum</h2>
                        <p>$content</p>
                        <p>$postId $updateTime</p>
                    </div>
                EOF;
            }
            $outStr .= "<div class='theGarden'>";
            while($posts=mysqli_fetch_array($resultPosts)){
                $username = $posts["username"];
                $userList = $selectData->get_name($username,2);
                $name=$userList[0];$sex=$userList[2];$sort=$userList[3];
                $title = $posts["title"];
                $subtitle = $posts["subtitle"];
                $content = $posts["content"];
                $postId = $posts["postid"];
                $galleryId = $posts["galleryid"];
                $postImgId = $posts["postimgid"];
                $updateTime = $posts["updatetime"];
                if(!empty($galleryId)){
                    $theGalleryList = $selectData->get_gallery($galleryId);
                    $galleryUsername = $theGalleryList[1];
                    $galleryFileName = $theGalleryList[0];
                    $img_url = "./gallery/$galleryUsername/$galleryFileName";
                    if($theGalleryList==0){$img_url="./resource/img/type4.png";}
                }
                else if(!empty($postImgId)){
                    $thePostImgList = $selectData->get_postImg($postImgId);
                    $postImgUsername = $thePostImgList[1];
                    $postImgFileName = $thePostImgList[0];
                    $img_url = "./postImg/$postImgUsername/$postImgFileName";
                }
                $pawNum = $posts["pawnum"];
                if(empty($img_url)){
                    $outStr .= <<<EOF
                        <div class='theGardenPost'>
                            <a href="./posts.php?postId=$postId"><h1>$title</h1></a>
                            <h2>$subtitle</h2>
                            <h2>$name $sex $sort</h2>
                            <h2>印爪数 $pawNum</h2>
                            <p>$content</p>
                            <p>$postId $updateTime</p>
                        </div>
                    EOF;
                }
                else{
                    $outStr .= <<<EOF
                        <div class='theGardenPost'>
                            <img src="$img_url" alt="$img_url">
                            <a href="./posts.php?postId=$postId"><h1>$title</h1></a>
                            <h2>$subtitle</h2>
                            <h2>$name $sex $sort</h2>
                            <h2>印爪数 $pawNum</h2>
                            <p>$content</p>
                            <p>$postId $updateTime</p>
                        </div>
                    EOF;
                }
                unset($img_url);
                if(!empty($furryUser) && $loadNum>$viewNum){$_SESSION['view'] = $viewNum+5;break;}
                else if(!$furryUser && $loadNum>40){$outStr .= $Statement->login4();break;}
                $loadNum++;
            }
            $outStr .= "</div>";
            $outStr .= "</div>";
            return $outStr;
        }
        function showPost($postId){
            // 展示帖子
            $selectData = new selectData;
            $userZone = new userZone;
            $thePostList = $selectData->getPost($postId);
            $username = $thePostList[0];
            $title = $thePostList[1];
            $subtitle = $thePostList[2];
            $content = $thePostList[3];
            $galleryId = $thePostList[4];
            $postImgId = $thePostList[5];
            $pawNum = $thePostList[6];
            $createdTime = $thePostList[7];
            $updateTime = $thePostList[8];
            $theUserList = $selectData->get_name($username,2);
            $name=$theUserList[0];$sex=$theUserList[2];$sort=$theUserList[3];
            $theUserPaws = $this->showPostPaws($postId);
            $badges = $userZone->showBadges($username);
            if(!empty($galleryId)){
                $theGalleryList = $selectData->get_gallery($galleryId);
                $galleryUsername = $theGalleryList[1];
                $galleryFileName = $theGalleryList[0];
                $img_url = "./gallery/$galleryUsername/$galleryFileName";
                if($theGalleryList==0){$img_url="./resource/img/type4.png";}
            }
            else if(!empty($postImgId)){
                $thePostImgList = $selectData->get_postImg($postImgId);
                $postImgUsername = $thePostImgList[1];
                $postImgFileName = $thePostImgList[0];
                $img_url = "./postImg/$postImgUsername/$postImgFileName";
            }
            $outStr = "<div class='screen'><div class='gardenBox'>";
            $outStr .= "<div class='focusPostLeft'>";
            if($img_url){$outStr.="<img src='$img_url' alt='$img_url'>";}
            $outStr.= <<<EOF
                <div class="txtBox">
                    <h1>$title</h1>
                    <h2>$subtitle</h2>
                    <a href="./user.php?username=$username"><h2>$name $sex $sort</h2></a>$badges
                    <h2><a href="./running/send.php?todo=8&postId=$postId">印爪</a> 印爪数$pawNum</h2>
                    <p>$theUserPaws</p>
                    <p>
                        帖子ID $postId <br>
                        创建时间 $createdTime <br>
                        更新时间 $updateTime <br>
                    </p>
                </div>
                <div class="thePostContent">
                    <p>$content</p>
                </div>
                <div class="formBox">
                    <form action="./running/mark.php" method="post">
                        <input type="hidden" name="postId" value="$postId">
                        <input type="hidden" name="todo" value="3">
                        <button>收藏帖子</button>
                    </form>
                </div>
                <div class="formBox">
                    <form action="./running/send.php" method="post" enctype="multipart/form-data">
                        <textarea name="content" cols="30" rows="10" placeholder="说点什么......"></textarea>跟帖<br>
                        <input type="text" name="galleryId" placeholder="画廊ID">附图<br>
                        <input type="file" name="postImg"><br>
                        <input type="hidden" name="postId" value="$postId">
                        <input type="hidden" name="todo" value="6">
                        <button type="submit">发送</button>
                    </form>
                </div>
            EOF;
            $outStr .= "</div>";
            $outStr .= "<div class='focusPostRight'>";
            $outStr .= $this->showPostComment($postId);
            $outStr .= "</div>";
            $outStr .= "</div></div>";
            return $outStr;
        }
        function showPostComment($postId,$viewNum=40){
            // 显示跟贴
            $selectData = new selectData;
            $userZone = new userZone;
            $theCommentsList = $selectData->getPostComments($postId);
            $loadNum = 0;
            $outStr = "";
            while($loadNum<=$viewNum){
                if($theComment=$theCommentsList[$loadNum]){
                    $username = $theComment[0];
                    $theUserList = $selectData->get_name($username,2);
                    $name=$theUserList[0];$sex=$theUserList[2];$sort=$theUserList[3];
                    $content = $theComment[1];
                    $galleryId = $theComment[2];
                    $postImgId = $theComment[3];
                    $pawNum = $theComment[4];
                    $time = $theComment[5];
                    $commentId = $theComment[6];
                    $theUserPaws = $this->showPostCommentPaws($commentId);
                    $badges = $userZone->showBadges($username);
                    if(!empty($galleryId)){
                        $theGalleryList = $selectData->get_gallery($galleryId);
                        $galleryUsername = $theGalleryList[1];
                        $galleryFileName = $theGalleryList[0];
                        $img_url = "./gallery/$galleryUsername/$galleryFileName";
                        if($theGalleryList==0){$img_url="./resource/img/type4.png";}
                    }
                    else if(!empty($postImgId)){
                        $thePostImgList = $selectData->get_postImg($postImgId);
                        $postImgUsername = $thePostImgList[1];
                        $postImgFileName = $thePostImgList[0];
                        $img_url = "./postImg/$postImgUsername/$postImgFileName";
                    }  
                    $outStr .= "<div class='thePostComment'>";
                    $outStr .= <<<EOF
                        <div class="operateBox">
                            <div class="contentBox">
                                <div class="information">
                                    $name 的跟帖
                                </div>
                                <div class="formBox">
                                    <form action="./running/send.php" method="post">
                                    <textarea name="reply" cols="20" rows="4" placeholder="回复 $name 的跟帖......"></textarea>
                                        <input type="hidden" name="commentId" value="$commentId">
                                        <input type="hidden" name="postId" value="$postId">
                                        <input type="hidden" name="todo" value="7">
                                        <button type="submit">发送</button>
                                    </form>
                                </div>
                                <a href="./running/send.php?todo=9&commentId=$commentId&postId=$postId">印爪</a>
                                $theUserPaws
                            </div>
                        </div>
                    EOF;
                    if($content){
                        $outStr .= <<<EOF
                            <div class='leftSide'>
                                <a href="./user.php?username=$username"><h2>$name $sex $sort<h2></a>
                                $badges
                                <h2>印爪数 $pawNum</h2>
                                <div class='thePostContent'>
                                    <p>$content</p>
                                </div>
                                <p>$time</p>
                            </div>
                        EOF;
                        if(!empty($img_url)){
                            $outStr .= "
                                <div class='rightSide'>
                                    <img src='$img_url' alt='$img_url'>
                                </div>
                            ";
                        }
                    }
                    else{
                        $outStr .= <<<EOF
                            <div class='onlyImg'>
                                <img src='$img_url' alt='$img_url'>
                                <a href="./user.php?username=$username"><h2>$name $sex $sort<h2></a>
                                $badges
                                <h2>印爪数 $pawNum</h2>
                                <p>$time</p>
                            </div>
                        EOF;
                    }
                    $outStr .= $this->showPostReply($postId,$commentId);
                    $outStr .= "</div>";
                    unset($img_url);
                }else{break;}
                $loadNum++;
            }
            return $outStr;
        }
        function showPostReply($postId,$commentId){
            // 显示跟贴回复
            $selectData = new selectData;
            $userZone = new userZone;
            $theReplyList = $selectData->getPostReply($postId,$commentId);
            $outStr = "<div class='thePostReply'>";
            $loadNum = 0;
            while($theReply=$theReplyList[$loadNum]){
                $username = $theReply[0];
                $theUserList = $selectData->get_name($username,2);
                $name=$theUserList[0];$sex=$theUserList[2];$sort=$theUserList[3];
                $content = $theReply[1];
                $time = $theReply[2];
                $badges = $userZone->showBadges($username);
                $outStr .= "
                    <a href='./user.php?username=$username'><h2>$name $sex $sort 的回复</h2></a>
                    $badges
                    <p>$time</p>
                    <div class='thePostContent'>
                        <p>$content</p>
                    </div>
                ";
                $loadNum++;
            }
            $outStr .= "</div>";
            return $outStr;
        }
        function showPostPaws($postId){
            // 显示主题帖印爪
            $selectData = new selectData;
            $theUsersList = $selectData->get_pawsFromPost($postId);
            $outStr = "";
            for($i=0;$theUsersList[$i];$i++){
                $username = $theUsersList[$i];
                $theUserList = $selectData->get_name($username,2);
                $name=$theUserList[0];
                $outStr .= "<a href='../user.php?username=$username'>$name</a> ";
                if($i>=10){break;}
            }
            if(empty($outStr)){$outStr .= "还没有小兽印爪";}
            else{$outStr .= "等兽给这个主题贴印爪了";}
            return $outStr;
        }
        function showPostCommentPaws($commentId){
            // 显示跟帖印爪
            $selectData = new selectData;
            $theUsersList = $selectData->get_pawsFromPostComment($commentId);
            $outStr = "";
            for($i=0;$theUsersList[$i];$i++){
                $username = $theUsersList[$i];
                $theUserList = $selectData->get_name($username,2);
                $name=$theUserList[0];
                $outStr .= "<a href='../user.php?username=$username'>$name</a> ";
                if($i>=5){break;}
            }
            if(empty($outStr)){$outStr .= "还没有小兽印爪";}
            else{$outStr .= "等兽给这个跟贴印爪了";}
            return $outStr;            
        }
    }
    class gallery {
        // 画廊输出
        function uploadForm(){
            // 作品上传表单
            $file_url = "./resource/template/uploadGalleryForm.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function showGalleryIndex(){
            // 首页展示作品
            include_once "galleryClass.php";
            include_once "dbClass.php";
            $furryArt = new furryArt;
            $selectData = new selectData;
            $Statement = new Statement;
            global $link;
            $furryUser = $_SESSION['username'];
            $viewNum = $_SESSION['view'];
            $loadNum = 0;
            $outStr = "";
            $sql = "select * from gallery order by id DESC";
            $result = mysqli_query($link,$sql);
            $outStr .= "<div class='galleryBox'>";
            while($all = mysqli_fetch_array($result)){
                $galleryId = $all['Id'];
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
                    $sqlComments = "select point from comments where point='$galleryId'";
                    $resultComments = mysqli_query($link,$sqlComments);
                    $commentsNum = mysqli_num_rows($resultComments);
                }
                $imgSrc = $furryArt->identifyVisit($visit,$username,$file);
                $outType = $furryArt->identifyType($type);
                if($selectData->get_star($furryUser,$galleryId)==0){
                    $outStr .= <<<ZHOU
                        <div class="showGalleryIndex">
                            <a href="gallery.php?galleryId=$galleryId"><img src="$imgSrc" alt="$imgSrc"></a>
                            <a href="gallery.php?galleryId=$galleryId"><h1>$title</h1></a>
                            <a href="user.php?username=$username"><h2>$name $sex $sort</h2></a>
                            <p>画廊ID$galleryId $outType</p>
                            <button type="button">收藏$starNum</button>
                            <button type="button">评论$commentsNum</button>
                            <form action='./running/mark.php' method='post' id='starFormBox'>
                                <input type='hidden' name='galleryId' value='$galleryId'>
                                <input type='hidden' name='todo' value='1'>
                                <button type='submit'>收藏</button>
                            </form>
                            <p>$info</p>
                        </div>
                    ZHOU;
                }
                else{
                    $outStr .= <<<ZHOU
                        <div class="showGalleryIndex">
                            <a href="gallery.php?galleryId=$galleryId"><img src="$imgSrc" alt="$imgSrc"></a>
                            <a href="gallery.php?galleryId=$galleryId"><h1>$title</h1></a>
                            <a href="user.php?username=$username"><h2>$name $sex $sort</h2></a>
                            <p>画廊ID$galleryId $outType</p>
                            <button type="button">收藏$starNum</button>
                            <button type="button">评论$commentsNum</button>
                            <p>$info</p>
                        </div>
                    ZHOU;
                }
                if(!empty($furryUser) && $loadNum>$viewNum){$_SESSION['view'] = $viewNum+5;break;}
                else if(!$furryUser && $loadNum>40){$outStr .= $Statement->login4();break;}
                $loadNum++;
            }
            $outStr .= "</div>";
            return $outStr;
        }
        function showGallery($galleryId){
            // 展示作品
            include_once "galleryClass.php";
            $furryArt = new furryArt;
            global $link;
            {
                $sql = "select * from gallery where id='$galleryId'";
                $result = mysqli_query($link,$sql);if($result->num_rows==0){return 0;}
                $gallery = mysqli_fetch_array($result);
                $username = $gallery['username'];$file=$gallery['file'];$title=$gallery['title'];
                $info=$gallery['info'];$type=$gallery['type'];$visit=$gallery['visit'];
                $time=$gallery['time'];
            }
            {
                $sqlAcc = "select name,sex,sort,grade from account where username='$username'";
                $resultAcc = mysqli_query($link,$sqlAcc);
                $account = mysqli_fetch_array($resultAcc);
                $name=$account['name'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];    
            }
            {
                $sqlStar = "select galleryid from star where galleryid='$galleryId'";
                $resultStar = mysqli_query($link,$sqlStar);
                $starNum = mysqli_num_rows($resultStar);
            }
            $allTags = $this->galleryTags($galleryId);
            $outType = $furryArt->identifyType($type);
            $comments = $this->showComments($galleryId);
            if($visit==4){
                echo"
                    <div class='screen'>
                        <div class='statementBox'>
                            <p>
                                PINKCANDY报告<br>
                                $name 发布的 $title $galleryId 画廊 已被管理兽隐藏<br>
                                如有问题请联系总管理兽pinkcandyzhou@qq.com<br>
                            </p>
                        </div>
                    </div> 
                ";
                return;
        }
            require_once "./resource/template/showGallery.html";
        }
        function galleryTags($galleryId){
            // 显示画廊标签
            global $link;
            $allTags = "";
            $sql = "select * from connect where galleryid='$galleryId'";
            $result = mysqli_query($link,$sql);
            while($connect = mysqli_fetch_array($result)){
                $tagId = $connect['tagid'];
                $sqlTags = "select * from tags where id='$tagId'";
                $resultTags = mysqli_query($link,$sqlTags);
                $tags = mysqli_fetch_array($resultTags);
                $tag=$tags['tag'];$type=$tags['type'];
                $allTags = $allTags."#".$tag." ";
            }
            return $allTags;
        }
        function showComments($galleryId){
            // 展示画廊评论
            global $link;
            $sql = "select * from comments where point='$galleryId' order by id DESC";
            $result = mysqli_query($link,$sql);
            $outStr = "";
            while($comments = mysqli_fetch_array($result)){
                $username=$comments['username'];$comment=$comments['comment'];$time=$comments['time'];
                {
                    $sqlAcc = "select name,sex,sort,grade from account where username='$username'";
                    $resultAcc = mysqli_query($link,$sqlAcc);
                    $account = mysqli_fetch_array($resultAcc);
                    $name=$account['name'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];
                    $userZone = new userZone;
                    $badges = $userZone->showBadges($username);
                }
                $outStr .=  "
                    <div class='screen'>
                        <div class='commentsBox'>
                            <h1>$comment</h1>
                            <h2><a href='./user.php?username=$username'>$name</a> $sex $sort</h2>
                            <p>$badges</p>
                            <p>$time</p>
                        </div>
                    </div>
                ";
            }
            return $outStr;
        }
        function editGalleryForm($galleryId){
            // 修改画廊表单
            global $link;
            $sql = "select * from gallery where id='$galleryId'";
            $result = mysqli_query($link,$sql);
            $g = mysqli_fetch_array($result);
            $file=$g['file'];
            $username=$g['username'];
            $title=$g['title'];
            $info=$g['info'];
            $type=$g['type'];
            $visit=$g['visit'];
            $userState = new userState;
            $num = $userState->checkMyself($username);
            if($num==1){require_once "./resource/template/editGalleryForm.html";}
            else{echo"<div class='screen'>PINKCANDY 找不到画廊/不能编辑他兽的画廊</div>";}
            return 1;
        }
    }
    class userZone {
        // 小兽空间页面
        function myPage(){
            // 自己
            include_once "postClass.php";
            $Posts = new Posts();
            $furryUser = $_SESSION['username'];
            global $link;
            $sql = "select username,name,info,sex,sort,grade,coin from account where username='$furryUser'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $name=$account['name'];$info=$account['info'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];$coin=$account['coin'];
            $outStr = $this->watchUser($furryUser);
            $outStr .= "<br>";
            $outStr .= $this->showBadges($furryUser);
            $userBox .= "<div class='homePageBox'>";
            $userBox .= "<div class='homePage_leftSide'>";
            $userBox .= $Posts->showPostsUser($furryUser);
            $userBox .= "</div>";
            $userBox .= "<div class='homePage_rightSide'>";
            $userBox .= "<div class='userBox'>";
            $userBox .= $this->showGalleryUser($furryUser);
            $userBox .= $this->showEssayUser($furryUser);
            $userBox .= "</div>";
            $userBox .= "</div>";
            include_once "./resource/template/myself.html";
            return 1;
        }
        function showGalleryUser($username){
            // 在个兽空间展示画廊
            include_once "galleryClass.php";
            $furryArt = new furryArt;
            $userState = new userState;
            $Statement = new Statement;
            global $link;
            $loadNum = 0;
            $viewNum = $_SESSION['view'];if(!$viewNum){$viewNum=11;}
            $sql = "select * from gallery where username='$username' order by id DESC";
            $result = mysqli_query($link,$sql);
            $outStr = "<div class='leftSide'><div class='galleryBox'>";
            while($all = mysqli_fetch_array($result)){
                if($loadNum>=$viewNum){
                    if($userState->checkLogin()==1){$_SESSION['view']=$viewNum+5;}
                    else{$outStr.=$Statement->login4();}
                    break;
                }$loadNum++;
                $galleryId = $all['Id'];
                $username = $all['username'];
                $file = $all['file'];
                $title = $all['title'];
                $info = $all['info'];
                $type = $all['type'];
                $visit = $all['visit'];
                $imgSrc = $furryArt->identifyVisit($visit,$username,$file);
                $outType = $furryArt->identifyType($type);
                $outStr .= <<<ZHOU
                    <div class="showGalleryIndex">
                        <a href="gallery.php?galleryId=$galleryId"><img src="$imgSrc" alt="$imgSrc"></a>
                        <a href="gallery.php?galleryId=$galleryId"><h1>$title</h1></a>
                        <h2>画廊ID$galleryId $outType</h2>
                        <p>$info</p>
                        <form action='./running/mark.php' method='post' id='starFormBox'>
                            <input type='hidden' name='galleryId' value='$galleryId'>
                            <input type='hidden' name='todo' value='1'>
                            <button type='submit'><h1>收藏</h1></button>
                        </form>
                    </div>
                ZHOU;
            }
            $outStr .= "</div></div>";
            return $outStr;
        }
        function showEssayUser($username){
            // 展示爪记
            global $link;
            $selectData = new selectData;
            $sqlEssay = "select * from essay where username='$username' order by id DESC";
            $resultEssay = mysqli_query($link,$sqlEssay);
            $outStr = "<div class='rightSide'>";
            while($essay = mysqli_fetch_array($resultEssay)){
                $essayId = $essay["Id"];
                $title = $essay['title'];
                $content = $essay['content'];
                $time = $essay['time'];
                $galleryId = $essay['galleryid'];
                $theGalleryList = $selectData->get_gallery($galleryId);
                $file = $theGalleryList[0];
                $name = $selectData->get_name($username,1);
                $paw = $this->showEssayPaw($essayId);
                if(!$paw){$paw="还没有小兽印爪......";}
                else{$paw .= " 给这篇爪记印爪了！";}
                if(!$file){
                    $outStr .= <<<EOF
                        <div class='essayBox'>
                            <h1>$title</h1>
                            <a href="/user.php?username=$username"><h2>爪记ID$essayId $name</h2></a>
                            <p>$time</p>
                            <p>$content</p>
                            <a href="/running/send.php?essayId=$essayId&todo=5">印爪🐾</a>
                            <p>$paw</p>
                        </div>
                    EOF;
                }else{
                    $outStr .= <<<EOF
                        <div class='essayBox'>
                            <a href="/gallery.php?galleryId=$galleryId"><img src="/gallery/$username/$file" width="100%"></a>
                            <h1>$title</h1>
                            <a href="/user.php?username=$username"><h2>爪记ID$essayId $name</h2></a>
                            <p>$time</p>
                            <p>$content</p>
                            <a href="/running/send.php?essayId=$essayId&todo=5">印爪🐾</a>
                            <p>$paw</p>
                        </div>
                    EOF;
                }
            }
            $outStr .= "</div>";
            return $outStr;
        }
        function showEssayPaw($essayId){
            // 在爪记中显示印爪的小兽
            $selectData = new selectData;
            $outStr = $selectData->get_essayPaw($essayId);
            return $outStr;
        }
        function editPage(){
            // 编辑个兽空间页面
            $furryUser = $_SESSION['username'];
            global $link;
            $sql = "select username,name,info,sex,sort,email from account where username='$furryUser'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $name=$account['name'];$info=$account['info'];$sex=$account['sex'];$sort=$account['sort'];$email=$account['email'];
            require_once "./resource/template/editUser.html";
            return 1;
        }
        function editOtherPage(){
            // 编辑其它页面
            $furryUser = $_SESSION['username'];
            global $link;
            {
                $sql = "select * from board where username='$furryUser'";
                $result = mysqli_query($link,$sql);
                echo"<div class='screen'><div class='txtBox'><h1>粉糖粒子留言板</h1></div>";
                while($board = mysqli_fetch_array($result)){
                    $boardId=$board['Id'];$message=$board['message'];$time=$board['time'];
                    echo <<<ZHOU
                        <div class='formBox'>
                            <div class='txtBox'>
                                <h2>$message</h2>
                                <p>$time</p>
                            </div>
                            <form action='./running/delete.php' method='post' onsubmit="return confirm('删除操作不可逆！')">
                                <input type='hidden' name='boardId' value='$boardId'>
                                <input type='hidden' name='todo' value='1'>
                                <button type='submit'>删除</button>
                            </form>
                        </div>
                    ZHOU;
                }
                echo"</div>";
            }
            {
                $sql = "select * from comments where username='$furryUser'";
                $result = mysqli_query($link,$sql);
                echo"<div class='screen'><div class='txtBox'><h1>画廊评论</h1></div>";
                while($comments = mysqli_fetch_array($result)){
                    $commentId=$comments['Id'];$comment=$comments['comment'];$point=$comments['point'];$time=$comments['time'];
                    echo<<<ZHOU
                        <div class='formBox'>
                            <div class='txtBox'>
                                <h2>$comment</h2>
                                <p>对画廊ID为 $point 的作品评论 $time</p>
                            </div>
                            <form action='./running/delete.php' method='post' onsubmit="return confirm('删除操作不可逆！')">
                                <input type='hidden' name='commentId' value='$commentId'>
                                <input type='hidden' name='todo' value='2'>
                                <button type='submit'>删除</button>
                            </form>
                        </div>
                    ZHOU;
                }
                echo"</div>";
            }
        }
        function lookUser($username){
            // 他兽界面
            include_once "postClass.php";
            $Posts = new Posts();
            $furryUser = $username;
            global $link;
            $sql = "select username,name,info,sex,sort,grade,coin from account where username='$username'";
            $result = mysqli_query($link,$sql);if($result->num_rows==0){return 0;}
            $account = mysqli_fetch_array($result);
            $name=$account['name'];$info=$account['info'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];$coin=$account['coin'];
            $outStr = $this->watchUser($username);
            $outStr .= "<br>";
            $outStr .= $this->showBadges($username);
            $userBox .= "<div class='homePageBox'>";
            $userBox .= "<div class='homePage_leftSide'>";
            $userBox .= $Posts->showPostsUser($furryUser);
            $userBox .= "</div>";
            $userBox .= "<div class='homePage_rightSide'>";
            $userBox .= "<div class='userBox'>";
            $userBox .= $this->showGalleryUser($furryUser);
            $userBox .= $this->showEssayUser($furryUser);
            $userBox .= "</div>";
            $userBox .= "</div>";
            include_once "./resource/template/lookUser.html";
            return 1;
        }
        function watchUser($username){
            // 展示关注情况
            global $link;
            $sql1 = "select * from watch where username='$username'";
            $result1 = mysqli_query($link,$sql1);
            $watcherNum = $result1->num_rows;
            $sql2 = "select * from watch where watcher='$username'";
            $result2 = mysqli_query($link,$sql2);
            $watchNum = $result2->num_rows;
            $outStr = "粉丝$watcherNum 关注$watchNum";
            return $outStr;
        }
        function showBadges($username){
            // 显示徽章
            global $link;
            // $sqlAcc = "select distinct badges_account.*,badges.type from badges_account,badges
            // where badges_account.username='$username'
            // order by badges.type,badges_account.id DESC";
            $sqlAcc = "select * from badges_account where username='$username' order by id DESC";
            $resultAcc = mysqli_query($link,$sqlAcc);
            $outStr = "<div class='userBoxIndex'>";
            while($rowAcc = mysqli_fetch_array($resultAcc)){
                $code = $rowAcc["code"];$approve = $rowAcc["approve"];
                $sqlBadges = "select badge,type from badges where code='$code'";
                $resultBadges = mysqli_query($link,$sqlBadges);
                $badges = mysqli_fetch_array($resultBadges);
                {
                    $badge = $badges["badge"];$type = $badges["type"];
                    $outStr .= $this->outBadge($badge,$type);
                }
            }
            $outStr .= "</div>";
            return $outStr;
        }
        function outBadge($badge,$type){
            // 输出徽章
            $outType = $this->outBadgeType($type);
            $outStr = "";
            if($type=="spectial"){$outStr .= "<span style='color: red;'> $outType-$badge </span>";}
            else if($type==1){$outStr .= "<span style='color: yellow;'> $outType-$badge </span>";}
            else if($type==2){$outStr .= "<span style='color: blue;'> $outType-$badge </span>";}
            else if($type==3){$outStr .= "<span style='color: green;'> $badge </span>";}
            return $outStr;
        }
        function outBadgeType($type){
            // 输出徽章的类型
            $outStr = "";
            if($type==1){$outStr="创作认证";}
            else if($type==2){$outStr="身份认证";}
            else if($type==3){$outStr="常规";}
            else if($type=="spectial"){$outStr="特殊";}
            return $outStr;
        }
    }
    class otherPage {
        // 其他页面输出
        function boardForm(){
            // 留言板页面
            $file_url = "./resource/template/boardForm.html";
            $zzww = file_get_contents($file_url);
            echo $zzww;
            return 1;
        }
        function board(){
            // 留言板
            global $link;
            $sql = "select * from board order by id DESC";
            $result = mysqli_query($link,$sql);
            echo "<div class='screen'><div class='boardBox'>";
            while($board=mysqli_fetch_array($result)){
                $username = $board['username'];
                $message = $board['message'];
                $sqlUser = "select name,sex,sort,grade from account where username='$username'";
                $resultAcc = mysqli_query($link,$sqlUser);
                $account = mysqli_fetch_array($resultAcc);
                $name=$account['name'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];
                $userZone = new userZone;
                $badges = $userZone->showBadges($username);
                echo "
                    <div class='txtBox'>
                        <p>爪爪 <a href='./user.php?username=$username'>$name</a> $sex $sort</p>
                        <p>$badges</p>
                        <h2>$message</h2>
                    </div>
                ";
            }
            echo "</div></div>";
        }
        function showStar($furryUser){
            // 显示小兽的收藏
            $outStr = "<div class='screen'><div class='homePageBox'>";
            $outStr .= "<div class='homePage_leftSide'>";
            $outStr .= $this->postStar($furryUser);
            $outStr .= "</div>";
            $outStr .= "<div class='homePage_rightSide'>";
            $outStr .= $this->galleryStar($furryUser);
            $outStr .= "</div>";
            $outStr .= "</div></div>";
            return $outStr;
        }
        function galleryStar($furryUser){
            // 我收藏的画廊
            include_once "galleryClass.php";
            $furryArt = new furryArt;
            global $link;
            {
                $sql = "select * from star where username='$furryUser' order by id DESC";
                $result = mysqli_query($link,$sql);
            }
            {
                $sqlAcc = "select name from account where username='$furryUser' order by id DESC";
                $resultAcc = mysqli_query($link,$sqlAcc);
                $account = mysqli_fetch_array($resultAcc);
                $theName = $account['name'];    
            }
            $outStr = "";
            $outStr .= "<div class='screen'><div class='txtBox'><h2>$theName 收藏的画廊</h2></div></div><div class='galleryBox'>";
            while($star = mysqli_fetch_array($result)){
                $starId=$star['Id'];$galleryId=$star['galleryid'];$time=$star['time'];
                {
                    $sqlGallery = "select * from gallery where id='$galleryId'";
                    $resultGallery = mysqli_query($link,$sqlGallery);
                    $gallery = mysqli_fetch_array($resultGallery);
                    $username = $gallery['username'];
                    $file = $gallery['file'];
                    $title = $gallery['title'];
                    $info = $gallery['info'];
                    $type = $gallery['type'];
                    $visit = $gallery['visit'];
                }
                {
                    $sqlAcc = "select name,sex,sort,grade from account where username='$username' order by id DESC";
                    $resultAcc = mysqli_query($link,$sqlAcc);
                    $account = mysqli_fetch_array($resultAcc);
                    $name=$account['name'];$sex=$account['sex'];$sort=$account['sort'];$grade=$account['grade'];    
                }
                {
                    $sqlStar = "select galleryid from star where galleryid='$galleryId' order by id DESC";
                    $resultStar = mysqli_query($link,$sqlStar);
                    $starNum = mysqli_num_rows($resultStar);
                }
                $imgSrc = $furryArt->identifyVisit($visit,$username,$file);
                $outType = $furryArt->identifyType($type);
                $outStr .= <<<ZHOU
                    <div class="showGalleryIndex">
                        <a href="gallery.php?galleryId=$galleryId"><img src="$imgSrc" alt="$imgSrc"></a>
                        <a href="gallery.php?galleryId=$galleryId"><h1>$title</h1></a>
                        <h2>画廊ID$galleryId $outType 收藏$starNum</h2>
                        <p>$info</p>
                        <p>收藏时间$time</p>
                        <form action="./running/delete.php" method="post" onsubmit="return confirm('确定吗？别错过宝藏哦')" id="starFormBox">
                            <input type="hidden" name="starId" value="$starId">
                            <input type="hidden" name="todo" value="3">
                            <button type="submit">丢弃</button>
                        </form>
                    </div>
                ZHOU;
            }
            $outStr .= "</div>";
            return $outStr;
        }
        function postStar($furryUser){
            // 显示小兽的收藏帖
            include_once "dbClass.php";
            $selectData = new selectData;
            $postIdList = $selectData->get_postStar($furryUser);
            $furryUserList = $selectData->get_name($furryUser,2);
            $name = $furryUserList[0];
            $outStr = "<div class='gardenBox'><div class='txtBox'><h2>$name 收藏的帖子</h2></div><div class='theGarden'>";
            for($i=0;$postIdList[$i];$i++){
                $postId = $postIdList[$i];
                $thePostList = $selectData->getPost($postId);
                $username = $thePostList[0];
                $theUserList = $selectData->get_name($username,2);
                $name=$theUserList[0];$sex=$theUserList[2];$sort=$theUserList[3];
                $title = $thePostList[1];
                $subtitle = $thePostList[2];
                $content = $thePostList[3];
                $galleryId = $thePostList[4];
                $postImgId = $thePostList[5];
                $pawNum = $thePostList[6];
                $createdTime = $thePostList[7];
                $updateTime = $thePostList[8];
                $outStr .= <<<EOF
                    <div class='theGardenPost'>
                        <a href="./posts.php?postId=$postId"><h1>$title</h1></a>
                        <h2>$subtitle</h2>
                        <h2>$name $sex $sort</h2>
                        <h2>印爪数 $pawNum</h2>
                        <p>$content</p>
                        <p>$postId $updateTime</p>
                        <form action="./running/delete.php" method="post" onsubmit="return confirm('确定吗？别错过宝藏哦')">
                            <input type="hidden" name="postId" value="$postId">
                            <input type="hidden" name="username" value="$furryUser">
                            <input type="hidden" name="todo" value="7">
                            <button type="submit">丢弃</button>
                        </form>
                    </div>
                EOF;
            }
            $outStr .= "</div></div>";
            return $outStr;
        }
        function tags(){
            // 标签墙纸页面
            include_once "dbClass.php";
            include_once "examineClass.php";
            $selectData = new selectData;
            $userState = new userState;
            $num1 = $userState->checkLogin();
            $viewNum=40;
            if($num1==1){
                $viewNum = $_SESSION['view'];
                $_SESSION['view'] = $viewNum+5;
            }
            $tagList = $selectData->getTags($viewNum);
            $file_url = "./resource/template/tagsForm.html";
            $outStr = file_get_contents($file_url);
            $outStr .= "<div class='screen'><div class='boardBox'>";
            for($i=0;$tagList[$i];$i++){
                $theTag = $tagList[$i];
                $outStr .= <<<EOF
                    <div class='txtBox'>
                        <button onclick="searchTheTag('$theTag')" style='width: 100%;'><h1>$theTag</h1></button>
                    </div>
                EOF;
            }
            $outStr .= "</div></div>";
            return $outStr;
        }
        function watch($username=""){
            // 关注页面
            require_once "galleryClass.php";
            $furryArt = new furryArt;
            global $link;
            $furryUser = $_SESSION['username'];
            if(!$username){$username=$furryUser;}
            $sqlWatcher = "select * from watch where username='$username' order by id DESC";
            $resultWatcher = mysqli_query($link,$sqlWatcher);
            $sqlWatch = "select * from watch where watcher='$username' order by id DESC";
            $resultWatch = mysqli_query($link,$sqlWatch);
            $sqlAcc = "select name from account where username='$username' order by id DESC";
            $resultAcc = mysqli_query($link,$sqlAcc);
            $account = mysqli_fetch_array($resultAcc);
            $theName = $account['name'];
            echo "<div class='screen'><div class='txtBox'><h2>$theName 的粉丝</h2>";
            while($watchWatcher = mysqli_fetch_array($resultWatcher)){
                $watcher = $watchWatcher['watcher'];
                $sql = "select username,name,info,sex,sort from account where username='$watcher'";
                $result = mysqli_query($link,$sql);
                $account = mysqli_fetch_array($result);
                $theUser=$account['username'];
                $name=$account['name'];$info=$account['info'];
                $sex=$account['sex'];$sort=$account['sort'];
                echo "
                    <div class='txtBox'>
                        <a href='user.php?username=$theUser'><h1>$name</h1></a>
                        <h2>$theUser $sex $sort</h2>
                        <p>$info</p>
                ";
                {
                    // 显示画廊
                    $sqlGallery = "select * from gallery where username='$theUser' order by id DESC";
                    $resultGallery = mysqli_query($link,$sqlGallery);
                    if($resultGallery->num_rows<1){echo"<p>这位小兽还没发过画廊哦</p>";}
                    echo "<div class='previewGallery'>";
                    for($i=0;$i<3;$i++){
                        $gallery=mysqli_fetch_array($resultGallery);
                        if(empty($gallery)){break;}
                        $galleryId = $gallery["Id"];
                        $file = $gallery["file"];
                        $title = $gallery["title"];
                        $visit = $gallery["visit"];
                        $imgSrc = $furryArt->identifyVisit($visit,$theUser,$file);
                        echo "
                            <div class='imgBox'>
                                <a href='gallery.php?galleryId=$galleryId'><img src='$imgSrc' alt='$imgSrc'></a>
                                <div class='galleryTitle'>$title</div>
                            </div>
                        ";
                    }
                    echo "</div></div>";
                }
            }
            echo "<h2>$theName 的关注</h2>";
            while($watchWatch = mysqli_fetch_array($resultWatch)){
                $watch = $watchWatch['username'];
                $sql = "select username,name,info,sex,sort from account where username='$watch'";
                $result = mysqli_query($link,$sql);
                $account = mysqli_fetch_array($result);
                $theUser=$account['username'];
                $name=$account['name'];$info=$account['info'];
                $sex=$account['sex'];$sort=$account['sort'];
                echo "
                    <div class='txtBox'>
                        <a href='user.php?username=$theUser'><h1>$name</h1></a>
                        <h2>$theUser $sex $sort</h2>
                        <p>$info</p>
                ";
                {
                    // 显示画廊
                    $sqlGallery = "select * from gallery where username='$theUser' order by id DESC";
                    $resultGallery = mysqli_query($link,$sqlGallery);
                    if($resultGallery->num_rows<1){echo"<p>这位小兽还没发过画廊哦</p>";}
                    echo "<div class='previewGallery'>";
                    for($i=0;$i<3;$i++){
                        $gallery=mysqli_fetch_array($resultGallery);
                        if(empty($gallery)){break;}
                        $galleryId = $gallery["Id"];
                        $file = $gallery["file"];
                        $title = $gallery["title"];
                        $visit = $gallery["visit"];
                        $imgSrc = $furryArt->identifyVisit($visit,$theUser,$file);
                        echo "
                            <div class='imgBox'>
                                <a href='gallery.php?galleryId=$galleryId'><img src='$imgSrc' alt='$imgSrc'></a>
                                <div class='galleryTitle'>$title</div>
                            </div>
                        ";
                    }
                    echo "</div></div>";
                }
            }
            echo "</div></div>";
        }
    }
    class Statement {
        // 报告
        function homePage1(){
            // 引导登录
            $outStr = <<<EOF
                <div class="screen">
                    <div class="statementBox">
                        登录粉糖粒子才能使用功能
                    </div>
                </div>
            EOF;
            return $outStr;
        }
        function admin1(){
            // 阻止进入管理界面
            $outStr = <<<EOF
                <div class="screen">
                    <div class="statementBox">
                        非管理兽不得进入管理界面
                    </div>
                </div>
            EOF;
            return $outStr;
        }
        function login1(){
            // 登录失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        登录失败 即将返回<br>
                        可能的原因<br>
                        1 未输入内容<br>
                        2 密码、粉糖账号或邮箱不正确<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function login2(){
            // 密码重置失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        密码重置失败 即将返回<br>
                        可能的原因<br>
                        1 未输入内容<br>
                        2 找不到邮箱<br>
                        3 验证码不正确<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function login3(){
            // 阻止未登录就操作
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        操作被阻止 即将返回<br>
                        请先登录<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function login4(){
            // 查看更多内容时引导登录
            $outStr = <<<EOF
                <div class="statementBox">
                    PINKCANDY报告<br>
                    <a href="/login.php">登录</a>可以查看更多内容<br>
                </div>
            EOF;
            return $outStr;
        }
        function register1(){
            // 注册失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        注册失败 即将返回<br>
                        可能的原因<br>
                        1 未输入必填内容<br>
                        2 粉糖账号必须为五位数字<br>
                        3 邮箱不合法<br>
                        4 这个粉糖账号已被使用<br>
                        5 这个邮箱已被使用<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function delete1(){
            // 删除失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        删除失败 即将返回<br>
                        可能的原因<br>
                        1 只能删除自己发布的内容或关联的数据<br>
                        2 找不到要删除的目标<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function insert1(){
            // 添加失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        添加失败 即将返回<br>
                        可能的原因<br>
                        1 不能重复添加<br>
                        2 找不到要添加的目标<br>
                        3 不能添加空内容<br>
                        4 未登录<br>
                        5 发送的内容不符合要求<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function insert2(){
            // 帖子发布失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        帖子发布失败 即将返回<br>
                        可能的原因<br>
                        1 至少输入标题和内容<br>
                        2 只能上传不大于5M的图片文件（仅支持'jpg','gif','jpeg','png'）<br>
                        3 不能添加空内容<br>
                        4 未登录<br>
                        5 画廊不存在<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function insert3(){
            // 跟帖发布失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        跟帖发布失败 即将返回<br>
                        可能的原因<br>
                        1 至少输入内容<br>
                        2 只能上传不大于5M的图片文件（仅支持'jpg','gif','jpeg','png'）<br>
                        3 不能添加空内容<br>
                        4 未登录<br>
                        5 画廊不存在<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function insert4(){
            // 跟帖回复失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        跟帖回复失败 即将返回<br>
                        可能的原因<br>
                        1 至少输入内容<br>
                        2 未登录<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function insert5(){
            // 收藏失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        收藏失败 即将返回<br>
                        可能的原因<br>
                        1 已经收藏了<br>
                        2 未登录<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,5000);
                </script>
            EOF;
            return $outStr;
        }
        function show1(){
            // 展示失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        展示失败 即将返回<br>
                        可能的原因<br>
                        1 找不到目标数据<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function ok1(){
            // 已经印爪
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        印爪失败 即将返回<br>
                        可能的原因<br>
                        1 已经印爪啦～<br>
                        2 未登录<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,3000);
                </script>
            EOF;
            return $outStr;
        }
        function edit1(){
            // 编辑个兽信息失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        编辑个兽信息失败 即将返回<br>
                        可能的原因<br>
                        1 邮箱 性别 种族 是必填的<br>
                        2 邮箱不合法<br>
                        3 这个邮箱已被使用<br>
                        4 硬币不足<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
        function edit2(){
            // 编辑画廊失败
            $outStr = <<<EOF
                <head><link rel="stylesheet" href="../css/style.css"></head>
                <div class="screen">
                    <div class="statementBox">
                        PINKCANDY报告<br>
                        编辑画廊失败 即将返回<br>
                        可能的原因<br>
                        1 标题 类型 浏览分级 是必填的<br>
                        2 硬币不足<br>
                    </div>
                </div>
                <script>
                    function jumpBack(){window.history.go(-1);}
                    setTimeout(jumpBack,10000);
                </script>
            EOF;
            return $outStr;
        }
    }
}