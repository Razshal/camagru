FROM php:apache
RUN apt-get update && \
  apt-get install -y ssmtp && \
  apt-get clean && \
  echo "FromLineOverride=YES" >> /etc/ssmtp/ssmtp.conf && \
  echo 'sendmail_path = "/usr/sbin/ssmtp -t"' > /usr/local/etc/php/conf.d/mail.ini
RUN docker-php-ext-install pdo pdo_mysql
RUN echo -e “$(hostname -i)\t$(hostname) $(hostname).localhost” >> /etc/hosts