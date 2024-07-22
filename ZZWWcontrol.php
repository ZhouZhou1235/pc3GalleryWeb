<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 管理兽</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>ZZWW控制页面</h1>
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
            $username = $resultArray['username'];
            $controlnum = $resultArray['controlnum'];
            if($username==$_SESSION['username']){
                if($controlnum==1){
                    echo <<<ZHOU
                        <div class="divSpectial">
                            <h2>ZZWW总管理兽 $username</h2>
                        </div>
                    ZHOU;

                    echo <<<ZHOU
                        <div class="divSpectial">
                            <table>
                                <tr>
                                    <td colspan="2">
                                        <p style="color: red;">[谨慎操作]</p>账号数字变更
                                        <form action="updateUsername.php" method="POST">
                                            变更账号<input type="text" name="oldUsername">
                                            为新账号<input type="text" name="newUsername">
                                            <button type="submit">操作<button>
                                        </form>    
                                    </td>
                                </tr>
                                <tr>
                                    <td>自动邮件程序测试</td>
                                    <td><a href="ZZWWcontrol/testEmail.php"><p onclick="return confirm('邮件测试')">邮件测试</p></a></td>
                                </tr>
                                <tr>
                                    <td><p style="color: red;">[谨慎操作]</p>将username值覆盖到name中</td>
                                    <td><a href="ZZWWcontrol/name=username.php"><p onclick="return confirm('name=username')">name=username</p></a></td>
                                </tr>
                                <tr>
                                    <td>邮件程序 补发欢迎</td>
                                    <td>
                                        <form action="ZZWWcontrol/emailAddWelcome.php" method="POST">
                                            <input type="text" name="sayHello">
                                            <button type="submit">发送</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td><p style="color: red;">[危险！该操作只能执行一次]</p>哈希加密所有账号的密码值</td>
                                    <td><a href="ZZWWcontrol/hashedPassword.php"><p onclick="return confirm('加密')">加密</p></a></td>
                                </tr>
                            </table>
                        </div>
                    ZHOU;

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
                        $sex = $resultArray['sex'];
                        $furrytype = $resultArray['furrytype'];
                        $qq = $resultArray['qq'];
                        $controlnum = $resultArray['controlnum'];
                        $jointime = $resultArray['jointime'];
                        $starnum = $resultArray['starnum'];
                        $candynum = $resultArray['candynum'];

                        $openEdit = 1;
                        echo <<<ZHOU
                            <table>
                                <tr>
                                    <td>$username</td>
                                    <td>粉糖ID$id</td>
                                    <td>
                                        <form action="edit.php" method="POST">
                                            <input type="hidden" name="theId" value="$id">
                                            <input type="hidden" name="openEdit" value="$openEdit">
                                            <button type="submit">修改</button>
                                        </form>
                                    <td>
                                </tr>
                                <tr>
                                    <td colspan='3'>QQ:$qq</td>
                                </tr>
                                <tr>
                                    <td>$sex</td>
                                    <td>$furrytype</td>
                                    <td>粉糖代号:$controlnum</td>
                                </tr>
                                <tr>
                                    <td>加入时间:$jointime</td>
                                    <td>⭐:$starnum</td>
                                    <td>🍬:$candynum</td>
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
                    select *
                    from zzwwboard
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                        <div class='leftSide'>
                        <div class='divTitle'><h2>留言板</h2></div>
                    ";
                    while($resultArray = mysqli_fetch_array($result)){
                        $id = $resultArray['Id'];
                        $username = $resultArray["username"];
                        $content = $resultArray['content'];
                        $img = $resultArray['img'];
                        $time = $resultArray['time'];

                        $theType = 1; //1为留言板
                        echo <<<ZHOU
                            <table>
                                <tr>
                                    <td>$username</td>
                                    <td>$time</td>
                                    <td>$id</td>
                                    <td>
                                        <form action="delContent.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('确认删除？')">
                                            <input type="hidden" name="delId" value="$id">
                                            <input type="hidden" name="delType" value="board">
                                            <button type="submit">删除</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='4'>$content</td>
                                </tr>
                                <tr>
                                    <td colspan='4'><img src='./zzwwboardimg/$img' width='100%' onerror="this.src='./fileLibrary/images/board.png'"></td>
                                </tr>
                            </table>
                        ZHOU;
                    }
                    echo "
                    </div>
                    ";

                    // 图文专栏
                    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                    $sql = "
                    select *
                    from phpcolumn
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                        <div class='leftSide'>
                        <div class='divTitle'><h2>图文专栏</h2></div>
                    ";
                    while($resultArray = mysqli_fetch_array($result)){
                        $id = $resultArray['Id'];
                        $username = $resultArray["username"];
                        $title = $resultArray['title'];
                        $content = $resultArray['content'];
                        $img = $resultArray['img'];
                        $time = $resultArray['time'];

                        $theType = 2; //2为图文专栏
                        echo <<<ZHOU
                            <table>
                                <tr>
                                    <td>$username</td>
                                    <td>$time</td>
                                    <td>图文ID$id</td>
                                    <td>
                                        <form action="delContent.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('确认删除？')">
                                            <input type="hidden" name="delId" value="$id">
                                            <input type="hidden" name="delType" value="column">
                                            <button type="submit">删除</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='4'>$title</td>
                                </tr>
                                <tr>
                                    <td colspan='4'>$content</td>
                                </tr>
                                <tr>
                                    <td colspan='4'><img src='./phpcolumnimg/$img' width='100%' onerror="this.src='./fileLibrary/images/column.png'"></td>
                                </tr>
                            </table>
                        ZHOU;
                    }
                    echo "
                    </div>
                    ";

                    // 毛绒画廊
                    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                    $sql = "
                    select *
                    from furrygallery
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                        <div class='leftSide'>
                        <div class='divTitle'><h2>毛绒画廊</h2></div>
                    ";
                    while($resultArray = mysqli_fetch_array($result)){
                        $id = $resultArray['Id'];
                        $username = $resultArray["username"];
                        $title = $resultArray['title'];
                        $info = $resultArray['info'];
                        $img = $resultArray['img'];
                        $type = $resultArray['type'];
                        $time = $resultArray['time'];

                        $theType = 3; //3为毛绒画廊
                        echo <<<ZHOU
                            <table>
                                <tr>
                                    <td>$username</td>
                                    <td>$time</td>
                                    <td>画廊ID$id</td>
                                    <td>
                                        <form action="delContent.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('确认删除？')">
                                            <input type="hidden" name="delId" value="$id">
                                            <input type="hidden" name="delType" value="gallery">
                                            <button type="submit">删除</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan='4'>$title</td>
                                </tr>
                                <tr>
                                    <td colspan='4'><img src='./furrygalleryimg/$img' width='100%' onerror="this.src='./fileLibrary/images/gallery.png'"></td>
                                </tr>
                                <tr>
                                    <td colspan='1'>$type</td>
                                    <td colspan='3'>$info</td>
                                </tr>
                            </table>
                        ZHOU;
                    }
                    echo "
                    </div>
                    ";
                }
                else if($controlnum==2){
                    echo '2';
                }
                else{
                    die("<h2>非管理兽不得进入控制界面，请向总管理兽获取控制权限。</h2>");
                }
            }
            else{
                die("<h2>非管理兽不得进入控制界面，请向总管理兽获取控制权限。</h2>");
            }
            ?>
        </div>
    </div>
</body>
</html>