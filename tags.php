<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZZWW 标签墙纸</title>
    <link href="./fileLibrary/images/ZHOUZHOU.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" href="./CSS/style.css?version=<?php echo date('YmdHi');?>">
    <script src="./JavaScript/jscodeIndex.js?version=<?php echo date('YmdHi');?>" type="text/javascript"></script>
</head>
<body>
    <!--ZZWW-->
    <div class="divMain">
        <div class="divBasic">
            <a href="./index.php"><img src="./fileLibrary/images/webLogo.png" width="300px"></a>
            <h1>标签墙纸</h1>
        </div>
        <div class="divBasic">
            <div class="leftSide">
                
                <form action="addTags.php" method="POST">
                    <h2>添加标签</h2>
                    <input type="text" name="tag" placeholder="添加标签">
                    <select name="type" id="type">
                        <option value="">选择标签类型</option>
                        <option value="画师">画师</option>
                        <option value="系列">系列</option>
                        <option value="角色">角色</option>
                        <option value="属性">属性</option>
                        <option value="描述">描述</option>
                        <option value="普通">普通标签</option>
                    </select>
                    <button type="submit">添加</button>
                </form>
                <form action="searchTags.php" method="POST">
                    <h2>搜索标签</h2>
                    <input type="text" name="searchTags" placeholder="搜索标签">
                    <button type="submit">搜索</button>
                </form>
                <?php
                session_start();
                $username = $_SESSION['username'];
                $link = mysqli_connect('localhost','ZHOU','10171350','zzww');
                $sql = "select controlnum from account where username='$username'";
                $result = mysqli_query($link,$sql);
                $resultArray = mysqli_fetch_array($result);
                $controlnum = $resultArray['controlnum'];
                if($controlnum==1 || $controlnum==2){
                    echo <<<ZHOU
                        <form action="editTags.php" method="POST">
                            <h2>编辑标签</h2>
                            <input type="text" name="oldTag" placeholder="编辑标签（ID）">
                            <input type="text" name="newTag" placeholder="为新标签">
                            <select name="type" id="type">
                                <option value="">选择标签类型</option>
                                <option value="画师">画师</option>
                                <option value="系列">系列</option>
                                <option value="角色">角色</option>
                                <option value="属性">属性</option>
                                <option value="描述">描述</option>
                                <option value="普通">普通标签</option>
                            </select>    
                            <button type="submit">编辑</button>
                        </form>
                    ZHOU;
                }
                ?>
            </div>
            <div class="divContent">
                <?php
                    if($username==null){
                        echo <<<ZHOU
                            <div class="divContent" style="text-align: center;">
                                <h2>粉糖粒子🍬&nbsp;让世界变成四脚兽的样子xwx</h2>
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
                            </div>
                        ZHOU;
                        exit("<h2>ZZWW 请登录后再浏览</h2>");
                    }
                    
                    $sql = "
                    select *
                    from tags
                    order by id DESC
                    ";
                    $result = mysqli_query($link,$sql);

                    echo "
                    <table>
                    <thead>
                    <td>标签ID</td>
                    <td>标签内容</td>
                    <td>标签类型</td>
                    <td>创建者</td>
                    <td>创建时间</td>
                    </thead>
                    ";
                    while($resultArray = mysqli_fetch_array($result)){
                        $id = $resultArray['Id'];
                        $tag = $resultArray['tag'];
                        $type = $resultArray['type'];
                        $time = $resultArray['time'];
                        $creator = $resultArray['creator'];
                        echo "
                        <tr>
                        <td>$id</td>
                        <td>$tag</td>
                        <td>$type</td>
                        <td>$creator</td>
                        <td>$time</td>
                        </tr>
                        ";
                    }
                    echo "</table>";
                ?>
            </div>
        </div>
    </div>
</body>
</html>