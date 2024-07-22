<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 注册</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
    <script>
        // 方法 检查输入内容后执行
        function checkEmpty(){
            var $username = document.getElementById('username').value,
                $password = document.getElementById('password').value,
                $sex = document.getElementById('sex').value,
                $furrytype = document.getElementById('furrytype').value,
                $qq = document.getElementById('qq').value;
                $checkNum =document.getElementById('checkNum').value;
            var isOk = true;
            if($username==''||$username.length!=5){
                alert('粉糖账号不为空且长度为5位');
                isOk = false;
                return;
            }
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
            if($checkNum==''){
                alert('未输入验证码');
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
            <h1>ZZWW 注册</h1>
        </div>
        <div class="divBasic">
            <div class="divContent">
                <div class="divInputZone">
                    <form action="getCheckNum.php" method="POST">
                        <label for="qq">必填 QQ</label><input type="text" name="qq" id="qq" placeholder="qq">
                        <button type="submit">获取验证码（QQ邮箱）</button>
                    </form>
                    <form action="runRegister.php" method="POST" enctype="multipart/form-data" id="form">
                        <label for="username">必填 粉糖账号</label><input type="text" name="username" id="username" placeholder="粉糖账号">
                        <label for="password">必填 密码</label><input type="password" name="password" id="password" placeholder="密码">
                        <label for="name">名称</label><input type="text" name="name" placeholder="名称">
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
                        <label for="signature">签名</label><input type="text" name="signature" placeholder="签名">
                        <label for="checkNum">必填 验证码</label><input type="text" name="checkNum" id="checkNum" placeholder="验证码">
                        <label for="file">上传头像</label><input type="file" name="file">
                        <button type="button" onclick="checkEmpty()">注册</button>
                    </form>
                    <a href="runRegister.php?end=1"><p style="color: red;" onclick="return confirm('确定放弃？这将删除所有信息并使验证码失效！');">结束网络会话（放弃注册）</p></a>
                </div>
                <p>注意：请设置一个五位数字粉糖账号，注册时将生成唯一粉糖ID，粉糖账号和粉糖ID不可更改。使用粉糖账号和密码登录。</p>
                <p>未防止产生大量无源账号，粉糖账号与QQ号一对一绑定。</p>
            </div>
        </div>
    </div>
</body>
</html>