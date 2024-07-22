<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 图文专栏</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div id="divMenu">
            <a href="#top">ZZWW</a>
            <a href="./zzwwboard.php">📃留言板</a>
            <a href="./phpcolumn.php">📰图文专栏</a>
            <a href="./furrygallery.php">🖼️毛绒画廊</a>
        </div>
        <div class="divBasic" id="top">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>图文专栏</h1>
        </div>
        <div class="divBasic">
            <div class="divSpectial">
                <div class="divInputZone">
                    <form action="updateColumn.php" method="POST" enctype="multipart/form-data">
                        <textarea name="title" id="title" cols="20" rows="2" placeholder="标题"></textarea><br>
                        <textarea name="content" id="content" cols="20" rows="4" placeholder="内容"></textarea><br>
                        <p>附图<input type="file" name="file"><button type="submit">发送</button></p>
                    </form>
                </div>
            </div>
            <?php
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "
                select *
                from account
                ";
                $result = mysqli_query($link,$sql);
                $resultArray = mysqli_fetch_array($result);
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
                $controlnum = $resultArray['controlnum'];

                if($username!=null){
                    {
                        // 图文
                        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                        $sql = "
                        select phpcolumn.id,account.username,account.name,phpcolumn.username,phpcolumn.content,phpcolumn.title,phpcolumn.img,phpcolumn.time,phpcolumn.claw,account.headimg
                        from account,phpcolumn
                        where account.username=phpcolumn.username
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);
                        
                        echo "
                        <div class='divTitle'><h2>图文专栏</h2></div>
                        <div class='divContentWiden' style='display: flex; flex-wrap: wrap;'>
                        ";
                        while($resultArray = mysqli_fetch_array($result)){
                            $showNum += 1;
                            $username = $resultArray['username'];
                            $name = $resultArray['name'];
                            $title = $resultArray['title'];
                            $content = $resultArray['content'];
                            $img = $resultArray['img'];
                            $time = $resultArray['time'];
                            $claw = $resultArray['claw'];
                            $work_id = $resultArray['id'];
                            $headimg = $resultArray['headimg'];
                            $theType = 'column';
                            $claw = $resultArray['claw'];

                            $myself = $_SESSION['username'];
                            echo "<div class='divContent'>";
                            if($username==$myself){
                                echo<<<ZHOU
                                    <h2>$title</h2>
                                    <p>$content</p>
                                    <img src='./phpcolumnimg/$img' width='100%' onerror="this.src='./fileLibrary/images/column.png'">
                                    <div class='divSpectial'>
                                        <form action="searchAccount.php" method="POST">
                                            <img src='./headimg/$headimg' width='20%' onerror="this.src='./fileLibrary/images/headimg.png'">
                                            <input type="hidden" name="search" value="$username">
                                            <button type="submit">$name</button>
                                        </form>
                                        <form action="addClaw.php" method="POST">
                                            <input type="hidden" name="theWork" value="$work_id">
                                            <input type="hidden" name="theType" value="$theType">
                                            <input type="hidden" name="claw" value="$claw">
                                            <p>$time 图文ID:$work_id 印爪🐾$claw<button type="submit">🐾</button></p>
                                        </form>
                                        <form action="delContent.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('确认删除？这将丢失15个糖果！')">
                                            <input type="hidden" name="delId" value="$work_id">
                                            <input type="hidden" name="delType" value="column">
                                            <button type="submit">删除</button>
                                        </form>
                                    </div>
                                ZHOU;
                            }
                            else{
                                echo<<<ZHOU
                                    <h2>$title</h2>
                                    <p>$content</p>
                                    <img src='./phpcolumnimg/$img' width='100%' onerror="this.src='./fileLibrary/images/column.png'">
                                    <div class='divSpectial'>
                                        <form action="searchAccount.php" method="POST">
                                            <img src='./headimg/$headimg' width='20%' onerror="this.src='./fileLibrary/images/headimg.png'">
                                            <input type="hidden" name="search" value="$username">
                                            <button type="submit">$name</button>
                                        </form>
                                        <form action="addClaw.php" method="POST">
                                            <input type="hidden" name="theWork" value="$work_id">
                                            <input type="hidden" name="theType" value="$theType">
                                            <input type="hidden" name="claw" value="$claw">
                                            <p>$time 图文ID:$work_id 印爪🐾$claw<button type="submit">🐾</button></p>
                                        </form>
                                    </div>
                                ZHOU;
                            }

                            $commentSql = "
                            select phpcolumn.id,comment.sender,comment.work_id,comment.comment,comment.type,comment.time,account.headimg,account.username,account.name
                            from comment,phpcolumn,account
                            where phpcolumn.id=comment.work_id and account.username=comment.sender
                            order by time DESC
                            ";
                            $commentResult = mysqli_query($link,$commentSql);
                            
                            echo "<div class='divSpectial'>";

                            echo<<<ZHOU
                                <div class="divInputZone">
                                    <form action="commentColumn.php" method="POST" enctype="multipart/form-data">
                                        <textarea name="comment" id="comment" cols="20" rows="2" placeholder="评论"></textarea>
                                        <input type="hidden" name="id" value="$work_id">
                                        <button type="submit">发送</button>
                                    </form>
                                </div>
                            ZHOU;

                            while($commentResultArray = mysqli_fetch_array($commentResult)){
                                $sender = $commentResultArray['sender'];
                                $name = $commentResultArray['name'];
                                $comment = $commentResultArray['comment'];
                                $type = $commentResultArray['type'];
                                $commentTime = $commentResultArray['time'];
                                $theId = $commentResultArray['work_id'];
                                $headimg = $commentResultArray['headimg'];
                                if($theId==$work_id&&$type=='column'){
                                    echo "
                                    <p><img src='./headimg/$headimg' width='10%' onerror=\"this.src='./fileLibrary/images/headimg.png'\">$name:$comment</p>
                                    时间 $commentTime
                                    ";
                                }
                            }
                            echo "
                            </div>
                            </div>
                            ";
                            if($showNum>19){
                                break;
                            }
                        }
                        echo "
                        </div>
                        <div class='divEnd'><p>仅展示最近20条</p></div>
                        ";
                    }
                }
                else{
                    echo <<<ZHOU
                        <div class="divInputZone">
                            <form action="runLogin.php" method="POST">
                                <input type="text" name="username" placeholder="粉糖账号">
                                <input type="password" name="password" placeholder="密码">
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
<script>
    // 滚动触发事件
    window.onscroll=function(){
        const divMenu = document.getElementById('divMenu');
        const y=document.documentElement.scrollTop||document.body.scrollTop
        if(y>300){
            divMenu.style.visibility='visible';
        }
        else{
            divMenu.style.visibility='hidden';
        }
    }
</script>
</html>
