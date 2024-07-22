<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 查找小兽</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>ZZWW 查找小兽</h1>
        </div>
        <div class="divBasic">
            <?php
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $search = $_POST["search"];
                $searchAccount = $_POST["searchAccount"];
                if($search!=null){
                    $sql = "
                    select *
                    from account
                    where username = '$search'
                    ";
                    $result = mysqli_query($link,$sql);
                    $resultArray = mysqli_fetch_array($result);    
                }
                else if($searchAccount!=null){
                    $sql = "
                    select *
                    from account
                    where username='$searchAccount' or id='$searchAccount'
                    ";
                    $result = mysqli_query($link,$sql);
                    $resultArray = mysqli_fetch_array($result);
                }
                else{
                    die("<h2>ZZWW 获取搜索文本失败</h2>");
                }
                $theUsername = $resultArray['username'];

                $id = $resultArray['Id'];
                $username = $resultArray['username'];
                $name = $resultArray['name'];
                $sex = $resultArray['sex'];
                $furrytype = $resultArray['furrytype'];
                $headimg = $resultArray['headimg'];
                $backimg = $resultArray['backimg'];
                $signature = $resultArray['signature'];
                $qq = $resultArray['qq'];
                $controlnum = $resultArray['controlnum'];
                $jointime = $resultArray['jointime'];
                $starnum = $resultArray['starnum'];
                $candynum = $resultArray['candynum'];

                if($id==null){
                    exit("<h2>ZZWW 无此搜索结果</h2>");
                }

                echo <<<ZHOU
                    <div class="divContentWiden" style="display: flex;">
                        <div class="divSpectial" style="width: 25%;">
                            <img src="./headimg/$headimg" width="100%" onerror="this.src='./fileLibrary/images/headimg.png'">
                        </div>
                        <div class="divSpectial" style="width: 75%;">
                            <img src="./backimg/$backimg" width="100%" onerror="this.src='./fileLibrary/images/backimg.png'">
                        </div>
                    </div>
                    <div class="divSpectial">
                        <div class="divTitle"><h2>$name 粉糖账号$username 粉糖ID:$id ⭐$starnum 🍬$candynum</h2></div>
                        <p>$signature</p>
                        <p>一只 $sex 性 $furrytype QQ:$qq</p>
                        <p>$jointime 加入粉糖粒子</p>
                    </div>
                ZHOU;

                if($username!=null){
                    {
                        // 留言板
                        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                        $sql = "
                        select account.username,account.name,zzwwboard.id,zzwwboard.username,zzwwboard.content,zzwwboard.img,zzwwboard.time
                        from account,zzwwboard
                        where account.username=zzwwboard.username and account.username='$username'
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);
                        echo "
                        <div class='leftSide'>
                        <div class='divTitle'><a href='zzwwboard.php'><h2>ZZWW留言板</h2></a></div>
                        ";
                        $showNum = 0;
                        while($resultArray = mysqli_fetch_array($result)){
                            $showNum += 1; 

                            $name = $resultArray['name'];
                            $content = $resultArray['content'];
                            $img = $resultArray['img'];
                            $time = $resultArray['time'];
            
                            echo<<<ZHOU
                                    <p>$name:$content</p>
                                    <img src='./zzwwboardimg/$img' width='100%' onerror="this.src='./fileLibrary/images/board.png'">
                                    $time
                            ZHOU;
                            if($showNum>19){
                                break;
                            }
                        }
                        echo "
                        <div class='divEnd'><p>仅展示最近20条</p></div>
                        </div>
                        ";
                    }
                    {
                        // 图文专栏
                        $username = $theUsername;
                        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                        $sql = "
                        select phpcolumn.id,account.username,account.name,phpcolumn.username,phpcolumn.content,phpcolumn.title,phpcolumn.img,phpcolumn.time,phpcolumn.claw,account.headimg
                        from account,phpcolumn
                        where account.username=phpcolumn.username and account.username='$username'
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);

                        echo "
                        <div class='leftSide'>
                        <div class='divTitle'><a href='phpcolumn.php'><h2>图文专栏</h2></a></div>
                        ";
                        $showNum = 0;
                        while($resultArray = mysqli_fetch_array($result)){
                            $showNum += 1; 
                            $id = $resultArray['id'];
                            $name = $resultArray['name'];
                            $title = $resultArray['title'];
                            $content = $resultArray['content'];
                            $img = $resultArray['img'];
                            $time = $resultArray['time'];
                            $claw = $resultArray['claw'];
                            $theType = 'column';
                            $headimg = $resultArray['headimg'];

                            echo<<<ZHOU
                                <h2>$title</h2>
                                <p>$content</p>
                                <img src='./phpcolumnimg/$img' width='100%' onerror="this.src='./fileLibrary/images/column.png'">
                                <div class='divSpectial'>
                                    <p>
                                        <img src='./headimg/$headimg' width='30%' onerror="this.src='./fileLibrary/images/headimg.png'">
                                        $name
                                    </p>
                                    <form action="addClaw.php" method="POST">
                                        <input type="hidden" name="theWork" value="$id">
                                        <input type="hidden" name="theType" value="$theType">
                                        <p>$time 图文ID:$id 印爪🐾<input type="submit" name="claw" value="$claw"></p>
                                    </form>
                                </div>
                            ZHOU;

                            $commentSql = "
                            select phpcolumn.id,comment.sender,comment.work_id,comment.comment,comment.type,comment.time,account.headimg,account.username,account.name
                            from comment,phpcolumn,account
                            where phpcolumn.id=comment.work_id and account.username=comment.sender
                            order by time DESC
                            ";
                            $commentResult = mysqli_query($link,$commentSql);
            
                            echo "
                            <div class='divContentWiden'>
                            ";

                            echo<<<ZHOU
                                <form action="commentColumn.php" method="POST" enctype="multipart/form-data">
                                    <textarea name="comment" id="comment" cols="20" rows="2" placeholder="评论"></textarea>
                                    <input type="hidden" name="id" value="$id">
                                    <button type="submit">发送</button>
                                </form>
                            ZHOU;

                            while($commentResultArray = mysqli_fetch_array($commentResult)){
                                $sender = $commentResultArray['sender'];
                                $name = $commentResultArray['name'];
                                $comment = $commentResultArray['comment'];
                                $type = $commentResultArray['type'];
                                $commentTime = $commentResultArray['time'];
                                $theId = $commentResultArray['work_id'];
                                $headimg = $commentResultArray['headimg'];
                                if($theId==$id&&$type=='column'){
                                    echo "
                                    <p><img src='./headimg/$headimg' width='20%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                                    时间 $commentTime
                                    ";
                                }
                            }
                            echo "</div>";
                            if($showNum>9){
                                break;
                            }
                        }
                        echo "
                        <div class='divEnd'><p>仅展示最近10条</p></div>
                        </div>
                        ";    
                    }
                    {
                        // 毛绒画廊
                        $username = $theUsername;
                        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                        $sql = "
                        select furrygallery.id,account.username,furrygallery.username,furrygallery.title,furrygallery.info,furrygallery.img,furrygallery.type,furrygallery.time,furrygallery.claw,account.headimg,account.name
                        from account,furrygallery
                        where account.username=furrygallery.username and account.username='$username'
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);

                        echo "
                        <div class='leftSide'>
                        <div class='divTitle'><a href='furrygallery.php'><h2>毛绒画廊</h2></a></div>
                        ";
                        $showNum = 0;
                        while($resultArray = mysqli_fetch_array($result)){
                            $showNum += 1; 
                            $id = $resultArray['id'];
                            $name = $resultArray['name'];
                            $title = $resultArray['title'];
                            $info = $resultArray['info'];
                            $img = $resultArray['img'];
                            $type = $resultArray['type'];
                            $time = $resultArray['time'];
                            $claw = $resultArray['claw'];
                            $theType = 'gallery';
                            $headimg = $resultArray['headimg'];
                            echo<<<ZHOU
                                <h2>$title</h2>
                                <img src='./furrygalleryimg/$img' alt='$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'">
                                <p>$info</p>
                                <div class='divSpectial'>
                                <img src='./headimg/$headimg' alt='$headimg' width='30%' onerror="this.src='./fileLibrary/images/headimg.png'"><p>$name</p>
                                <form action="searchDraw.php" method="POST">
                                    <input type="submit" name="search" value="$title">
                                    <p>类型 $type</p>
                                    $time
                                </form>
                                <form action="addClaw.php" method="POST">
                                    <input type="hidden" name="theWork" value="$id">
                                    <input type="hidden" name="theType" value="$theType">
                                    <p>画廊ID:$id 印爪🐾<input type="submit" name="claw" value="$claw"></p>
                                </form>
                                </div>
                            ZHOU;

                            $commentSql = "
                            select furrygallery.id,comment.sender,comment.work_id,comment.comment,comment.type,comment.time,account.headimg,account.username,account.name
                            from comment,furrygallery,account
                            where furrygallery.id=comment.work_id and account.username=comment.sender
                            order by time DESC
                            ";
                            $commentResult = mysqli_query($link,$commentSql);
            
                            echo "
                            <div class='divContentWiden'>
                            ";

                            echo<<<ZHOU
                                <form action="commentGallery.php" method="POST" enctype="multipart/form-data">
                                    <textarea name="comment" id="comment" cols="20" rows="2" placeholder="评论"></textarea>
                                    <input type="hidden" name="id" value="$id">
                                    <button type="submit">发送</button>
                                </form>
                            ZHOU;

                            while($commentResultArray = mysqli_fetch_array($commentResult)){
                                $sender = $commentResultArray['sender'];
                                $name = $commentResultArray['name'];
                                $comment = $commentResultArray['comment'];
                                $type = $commentResultArray['type'];
                                $commentTime = $commentResultArray['time'];
                                $theId = $commentResultArray['work_id'];
                                $headimg = $commentResultArray['headimg'];
                                if($theId==$id&&$type=='gallery'){
                                    echo "
                                    <p><img src='./headimg/$headimg' width='20%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                                    时间 $commentTime
                                    ";
                                }
                            }
                            echo "</div>";
                            if($showNum>19){
                                break;
                            }
                        }
                        echo "
                        <div class='divEnd'><p>仅展示最近20条</p></div>
                        </div>
                        ";  
                    }
                    {
                        // 星星瓶

                        $username = $theUsername;
                        $sql = "
                        select *
                        from account
                        where username='$username'
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);
                        $resultArray = mysqli_fetch_array($result);
                        $myself_id = $resultArray["Id"];
                        $starnum = $resultArray["starnum"];
                        $sql = "
                        select account.username,account.name,account.headimg,sendcandy.sender,sendcandy.candynum,sendcandy.time
                        from account,sendcandy
                        where sendcandy.receiver_id='$myself_id' and account.username=sendcandy.sender
                        order by time DESC
                        ";
                        $result = mysqli_query($link,$sql);

                        echo "
                        <div class='leftSide'>
                        <div class='divTitle'><h2>星星瓶</h2></div>
                        ";
                        echo <<<ZHOU
                            <form action="sendCandy.php" method="POST">
                                <input type="hidden" name="id" value="$myself_id">
                                <input type="hidden" name="starnum" value="$starnum">
                                <button type="submit">🍬赠送糖果！</button>
                            </form>
                        ZHOU;

                        echo "
                        <div class='divBasic'>
                        ";
                        while($resultArray = mysqli_fetch_array($result)){
                            $sender = $resultArray['sender'];
                            $name = $resultArray['name'];
                            $candynum = $resultArray['candynum'];
                            $time = $resultArray['time'];
                            $headimg = $resultArray['headimg'];
                            echo "
                            <div class='divSpectial'>
                            <img src='./headimg/$headimg' width='20%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">
                            <p>$sender $name</p>
                            </div>
                            于 $time
                            <br>
                            赠送了 $candynum 个糖果!
                            ";
                        }
                        echo "
                        </div>
                        </div>
                        ";     
                    }
                }
                else{
                    echo <<<ZHOU
                        <h2>粉糖粒子🍬&nbsp;让世界变成四脚兽的样子xwx</h2>
                        <div class="divSpectial">
                            <form action="runLogin.php" method="POST">
                                <input type="text" name="username" placeholder="粉糖账号"><br/>
                                <input type="password" name="password" placeholder="密码"><br/>
                                <button type="submit">登录</button>
                                <a href="./register.php">注册</a>
                            </form>
                        </div>
                    ZHOU;
                }
            ?>
        </div>
    </div>
</body>
</html>