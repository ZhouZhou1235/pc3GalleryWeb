# PINKCANDY
## 粉糖粒子-幻想动物画廊
##第二代

![image](https://github.com/user-attachments/assets/207d2110-c99b-46cc-9e7a-5d85224d7161)

---

### WEB应用概述
粉糖粒子是一款简易艺术画廊网站，具有完整的用户系统。
用户通过注册即可上传画廊，发布帖子等更多互动。
在设计排版上为流式布局，适应多种设备。
网站使用清晰易懂，没有复杂的流程，点击登录即用。

---

### 解决的问题及需求
绘画是艺术的一个重要分支，随着社会发展，生活水平提升后人们通常也会对绘画作品感兴趣，粉糖粒子能够快速在服务器上构建一个简易好用的艺术分享画廊，以便交流分享和鉴赏艺术作品。
或者如果有更多想法，可以把粉糖粒子作为任何合适的图文信息转播网站。

---

### 功能
以下是粉糖粒子主要功能的介绍

#### 登录与注册
粉糖粒子是一个动态网站
互动需要需要使用粉糖账号登录
没有粉糖账号可以快速注册一个
注册至少输入：粉糖账号、密码、邮箱、性别、种族

#### 画廊
粉糖粒子的核心功能
在首页右栏目，画廊以瀑布流展示预览图。鼠标点击即可展开详情。
在详情页中得以下载画廊原图像，还能评论、收藏、或访问上传者主页。

#### 小兽花园
粉糖粒子论坛
在首页左栏目，与画廊相似，瀑布流展示预览信息，鼠标点击展开主题帖。
打开主题帖页面，左边显示主题帖的内容，下面能印爪（类似点赞）、收藏、添加跟帖，跟帖根据发送的内容自动排版显示。右边显示用户的跟帖和跟帖回复。鼠标指到操作框显示跟帖回复表单。

#### 个兽空间
每个用户的专属空间
向其他用户展示介绍、上传的画廊、发布的帖子和爪记。
爪记是用户的空间笔记，用于写下近期的动态想法。要写一篇新爪记，则点击个兽空间图标转到页面，鼠标移到操作区，右边即可添加新爪记。
而左边可以编辑您上传的画廊以及更改个兽信息。

#### 收藏
您收藏的画廊和帖子都在这里显示
如果有不想保留的可以点击丢弃

#### 关注
您关注的用户或者关注您的用户均会显示在此处。

#### 上传
画廊一旦上传允许修改，一般情况不可以删除。
至少包含：图片文件（支持jpg jpeg png gif，不能超过5MB）、标题、类型、浏览分级
可以贴上标签，搜索标签能发现相关画廊。如有多个用空格隔开。

#### 发布
发布新帖子
在小兽花园添加新盆栽
至少填写标题和正文 多个标签用空格分隔开

#### 标签墙纸
为画廊添加合适的标签可以更好的分类搜索！
指定画廊ID，然后输入要添加/撕下的标签，如有多个则用空格隔开。所有小兽均可编辑。

#### 其他功能
粉糖粒子还有更多没有介绍的功能
例如：留言板，管理兽，徽章等
阅读PHP源码注释获得更多信息

---

### 部署网站
粉糖粒子部署教程
以Linux Ubuntu为例
推荐版本
linux ubuntu
apache 2.4.39
mysql 8.0.12
php 7.3.9

#### 服务器
准备一台接入公共网络的服务器、云主机、或虚拟云计算资源。
要求
运行内存2G 磁盘储存32G Linux计算机系统

#### web服务
安装 Apache web服务
默认配置即可
创建一个网站

**安装apache**
`apt install apache2`
`service apache2 start`

**创建网站**
打开apache配置
`cd /etc/apache2`
创建一个host网站主机，端口号8080。
000-default.conf
ServerAdmin webmaster@localhost
DocumentRoot /var/www/pinkcandy
命令apache监听8080
ports.conf
Listen 8080

#### 数据库MySQL
PHP对MySQL的支持良好，故使用MySQL数据库。

**安装Mysql**
`apt install mysql`
`service mysql start`

**pinkcandydb.sql导入**
导入数据结构（即执行SQL语句）
推荐使用phpmyadmin图形化数据库管理工具
能够快速导入管理数据

#### 服务器脚本PHP
粉糖粒子使用PHP编写

**安装PHP**
``apt install php``
将源码放置到apache主机根目录

**配置PINKCANDY邮件模块**
打开/lib/adminClass.php填写
    $emailHost = "";
    $emailUsername = "";
    $emailEnterPassword = "";
    $emailPort = "";
同理，打开/lib/userClass.php填写
    $mail->Host = '';
    $mail->Username = '';
    $mail->Password = '';
    $mail->Port = 0;

**配置数据库用户**
打开/lib/dbClass.php填写
    $server = "localhost";
    $user = "";
    $user_password = "";
    $dbname = "pinkcandydb";

#### 完成
重启服务器
`sudo reboot`
访问http://localhost:8080
PINKCANDY成功运行
