// 作者 pinkcandyZHOU
// QQ1479499289
// 代码参考 Gamedev-Canvas-workshop by Andrzej Mazur and Mozilla Contributors

window.onload = function(){
    // 定义画布
    var canvas1 = document.getElementById('canvas1');
    var ctx = canvas1.getContext('2d');

    // 定义变量
    var ballRadius = 10;
    //球
    var x = canvas1.width/2;
    var y = canvas1.height-30;
    var dx = 3;
    var dy = -3;
    //挡板
    var paddleWidth = 75;
    var paddleHeight = 10;
    var paddleX = (canvas1.width-paddleWidth)/2;
    //砖块
    var brickRowCount = 10;
    var brickColumnCount = 10;
    var brickWidth = 70;
    var brickHeight = 20;
    var brickPadding = 10;
    var brickOffsetTop = 5;
    var brickOffsetLeft = 5;
    //键盘按压
    var leftPressed = false;
    var rightPressed = false;    
    //分数
    var score = 0;
    var lives = 5;
    //速度数组
    var randomItems = [0.5, 0.6, 0.7, 0.8, 0.9, 1, 1.1, 1.2, 1.3, 1.4, 1.5];
    var addSpeedItems = [1, 1.1, 1.2, 1.3];

    // 创建砖块的数组
    var bricks = [];
    //行
    for(let c=0; c<brickColumnCount; c++){
        bricks[c] = [];
        //列
        for(let r=0; r<brickRowCount; r++){
            bricks[c][r] = {x: 0, y: 0, status: 1};
        }
    }

    // 检测用户操作
    //监听器
    document.addEventListener("keydown", keyDownHandler, false);
    document.addEventListener("keyup", keyUpHandler, false);
    document.addEventListener("mousemove", mouseMoveHandler, false);
    //按下按键
    function keyDownHandler(e){
        if(e.code == 'ArrowLeft'){
            leftPressed = true;
        }
        else if(e.code == 'ArrowRight'){
            rightPressed = true;
        }
    }
    //回弹按键
    function keyUpHandler(e){
        if(e.code == 'ArrowLeft'){
            leftPressed = false;
        }
        else if(e.code == 'ArrowRight'){
            rightPressed = false;
        }
    }
    //鼠标
    function mouseMoveHandler(e){
        let relativeX = e.clientX - canvas1.offsetLeft;
        if(relativeX > 0 && relativeX < canvas1.width){
            paddleX = relativeX - paddleWidth/2;
        }
    }

    // 碰撞
    function collisionDetection(){
        let spectialScore = 0;
        //遍历行
        for(let c=0; c<brickColumnCount; c++){
            //遍历列
            for(let r=0; r<brickRowCount; r++){
                //从数组获取砖块信息
                let b = bricks[c][r];
                //判断status
                if(b.status == 1){
                    //判断是否碰撞
                    if(x > b.x && x < b.x+brickWidth && y > b.y && y < b.y+brickHeight){
                        dy = -dy;
                        b.status = 0;
                        spectialScore++;
                        score += spectialScore;
                        //判断是否满分
                        if(score == brickRowCount*brickColumnCount){
                            //上传cookie
                            var userScore = 'userScore', value = score;
                            document.cookie = userScore+" = "+value+";";
                            var userLives = 'userLives', value = lives;
                            document.cookie = userLives+" = "+value+";";
                            alert('游戏通关！');
                            document.location.reload();
                        }
                    }
                }
            }
        }
    }

    // 定义绘制方法
    //球
    function drawBall(){
        ctx.beginPath();
        ctx.arc(x, y, ballRadius, 0, Math.PI*2);
        if(lives >= 3){ctx.fillStyle = 'green';}
        else if(lives == 2){ctx.fillStyle = 'orange';}
        else if(lives == 1){ctx.fillStyle = 'red';}
        ctx.fill();
        ctx.closePath();
    }
    //挡板
    function drawPaddle(){
        ctx.beginPath();
        ctx.rect(paddleX, canvas1.height-paddleHeight, paddleWidth, paddleHeight);
        ctx.fillStyle = 'black';
        ctx.fill();
        ctx.closePath();
    }
    //砖块
    function drawBricks(){
        //行
        for(let c=0; c<brickColumnCount; c++){
            //列
            for(let r=0; r<brickRowCount; r++){
                //判断是否存在砖块
                if(bricks[c][r].status == 1){
                    //砖块位置
                    let brickX = (r*(brickWidth+brickPadding))+brickOffsetLeft;
                    let brickY = (c*(brickHeight+brickPadding))+brickOffsetTop;
                    //存到数组中
                    bricks[c][r].x = brickX;
                    bricks[c][r].y = brickY;
                    ctx.beginPath();
                    ctx.rect(brickX, brickY, brickWidth, brickHeight);
                    ctx.fillStyle = 'gray';
                    ctx.fill();
                    ctx.closePath();
                }
            }
        }
    }
    //分数
    function drawScore() {
        ctx.font = "20px Arial";
        ctx.fillStyle = "black";
        ctx.fillText("pinkcandyZHOU",10, 20);
        ctx.fillText("得分"+score, 10, 40);
    }
    //机会
    function drawLives() {
        ctx.font = "20px Arial";
        ctx.fillStyle = "black";
        ctx.fillText("机会"+lives, 10, 60);
    }

    // 渲染页面
    function draw(){
        //清除初始边框
        ctx.clearRect(0, 0, canvas1.width, canvas1.height);
        //渲染
        drawBall();
        drawPaddle();
        drawBricks();
        collisionDetection();
        drawScore();
        drawLives();
        //碰壁反弹
        if(x + dx > canvas1.width-ballRadius || x + dx <ballRadius){
            dx = dx * randomItems[Math.floor(Math.random()*randomItems.length)];
            dx = -dx;
        }
        if(y + dy < ballRadius){
            dy = dy * randomItems[Math.floor(Math.random()*randomItems.length)];
            dy = -dy;
        }
        //判断是否接住球
        else if(y + dy > canvas1.height-ballRadius){
            //接住成功
            if(x > paddleX && x < paddleX + paddleWidth){
                dy = dy * addSpeedItems[Math.floor(Math.random()*addSpeedItems.length)];
                if(dy>10){dy = dy*0.5};
                dy = -dy;
            }
            //接住失败
            else{
                lives--;
                //游戏结束
                if(!lives){
                    //上传cookie
                    var userScore = 'userScore', value = score;
                    document.cookie = userScore+" = "+value+";";
                    var userLives = 'userLives', value = lives;
                    document.cookie = userLives+" = "+value+";";    
                    alert('你失败了！');
                    document.location.reload();
                }
                //重置位置
                else{
                    x = canvas1.width/2;
                    y = canvas1.height-50;
                    if(lives >= 3){
                        dx = 3;
                        dy = -3;    
                    }
                    else if(lives == 2){
                        dx = 5;
                        dy = -5;
                    }
                    else if(lives == 1){
                        dx = 7;
                        dy = -7;
                    }
                    paddleX = (canvas1.width-paddleWidth)/2;
                }
            }
        }
        //刷新挡板位置
        if(rightPressed && paddleX < canvas1.width-paddleWidth) {
            paddleX += 10;
        }
        else if(leftPressed && paddleX > 0){
            paddleX -= 10;
        }
        //刷新球位置
        x += dx;
        y += dy;
        //循环播放动画
        requestAnimationFrame(draw);
    }
    //开始渲染
    draw();
}