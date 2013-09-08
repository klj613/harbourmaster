FROM ubuntu:12.04
MAINTAINER Kristian Lewis Jones <klj613@kristianlewisjones.com>

RUN echo "deb http://archive.ubuntu.com/ubuntu precise main universe" > /etc/apt/sources.list
RUN apt-get -y update
RUN apt-get -y upgrade

# Apache
RUN apt-get -y install apache2
RUN rm /etc/apache2/sites-enabled/*
RUN a2enmod rewrite
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2

# Mongo
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv 7F0CEB10
RUN echo "deb http://downloads-distro.mongodb.org/repo/ubuntu-upstart dist 10gen" | tee -a /etc/apt/sources.list.d/10gen.list
RUN apt-get -y update
RUN apt-get -y install mongodb-10gen

# PHP w/ mongo w/ apache
RUN apt-get -y install php5 php-pear php5-dev libapache2-mod-php5
RUN apt-get -y install make # Needed for "pecl install mongo"
RUN pecl install mongo
RUN echo "extension=mongo.so" | tee -a /etc/php5/conf.d/mongo.ini

# Harbourmaster
ADD . /var/www/harbourmaster
RUN mkdir -p /var/www/harbourmaster/writable/cache
RUN chown www-data:www-data -R /var/www/harbourmaster/writable/cache
RUN cd /var/www/harbourmaster && php ./composer.phar install
RUN cp /var/www/harbourmaster/vhost.dist /etc/apache2/sites-enabled/harbourmaster
EXPOSE 80

# Supervisord
RUN apt-get install -y supervisor
ADD ./supervisord.conf /etc/supervisor/conf.d/harbourmaster.conf
CMD ["supervisord", "-n"]
