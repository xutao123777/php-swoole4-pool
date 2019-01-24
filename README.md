# php-swoole4-pool
基于swoole4的数据库连接池

本实例需要安装swoole4 扩展 php7.1

cd swoole-src

phpize

./configure  # ./configure --with-php-config=/www/server/php/73/bin/php-config

注意: 安装多个版本的PHP 需要指定php-config的位置(find / -name php-config)

make 

sudo make install

bool.sql 为测试数据库
