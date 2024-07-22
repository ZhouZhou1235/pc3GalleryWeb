<!DOCTYPE html>
<?php
// 总管理兽操作 谨慎执行
// 将account表的password值哈希加密并覆盖
session_start();
$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$username = $_SESSION['username'];
$sql = "
select *
from account
where username='$username'
";
$result = mysqli_query($link,$sql);
$resultArray = mysqli_fetch_array($result);
$controlnum = $resultArray['controlnum'];

if($controlnum==1){
    $sql = "
    select username,password
    from account
    ";
    $result = mysqli_query($link,$sql);
    echo "<table><thead><td colspan='3'>总管理兽操作 哈希加密<td></thead>";
    while($resultArray = mysqli_fetch_array($result)){
        $username = $resultArray['username'];
        $password = $resultArray['password'];
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
        if(!password_verify($password,$hashedPassword)){exit('ZZWW password hash error');}
        $sql2 = "
        update account
        set password='$hashedPassword'
        where username='$username'
        ";
        $result2 = mysqli_query($link,$sql2);
        echo "
        <tr>
        <td>粉糖账号$username</td>
        <td>密码$password</td>
        <td>加密保存为$hashedPassword</td>
        </tr>
        ";
    }
    echo "</table>";
    echo "ZZWW update done";
}
?>