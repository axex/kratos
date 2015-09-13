## Kratos

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)

通过 `git clone` 到本地后，需要安装 Composer 依赖以及 `.env` 文件

### 安装依赖

在项目目录下执行 `composer install` 来安装项目所需要的依赖

### 环境配置

1. 复制 `.env.example` 文件，并重命名为 `.env`
2. 生成应用程序秘钥

    ```
    php artisan key:generate
    ```    
    
### Apache 配置
    
新建一个 vhost，示例配置：

```
Listen 8000
<VirtualHost *:8000>
    DocumentRoot "/var/www/kratos/public"
    ErrorLog "logs/kratos-error.log"
    CustomLog "logs/kratos-access.log" common

    <Directory "/var/www/kratos/public">
        Require all granted
    </Directory>
</VirtualHost>

```