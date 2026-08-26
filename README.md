<p align="center">
    <img src="/frontend/public/images/title.png" alt="logo" width="50%">
</p>


# 幻想动物画廊
**网站 https://gallery.pinkcandy.top** <br />
**后台 https://gallery-system.pinkcandy.top** <br />


## 描述
幻想动物画廊是毛茸茸主题中文艺术图站，用户可以发布各类拟人小动物绘画作品。<br />
本网站为周周在校学习计算机编写的招牌项目，欢迎交流学习。<br />
技术栈：TypeScript, JavaScript, PHP, React, Slim, MySQL<br />


## 开发

### 数据库
```bash
mysql -u username -p pinkcandy_gallery < pinkcandy_gallery.sql
```

### 前端
配置 `src/code/config.ts`<br />
安装依赖<br />
```bash
npm install
```
启动<br />
```bash
npm run dev
```

### 后端
配置 `config/config.php`<br />
安装依赖<br />
```bash
composer install
```
启动<br />
```bash
php -S localhost:8082
```


## 部署

### 前端
编译<br />
```bash
npm run build
```
将 `dist/` 目录部署到 Web 服务器<br />
以Nginx为例，完成以下配置。<br />
```nginx
# 反向代理
server {
    listen 80;
    server_name your-domain.com;

    location / {
        root /path/to/frontend/dist;
        try_files $uri $uri/ /index.html;
    }

    location /api/ {
        proxy_pass http://127.0.0.1:8082/;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### 后端
使用 PHP-FPM 或启动内置服务器<br />
以Nginx为例，完成以下配置。<br />
```nginx
# index.php 处理请求
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
