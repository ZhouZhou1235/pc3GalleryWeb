<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW留言板</title>
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
            <h1>ZZWW留言板</h1>
        </div>
        <div class="divBasic">
            <div class="divSpectial">
                <div class="divInputZone">
                    <form action="updateBoard.php" method="POST" enctype="multipart/form-data">
                        <textarea name="content" id="content" cols="20" rows="2" placeholder="留言板"></textarea><br>
                        <p>附图<input type="file" name="file"><button type="submit">发送</button></p>
                    </form>
                </div>
            </div>
            <?php
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
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
                        // 留言板
                        $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                        $sql = "
                        select account.username,account.name,zzwwboard.id,zzwwboard.username,zzwwboard.content,zzwwboard.img,zzwwboard.time
                        from account,zzwwboard
                        where account.username=zzwwboard.username
                        order by id DESC
                        ";
                        $result = mysqli_query($link,$sql);
                            
                        echo "
                        <div class='divContentWiden'>
                        <div class='divTitle'><h2>ZZWW留言板</h2></div>
                        <table>
                        ";

                        $showNum = 0;
                        while($resultArray = mysqli_fetch_array($result)){
                            $showNum += 1;
                            $id = $resultArray['id'];
                            $username = $resultArray['username'];
                            $name = $resultArray['name'];
                            $content = $resultArray['content'];
                            $img = $resultArray['img'];
                            $time = $resultArray['time'];
                            
                            $myself = $_SESSION['username'];
                            if($username==$myself){
                                echo<<<ZHOU
                                    <tr>
                                    <td width='10%'>$name</td>
                                    <td width='50%'>$content</td>
                                    <td width='20%'><img src='./zzwwboardimg/$img' width='100%' onerror="this.src='./fileLibrary/images/board.png'"></td>
                                    <td width='20%'>
                                        $time
                                        <form action="delContent.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('确认删除？这将丢失5个糖果！')">
                                            <input type="hidden" name="delId" value="$id">
                                            <input type="hidden" name="delType" value="board">
                                            <button type="submit">删除</button>
                                        </form>
                                    </td>
                                    </tr>
                                ZHOU;
                            }
                            else{
                                echo<<<ZHOU
                                    <tr>
                                    <td width='10%'>$name</td>
                                    <td width='50%'>$content</td>
                                    <td width='20%'><img src='./zzwwboardimg/$img' width='100%' onerror="this.src='./fileLibrary/images/board.png'"></td>
                                    <td width='20%'>$time</td>
                                    </tr>
                                ZHOU;
                            }
                            if($showNum>39){
                                break;
                            }
                        }
                        echo "
                        </table>
                        </div>
                        ";
                        echo "
                        </div>
                        <div class='divEnd'><p>仅展示最近40条</p></div>
                        ";
                    }
                }
                else{
                    echo <<<ZHOU
                        <form action="runLogin.php" method="POST">
                            <input type="text" name="username" placeholder="粉糖账号">
                            <input type="password" name="password" placeholder="密码">
                            <button type="submit">登录</button>
                            <a href="./register.php">注册</a>
                        </form>
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