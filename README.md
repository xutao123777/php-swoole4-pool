# php-swoole4-pool
基于swoole4的数据库连接池

本实例需要安装swoole4 扩展 

php >= 7.0

cd swoole-src

phpize

./configure  # ./configure --with-php-config=/www/server/php/73/bin/php-config

注意: 安装多个版本的PHP 需要指定php-config的位置(find / -name php-config)

make 

sudo make install

bool.sql 为测试数据库


CREATE DATABASE IF NOT EXISTS book DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;

开放端口号:
firewall-cmd --permanent --zone=public --add-port=9501/tcp
success
firewall-cmd --reload

curl http://IP地址 :9501/
[{"id":"1","name":"PHP","addtime":"13242323","click_count":"23"}]
