<p align="center"><img src="https://n.tiayo.com/images/blue_logo.png"></p>

## 关于 随享V5.0

 随享V5.0是一套集内容管理、任务管理、支付系统在内的全站系统，力求代码简洁、高效。
 
#### 环境要求：

````
php >= 7.0

mysql >= 5.7

redis-cli >= 3.2.5

supervisord >= 3.0
````
#### 文档
[随享V5.0 开发文档](https://n.tiayo.com/wiki)

#### 安装：

一、克隆源码到本地：`git clone https://github.com/tiayo/notification.git`

二、composer安装依赖包：`composer install`

三、配置crontab：

运行：`crontab -e`

将：`{ site }`替换为您的路径

````
* * * * * php /{ site }/artisan task:check
* * * * * sleep 10; php /{ site }/artisan task:check
* * * * * sleep 20; php /{ site }/artisan task:check
* * * * * sleep 30; php /{ site }/artisan task:check
* * * * * sleep 40; php /{ site }/artisan task:check
* * * * * sleep 50; php /{ site }/artisan task:check
10 0 * * * chmod 777 -R /{ site }/storage/logs
* * * * * sleep 50; php /{ site }/artisan payment:check
````

四、配置supervisor：

````
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /{ site }/artisan queue:work redis --sleep=3 --tries=3
autostart=true
autorestart=true
user=root
numprocs=10
redirect_stderr=true
stdout_logfile= /var/log/supervisor/supervisord.log
````

#### 环境配置教程

[centos安装LNMP环境](https://n.tiayo.com/article/linux/1/4/4/144.html)

[centos安装与配置supervisor](https://n.tiayo.com/article/linux/2/1/5/215.html)

#### 部分错误代码

````
1001 管理员权限错误

1002 任务操作权限错误

1003 订单操作没有权限

1004 没有找到订单

1005 文章操作权限错误

1006 评论操作权限错误

1007 消息没有操作权限
````

#### 许可

随享V5.0是根据[MIT license](http://opensource.org/licenses/MIT)开发的开源软件。