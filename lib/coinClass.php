<?php
namespace {
    require_once "dbClass.php";
    class coinChange {
        // 硬币变化类
        function coinAdd($username,int $todo){
            // 获得硬币
            global $link;
            $sql = "select coin from account where username='$username'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $coin = $account['coin'];
            if($todo == 1){//上传画廊
                $coin += random_int(10,20);
            }
            else if($todo == 2){
                null;
            }
            $sql = "update account set coin=$coin where username='$username'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return;
        }
        function coinSubtract($username,int $todo){
            // 消耗硬币
            global $link;
            $sql = "select coin from account where username='$username'";
            $result = mysqli_query($link,$sql);
            $account = mysqli_fetch_array($result);
            $coin = $account['coin'];
            if($todo == 1){//修改画廊
                if($coin<10){return 0;}
                $coin -= 10;
            }else if($todo == 2){//修改个兽信息
                if($coin<50){return 0;}
                $coin -= 50;
            }
            $sql = "update account set coin=$coin where username='$username'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
    }
}