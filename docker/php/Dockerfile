
FROM ubuntu:18.04
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apt-get update && apt-get upgrade -y && apt-get install -y apt-utils vim curl git unzip wget
RUN apt-get install -y php7.2 php7.2-fpm php7.2-xml php7.2-curl php-xdebug php7.2-zip php-mbstring php-dev libmcrypt-dev php-pear
RUN pecl channel-update pecl.php.net && pecl install mcrypt-1.0.1

ADD etc/php/7.2/cli/conf.d/config.ini /etc/php/7.2/cli/conf.d/
ADD etc/php/7.2/fpm/conf.d/config.ini /etc/php/7.2/fpm/conf.d/
ADD etc/php/7.2/fpm/pool.d/www.conf /etc/php/7.2/fpm/pool.d/
RUN mkdir /run/php

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer


# install phpunit
RUN wget -O /usr/local/bin/phpunit -q https://phar.phpunit.de/phpunit-6.5.9.phar
RUN chmod +x /usr/local/bin/phpunit

EXPOSE 9000

WORKDIR /home/app/slimApp

CMD ["php-fpm7.2", "-F"]