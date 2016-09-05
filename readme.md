## Kratos

通过 `git clone` 到本地后，需要安装 Composer 依赖以及 `.env` 文件

### 安装依赖

在项目目录下执行 `composer install` 来安装项目所需要的依赖

### 环境配置

1. 复制 `.env.example` 文件，并重命名为 `.env`
2. 生成应用程序秘钥

```
php artisan key:generate
```

并正确配置数据库相关选项

### 生成测试数据

```
php artisan migrate
php artisan db:seed
```

默认后台用户有

**admin/admin**

**editor/editor**

**demo/demo**

通过 `http://www.yourdomain.com/dashboard` 可以跳到后台登录页面

### 定时任务

* 配置：

此项目使用 database 队列驱动，因此在 `.env` 里设置 `QUEUE_DRIVER=database`

* 推送任务到队列：

```
vagrant@homestead:~/Code/kratos$ pwd
/home/vagrant/Code/kratos
vagrant@homestead:~/Code/kratos$ crontab cron.txt 
vagrant@homestead:~/Code/kratos$ crontab -l
* * * * * php /home/vagrant/Code/kratos/artisan schedule:run >> /dev/null 2>&1
```

* 队列监听器：

队列监听器使用 `Supervisor`，所以要先装 `Supervisor`，如果用 Homestead 开发的话，Homestead有预装 `Supervisor`

以 Homestead 上预装的 Supervisor 为例，在 `/etc/supervisor/conf.d` 目录下创建 `kratos.conf`，并编辑该文件内容如下：

```
[program:kratos-queue-listen]
command=php /home/vagrant/Code/kratos/artisan queue:work --sleep=5 --tries=3 --daemon
user=vagrant
process_name=%(program_name)s_%(process_num)d
directory=/home/vagrant/Code/kratos
stdout_logfile=/home/vagrant/Code/kratos/storage/logs/supervisord.log
redirect_stderr=true
numprocs=1
```

把当中的路径换成自己有效的路径，项目根目录下有个 `cron.txt`，也要把这里面的路径换成自己有效的路径

配置文件创建好了之后，可以使用如下命令更新 Supervisor 配置并开启进程：

```
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start kratos-queue-listen:*
```

使用如下命令可以查看所有正在监听的队列

```
sudo supervisorctl status
```

这样，推送到队列的任务就可以自动被执行了
