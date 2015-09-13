## Kratos

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)

ͨ�� `git clone` �����غ���Ҫ��װ Composer �����Լ� `.env` �ļ�

### ��װ����

����ĿĿ¼��ִ�� `composer install` ����װ��Ŀ����Ҫ������

### ��������

1. ���� `.env.example` �ļ�����������Ϊ `.env`
2. ����Ӧ�ó�����Կ

    ```
    php artisan key:generate
    ```    
    
### Apache ����
    
�½�һ�� vhost��ʾ�����ã�

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