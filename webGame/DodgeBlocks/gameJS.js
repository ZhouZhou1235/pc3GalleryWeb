// 作者 pinkcandyZHOU
// QQ1479499289

window.onload = function(){
    // 方法 获取元素标签
    function $(getid){
        return document.getElementById(getid);
    }

    // 方法 生成物体img
    function showThings(){
        var thingsImg = document.createElement('img');
        thingsImg.src = './gameImgs/things.jpg';
        var showtheThings = document.getElementById(theId);
        showtheThings.appendChild(thingsImg);
    }

    // 方法 生成物体的id和div
    function createdThings(){
        var num = 1;
        while(num<thingsNum){
            theId = 'things'+num;
            num += 1;
            var thingsDiv = document.createElement('div');
            thingsDiv.id = theId;
            thingsDiv.style.position='absolute';
            thingsDiv.style.left = itemX[Math.floor(Math.random()*itemX.length)]+'px';
            thingsDiv.style.top = itemY[Math.floor(Math.random()*itemY.length)]+'px';
            things.appendChild(thingsDiv);
            showThings();
        }
        theId = null;
    }
    
    // 方法 生成糖果
    function createdCandy(){
        candyX = itemX[Math.floor(Math.random()*itemX.length)],
        candyY = itemY[Math.floor(Math.random()*itemY.length)];
        candy.style.display='block';
        candy.style.left=candyX+'px';
        candy.style.top=candyY+'px';
    }

    // 方法 玩家移动
    function playerMove(){
        document.addEventListener('keydown',function(e){
            playerisMove = true;
            while(playerisMove==true){
                if(e.key=='a' || e.key=='ArrowLeft'){
                    playerX -= speed;
                }
                else if(e.key=='d' || e.key=='ArrowRight'){
                    playerX += speed;
                }
                else if(e.key=='w' || e.key=='ArrowUp'){
                    playerY -= speed;
                }
                else if(e.key=='s' || e.key=='ArrowDown'){
                    playerY += speed;
                }
                playerisMove = false;
                player.style.left=playerX+'px';
                player.style.top=playerY+'px';
                areaLimit();
            }
        })
    }
    // 方法 物体移动
    function thingsMove(){
        var num = 1;
        while(num<thingsNum){
            theId = 'things'+num;
            num += 1;
            var x = document.getElementById(theId),
            thingsX = parseInt(getComputedStyle(x).left),
            thingsY = parseInt(getComputedStyle(x).top);
            move = Math.floor(Math.random()*4);
            if(move<1){
                thingsX += thingsSpeed;
                thingsY -= thingsSpeed;
            }
            else if(move<2){
                thingsX -= thingsSpeed;
                thingsY -= thingsSpeed;
            }
            else if(move<3){
                thingsX -= thingsSpeed;
                thingsY += thingsSpeed;
            }
            else if(move<4){
                thingsX += thingsSpeed;
                thingsY += thingsSpeed;
            }
            if(thingsX>900||thingsX<0||thingsY>700||thingsY<0){
                thingsX = 450;
                thingsY = 350;
            }
            x.style.left=thingsX+'px';
            x.style.top=thingsY+'px';

            var a = (playerX-thingsX)**2;
            var b = (playerY-thingsY)**2;
            var length = Math.sqrt(a+b);
            crash(length);

            var a = (playerX-candyX)**2;
            var b = (playerY-candyY)**2;
            var length = Math.sqrt(a+b);
            eatCandy(length);
        }
    }

    // 方法 玩家区域限制
    function areaLimit(){
        if(playerX>900){
            playerX -= speed;
        }
        else if(playerX<0){
            playerX += speed;
        }
        else if(playerY>700){
            playerY -= speed;
        }
        else if(playerY<0){
            playerY += speed;
        }
        player.style.left=playerX+'px';
        player.style.top=playerY+'px';
    }

    // 方法 碰撞检测
    function crash(x){
        if(x<100){
            console.log('碰撞检测');
            alert('你失败了！');
            window.location.reload();
        }
    }

    // 方法 吃糖奖励
    function eatCandy(x){
        if(x<100){
            console.log('吃糖奖励');
            candy.style.display='none';
            if(score<5){
                score += 1;
                document.getElementById('score').innerHTML=score;
            }
            else{
                alert('你成功了！');
                location.reload();
            }
            createdCandy();
            RTCPeerConnection
        }
    }

    // 获取和定义元素
    var itemX = [0,100,200,300,400,500,600,700,800,900],
    itemY = [0,100,200,300,400,500,600,700];

    var gameStart = $('gameStart'),
        player = $('player'),
        things = $('things'),
        candy = $('candy'),
        up = $('up'),
        left = $('left'),
        down = $('down'),
        right = $('right');

    var playerX = 0,
        playerY = 0,
        playerisMove = false,
        speed = 50,
        thingsSpeed = 50,
        theId = null,
        thingsNum = 10,
        candyX = null,
        candyY = null,
        score = 0;

    // 开始游戏
    gameStart.onclick = function(){
        gameStart.style.display='none';
        player.style.left=playerX+'px';
        player.style.top=playerY+'px';
        playerMove();
        createdThings();
        createdCandy();
        setInterval(thingsMove,500);
        // 方法 按钮控制玩家移动
        up.onclick=function(){
            playerY -= speed;
            player.style.top=playerY+'px';
            areaLimit();
        }
        left.onclick=function(){
            playerX -= speed;
            player.style.left=playerX+'px';
            areaLimit();
        }
        down.onclick=function(){
            playerY += speed;
            player.style.top=playerY+'px';
            areaLimit();
        }
        right.onclick=function(){
            playerX += speed;
            player.style.left=playerX+'px';
            areaLimit();
        }
    }
}