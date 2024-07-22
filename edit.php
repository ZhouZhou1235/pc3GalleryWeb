<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 修改账号信息</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
    <script>
        // 方法 检查输入内容后执行
        function checkEmpty(){
            var $password = document.getElementById('password').value,
                $sex = document.getElementById('sex').value,
                $furrytype = document.getElementById('furrytype').value,
                $qq = document.getElementById('qq').value;
            var isOk = true;
            if($password==''||$password.length<2||$password.length>20){
                alert('密码不为空且长度2-20位');
                isOk = false;
                return;
            }
            if($sex==''){
                alert('未选择性别');
                isOk = false;
                return;
            }
            if($furrytype==''){
                alert('未选择类型');
                isOk = false;
                return;
            }
            if($qq==''||$qq.length<5){
                alert('请输入正确的QQ号');
                isOk = false;
                return;
            }
            if(isOk==true){
                var form = document.getElementById('form');
                form.submit();
            }
        }
    </script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>修改账号信息</h1>
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
                $name = $resultArray['name'];
                $signature = $resultArray['signature'];
                $qq = $resultArray['qq'];
                $controlnum = $resultArray['controlnum'];

                $openEdit = $_POST['openEdit'];

                if($controlnum==1&&$openEdit==1){
                    $theId = $_POST['theId'];
                    echo <<<ZHOU
                        <h2>总管理兽修改操作 涉及粉糖ID:$theId</h2>
                        <div class="divContent">
                            <div class="divInputZone">
                                <form action="runEdit.php" method="POST" enctype="multipart/form-data" id="form">
                                    <input type="text" name="name" placeholder="名称"><br>
                                    <input type="password" name="password" id="password" placeholder="密码"><br>
                                    <input type="text" name="sex" placeholder="性别"><br>
                                    <input type="text" name="furrytype" placeholder="类型"><br>
                                    <input type="text" name="signature" placeholder="签名"><br>
                                    <input type="text" name="qq" id="qq" placeholder="qq"><br>
                                    <input type="text" name="theControlnum" placeholder="粉糖代号"><br>
                                    <input type="hidden" name="theId" value="$theId">
                                    <input type="hidden" name="openEdit" value="$openEdit">
                                    <button type="submit">修改</button><br>
                                </form>
                            </div>
                            <p>粉糖代号 0为普通小兽 1为总管理兽 2为管理兽</p>
                        </div>
                    ZHOU;
                }
                else{
                    echo <<<ZHOU
                        <h2>粉糖账号$username 绑定QQ$qq</h2>
                        <div class="divContent">
                            <div class="divInputZone">
                                <form action="uploadBackimg.php" method="POST" enctype="multipart/form-data">
                                    上传背景墙<input type="file" name="file">
                                    <button type="submit">上传</button>
                                </form>
                                <form action="runEdit.php" method="POST" enctype="multipart/form-data" id="form">
                                    <label for="name">改名称</label><input type="text" name="name" placeholder="名称" value="$name">
                                    <label for="password">必填 改密码</label><input type="password" name="password" id="password" placeholder="密码">
                                    <label for="sex">必填 性别</label><select name="sex" id="sex">
                                        <option value="">性别</option>
                                        <option value="雄">雄</option>
                                        <option value="雌">雌</option>
                                        <option value="未知">不想告诉</option>
                                    </select>
                                    <label for="furrytype">必填 类型</label><select name="furrytype" id="furrytype">
                                        <option value="">类型</option>
                                        <option value="小布">小布</option>
                                        <option value="水布">水布</option>
                                        <option value="雷布">雷布</option>
                                        <option value="火布">火布</option>
                                        <option value="光布">光布</option>
                                        <option value="月布">月布</option>
                                        <option value="冰布">冰布</option>
                                        <option value="叶布">叶布</option>
                                        <option value="仙布">仙布</option>
                                        <option value="小兽">默认</option>
                                    </select>
                                    <label for="signature">签名</label><input type="text" name="signature" placeholder="签名" value="$signature">
                                    <label for="file">上传头像</label><input type="file" name="file">
                                    <button type="button" onclick="checkEmpty()">修改</button>
                                </form>
                            </div>
                            <p>修改背景墙请点击上传，不是修改。</p>
                            <p>粉糖账号和粉糖ID是唯一识别凭证，不可更改。</p>
                            <p>更改绑定QQ号请联系总管理兽pinkcandyzhou@qq.com</p>
                        </div>
                    ZHOU;
                }
            ?>
        </div>
    </div>
</body>
</html>