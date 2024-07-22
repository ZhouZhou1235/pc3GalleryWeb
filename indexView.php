<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="manifest" href="manifest.json" />
    <title>ZZWW 粉糖粒子全站速览</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div id="divMenu">
            <a href="#top">ZZWW</a>
            <a href="./about.php">🏠关于</a>
            <a href="./lab.php">🔭实验室</a>
            <a href="./indexView.php">🌐全站速览</a>
            <a href="./zzwwboard.php">📃留言板</a>
            <a href="./phpcolumn.php">📰图文专栏</a>
            <a href="./furrygallery.php">🖼️毛绒画廊</a>
            <a href="./tags.php">🗃️标签墙纸</a>
        </div>
        <div class="divBasic" id="top">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>粉糖粒子全站速览</h1>
            <p>支持的搜索字段 粉糖ID 粉糖账号 作品标题</p>
            <div class="divSpectial" style="text-align: center; display: flex;">
                <div class="divInputZone">
                    <form action="searchAccount.php" method="POST">
                        <input type="text" name="searchAccount" placeholder="寻找小兽">
                        <button type="submit">搜索</button>
                    </form>
                </div>
                <div class="divInputZone">
                    <form action="searchDraw.php" method="POST">
                        <input type="text" name="searchDraw" placeholder="开始欣赏毛绒艺术！🐾🐾🐾">
                        <button type="submit">搜索作品</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="divBasic">
        <?php
            session_start();
            $username = $_SESSION['username'];
            if($username!=null){
                // 小兽账号
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "
                select *
                from account
                order by id DESC
                ";
                $result = mysqli_query($link,$sql);

                echo "
                    <div class='leftSide'>
                    <div class='divTitle'><h2>小兽账号</h2></div>
                ";
                while($resultArray = mysqli_fetch_array($result)){
                    $id = $resultArray["Id"];
                    $username = $resultArray["username"];
                    $name = $resultArray['name'];
                    $sex = $resultArray['sex'];
                    $furrytype = $resultArray['furrytype'];
                    $starnum = $resultArray['starnum'];
                    $headimg = $resultArray['headimg'];
                    echo <<<ZHOU
                        <table>
                            <tr>
                                <td width='20%'><img src='./headimg/$headimg' width='100%' onerror="this.src='./fileLibrary/images/headimg.png'"></td>
                                <td>$name</td>
                                <td>粉糖账号$username</td>
                            </tr>
                            <tr>
                                <td>$sex</td>
                                <td>$furrytype</td>
                                <td>⭐:$starnum</td>
                            </tr>
                        </table>
                    ZHOU;
                }
                echo "
                </div>
                ";

                // zzww留言板
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "
                select account.username,account.name,zzwwboard.id,zzwwboard.username,zzwwboard.content,zzwwboard.img,zzwwboard.time
                from account,zzwwboard
                where account.username=zzwwboard.username
                order by id DESC
                ";
                $result = mysqli_query($link,$sql);

                echo "
                    <div class='leftSide'>
                    <div class='divTitle'><h2>留言板</h2></div>
                    <table>
                ";
                while($resultArray = mysqli_fetch_array($result)){
                    $id = $resultArray['id'];
                    $username = $resultArray["username"];
                    $name = $resultArray['name'];
                    $content = $resultArray['content'];
                    $img = $resultArray['img'];
                    $time = $resultArray['time'];
                    echo <<<ZHOU
                        <tr>
                            <td>$name</td>
                            <td>$time</td>
                            <td>留言板ID$id</td>
                        </tr>
                        <tr>
                            <td colspan='3'>$content</td>
                        </tr>
                        <tr>
                            <td colspan='3'><img src='./zzwwboardimg/$img' width='100%' onerror="this.src='./fileLibrary/images/board.png'"></td>
                        </tr>
                    ZHOU;
                }
                echo "
                    </table>
                    </div>
                ";

                // 图文专栏
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "
                select phpcolumn.id,account.username,account.name,phpcolumn.username,phpcolumn.content,phpcolumn.title,phpcolumn.img,phpcolumn.time,phpcolumn.claw,account.headimg
                from account,phpcolumn
                where account.username=phpcolumn.username
                order by id DESC
                ";
                $result = mysqli_query($link,$sql);

                echo "
                    <div class='leftSide'>
                    <div class='divTitle'><h2>图文专栏</h2></div>
                    <table>
                ";
                while($resultArray = mysqli_fetch_array($result)){
                    $id = $resultArray['id'];
                    $username = $resultArray["username"];
                    $name = $resultArray['name'];
                    $title = $resultArray['title'];
                    $content = $resultArray['content'];
                    $img = $resultArray['img'];
                    $time = $resultArray['time'];
                    echo <<<ZHOU
                        <tr>
                            <td>$name</td>
                            <td>$time</td>
                            <td>图文ID$id</td>
                        </tr>
                        <tr>
                            <td colspan='3'>$title</td>
                        </tr>
                        <tr>
                            <td colspan='3'>$content</td>
                        </tr>
                        <tr>
                            <td colspan='3'><img src='./phpcolumnimg/$img' width='100%' onerror="this.src='./fileLibrary/images/column.png'"></td>
                        </tr>
                    ZHOU;
                }
                echo "
                    </table>
                    </div>
                ";

                // 毛绒画廊
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "
                select furrygallery.id,account.username,account.name,furrygallery.username,furrygallery.title,furrygallery.info,furrygallery.img,furrygallery.type,furrygallery.time,furrygallery.claw,account.headimg
                from account,furrygallery
                where account.username=furrygallery.username
                order by id DESC
                ";
                $result = mysqli_query($link,$sql);

                echo "
                    <div class='leftSide'>
                    <div class='divTitle'><h2>毛绒画廊</h2></div>
                    <table>
                ";
                while($resultArray = mysqli_fetch_array($result)){
                    $id = $resultArray['id'];
                    $username = $resultArray["username"];
                    $name = $resultArray['name'];
                    $title = $resultArray['title'];
                    $info = $resultArray['info'];
                    $img = $resultArray['img'];
                    $type = $resultArray['type'];
                    $time = $resultArray['time'];
                    echo <<<ZHOU
                            <tr>
                                <td>$name</td>
                                <td>$time</td>
                                <td>画廊ID$id</td>
                            </tr>
                            <tr>
                                <td colspan='3'>$title</td>
                            </tr>
                            <tr>
                                <td colspan='3'><img src='./furrygalleryimg/$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'"></td>
                            </tr>
                            <tr>
                                <td colspan='1'>$type</td>
                                <td colspan='2'>$info</td>
                            </tr>
                    ZHOU;
                }
                echo "
                    </table>
                    </div>
                ";
            }
            else{
                echo<<<ZHOU
                    <div class="divSpectial">
                        <div class="divInputZone">
                            <form action="runLogin.php" method="POST">
                                <input type="text" name="username" placeholder="粉糖账号"><br/>
                                <input type="password" name="password" placeholder="密码"><br/>
                                <button type="submit">登录</button>
                                <button><a href="./register.php">注册</a></button>
                            </form>
                        </div>
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