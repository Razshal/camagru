FROM php:5.6-apache-jessie

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && \
  apt-get install -y ssmtp && \
  apt-get clean && \
  echo "FromLineOverride=YES" >> /etc/ssmtp/ssmtp.conf \
  #&& echo 'sendmail_path = "/usr/sbin/ssmtp -t"' > /usr/local/etc/php/conf.d/mail.ini
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr smtp.42.fr' > /usr/local/etc/php/php.ini