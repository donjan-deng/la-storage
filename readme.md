# 文件储存

基于Lumen框架的文件上传接口,《PHP微服务练兵》系列源码 <https://blog.csdn.net/donjan/article/details/103005084>

## 安装

### 已有环境
```
git clone https://github.com/donjan-deng/la-storage.git
cd la-storage
composer install

复制.env.example为.env,并编辑好配置
```
### Docker安装

```
docker run -d --name storage \
  --restart=always \
  -p 3000:80 \
  donjan/la-storage

docker exec -it storage bash

cd /app

复制.env.example为.env,并编辑好配置

```
