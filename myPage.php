<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    session_start();
    $username = $_SESSION['username'];
    echo "<title>$username 的个兽空间</title>";
    ?>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <?php
                session_start();
                $username = $_SESSION['username'];
                echo "<h1>$username 的个兽空间</h1>";
            ?>
        </div>
        <div class="divBasic">
            <?php
                session_start();
                $username = $_SESSION['username'];
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "
                select *
                from account
                where username='$username'
                ";
                $result = mysqli_query($link,$sql);
                $resultArray = mysqli_fetch_array($result);
                if($username==$_SESSION['username']){
                    {
                        $id = $resultArray['Id'];
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

                        echo <<<ZHOU
                            <div class="divContentWiden" style="display: flex;">
                                <div class="divSpectial" style="width: 20%;">
                                    <img src="./headimg/$headimg" width="100%" onerror="this.src='./fileLibrary/images/headimg.png'">
                                </div>
                                <div class="divSpectial" style="width: 80%;">
                                    <img src="./backimg/$backimg" width="100%" onerror="this.src='./fileLibrary/images/backimg.png'">
                                </div>
                            </div>
                            <div class="divSpectial">
                                <div class="divTitle"><h2>$name 粉糖账号$username 粉糖ID$id ⭐$starnum 🍬$candynum</h2></div>
                                <p>$signature</p>
                                <p>一只 $sex 性 $furrytype QQ:$qq</p>
                                <p>$jointime 加入粉糖粒子</p>
                                <div class="divButton">
                                    <button><a href="./ZZWWcontrol.php">管理兽</a></button>
                                    <button><a href="./edit.php">修改</a></button>
                                    <form action="runLogout.php" method="POST">
                                        <button type="submit">注销</button>
                                    </form>
                                </div>
                            </div>
                        ZHOU;
                    }
                }
            ?>
            <?php
                session_start();
                $username = $_SESSION['username'];
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
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
                        $username = $_SESSION['username'];
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
                                        <img src='./headimg/$headimg' width='20%' onerror="this.src='./fileLibrary/images/headimg.png'">
                                        $name
                                    </p>
                                    <form action="addClaw.php" method="POST">
                                        <input type="hidden" name="theWork" value="$id">
                                        <input type="hidden" name="theType" value="$theType">
                                        <p>$time ID:$id 印爪🐾<input type="submit" name="claw" value="$claw"></p>
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
                                    <p><img src='./headimg/$headimg' width='10%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
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
                        $username = $_SESSION['username'];
                        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                        $sql = "
                        select furrygallery.id,account.username,account.name,furrygallery.username,furrygallery.title,furrygallery.info,furrygallery.img,furrygallery.type,furrygallery.time,furrygallery.claw,account.headimg
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
                                <div class="divInputZone">
                                    <form action="searchDraw.php" method="POST">
                                        <input type="submit" name="search" value="$title">
                                        <p>类型 $type</p>
                                        $time
                                    </form>
                                </div>
                                <form action="addClaw.php" method="POST">
                                    <input type="hidden" name="theWork" value="$id">
                                    <input type="hidden" name="theType" value="$theType">
                                    <p>印爪🐾<input type="submit" name="claw" value="$claw"></p>
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

                        $username = $_SESSION['username'];
                        $sql = "
                        select *
                        from account
                        where username='$username'
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);
                        $resultArray = mysqli_fetch_array($result);
                        $myself_id = $resultArray["Id"];
                        $sql = "
                        select account.username,account.name,account.headimg,sendcandy.sender,sendcandy.candynum,sendcandy.time
                        from account,sendcandy
                        where sendcandy.receiver_id='$myself_id' and account.username=sendcandy.sender
                        order by time DESC
                        ";
                        $result = mysqli_query($link,$sql);

                        echo "
                        <div class='leftSide'>
                        <div class='divBasic'>
                        <div class='divTitle'><h2>星星瓶</h2></div>
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
                            <br>
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
                            <div class="divInputZone">
                                <form action="runLogin.php" method="POST">
                                    <input type="text" name="username" placeholder="粉糖账号"><br/>
                                    <input type="password" name="password" placeholder="密码"><br/>
                                    <button type="submit">登录</button>
                                    <a href="./register.php">注册</a>
                                </form>
                            </div>
                        </div>
                    ZHOU;
                }
            ?>
        </div>
    </div>
</body>
</html>