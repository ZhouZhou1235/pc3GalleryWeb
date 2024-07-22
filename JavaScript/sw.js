// 开始缓存服务器文件
self.addEventListener('install',event => {
    // 跳过等待
    self.skipWaiting();
})

// 清除旧文件
self.addEventListener('activate',event => {
    // console.log('activate',event);
    // service worker激活后立刻控制
    self.clients.claim();
})

// 接收网络回应
self.addEventListener('fetch',event => {
    // console.log('fetch',event);
})
