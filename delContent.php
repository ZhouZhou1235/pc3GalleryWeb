<!DOCTYPE html>
<?php
    session_start();
    $link = mysqli_connect('localhost','ZHOU','10171350','zzww');

    //获取要删除的id和类型
    $delId = $_POST['delId'];
    $delType = $_POST['delType'];

    //小兽账号验证
    $username = $_SESSION['username'];
    $sql = "
    select *
    from account
    where username='$username'
    ";
    $result = mysqli_query($link,$sql);
    $resultArray = mysqli_fetch_array($result);
    $userId = $resultArray['Id'];
    $controlnum = $resultArray['controlnum'];

    //总管理兽
    if($controlnum==1){
        if($delId!=null&&$delType=='board'){
            $sql="delete from zzwwboard where id ='$delId'";
            $result = mysqli_query($link,$sql);
            header("location:ZZWWcontrol.php");
            exit;
        }
        else if($delId!=null&&$delType=='column'){
            $sql="delete from phpcolumn where id ='$delId'";
            $result = mysqli_query($link,$sql);
            header("location:ZZWWcontrol.php");
            exit;
        }
        else if($delId!=null&&$delType=='gallery'){
            $sql="delete from furrygallery where id ='$delId'";
            $result = mysqli_query($link,$sql);
            header("location:ZZWWcontrol.php");
            exit;
        }
    }
    //小兽
    else if($controlnum==0){
        if($delId!=null&&$delType=='board'){
            //检查糖果数量
            $sql = "
            select candynum
            from account
            where id = '$userId'
            ";
            $result = mysqli_query($link,$sql);
            $resultArray = mysqli_fetch_array($result);
            $candynum = $resultArray['candynum'];
            //糖果不足将终止删除
            if($candynum<=0){
                die('<h1>糖果用完了！无法删除</h1>');
            }
            else{
                $candynum -= 5;
                if($candynum<0){
                    $candynum = 0;
                }
                //更新小兽糖果数量
                $sql = "
                update account set candynum='$candynum'
                where id = '$userId'
                ";
                $result = mysqli_query($link,$sql);
                //执行删除
                $sql="delete from zzwwboard where id ='$delId'";
                $result = mysqli_query($link,$sql);
                header("location:zzwwboard.php");
                exit;
            }
        }
        else if($delId!=null&&$delType=='column'){
            //检查糖果数量
            $sql = "
            select candynum
            from account
            where id = '$userId'
            ";
            $result = mysqli_query($link,$sql);
            $resultArray = mysqli_fetch_array($result);
            $candynum = $resultArray['candynum'];
            //糖果不足将终止删除
            if($candynum<=0){
                die('<h1>糖果用完了！无法删除</h1>');
            }
            else{
                $candynum -= 15;
                if($candynum<0){
                    $candynum = 0;
                }
                //更新小兽糖果数量
                $sql = "
                update account set candynum='$candynum'
                where id = '$userId'
                ";
                $result = mysqli_query($link,$sql);
                //执行删除
                $sql="delete from phpcolumn where id ='$delId'";
                $result = mysqli_query($link,$sql);
                header("location:phpcolumn.php");
                exit;
            }
        }
        else if($delId!=null&&$delType=='gallery'){
            //检查糖果数量
            $sql = "
            select candynum
            from account
            where id = '$userId'
            ";
            $result = mysqli_query($link,$sql);
            $resultArray = mysqli_fetch_array($result);
            $candynum = $resultArray['candynum'];
            //糖果不足将终止删除
            if($candynum<=0){
                die('<h1>糖果用完了！无法删除</h1>');
            }
            else{
                $candynum -= 25;
                if($candynum<0){
                    $candynum = 0;
                }
                //更新小兽糖果数量
                $sql = "
                update account set candynum='$candynum'
                where id = '$userId'
                ";
                $result = mysqli_query($link,$sql);
                //执行删除
                $sql="delete from furrygallery where id ='$delId'";
                $result = mysqli_query($link,$sql);
                header("location:furrygallery.php");
                exit;
            }
        }
    }
?>