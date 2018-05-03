FROM php:apache
RUN docker-php-ext-install pdo pdo_mysql
RUN echo -e “$(hostname -i)\t$(hostname) $(hostname).localhost” >> /etc/hosts
