<!DOCtheType html>
<?php
session_start();
$username = $_SESSION['username'];

if($username==null){
    die("<h1>ZZWW 获取名称失败</h1>");
}

$link = mysqli_connect('localhost','ZHOU','10171350','zzww');
$sql = "
select *
from account
where username='$username'
";
$result = mysqli_query($link, $sql);
$resultArray = mysqli_fetch_array($result);
$sender_id = $resultArray['Id'];
$candynum = $resultArray['candynum'];

if($candynum<=0){
    die('<h1>没有糖果了！</h1>');
}
else{
    $starnum = $_POST['starnum'];
    $id = $_POST['id'];

    $sql = "
    select *
    from account
    where id='$id'
    ";
    $result = mysqli_query($link, $sql);
    $resultArray = mysqli_fetch_array($result);

    if($id==$sender_id){
        die('<h1>不能自己送自己！</h1>');
    }
    
    $candynum -= 5;
    $sql = "
    update account set candynum='$candynum'
    where username='$username'
    ";
    $result = mysqli_query($link,$sql) or die('ZZWW write error');


    $sql = "
    select id,starnum
    from account
    where account.id='$id'
    ";
    $result = mysqli_query($link, $sql);
    $resultArray = mysqli_fetch_array($result);

    $starnum += 1;
    $sql = "
    update account set starnum='$starnum'
    where id='$id'
    ";
    $result = mysqli_query($link,$sql) or die('ZZWW write error');

    $sql = "
    insert into sendcandy(sender,receiver_id,candynum)
    values('$username','$id',5)
    ";
    $result = mysqli_query($link,$sql) or die('ZZWW write error');

    echo "
    <script>
        window.history.go(-2);
    </script>
    ";    
}
?>