FROM nginx:latest

#######################
## php & php extend
#######################

RUN apt-get update && apt-get install -y apt-transport-https lsb-release ca-certificates wget
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list
RUN apt-get update && apt-get install -y \
    php5.6-fpm \
    php5.6-gd \
    php5.6-curl \
    php5.6-cli \
    php5.6-mbstring \
    libcurl3 \
    libcurl3-dev \
    php5.6-mysql \
    php5.6-readline \
    php5.6-mcrypt \
    php5.6-xml

#######################
# fix timezone and date
#######################

ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

#######################
## tools
#######################

RUN apt-get update && apt-get install -y vim git curl cron

#######################
## composer
#######################

RUN curl -sS https://getcomposer.org/installer | php -d detect_unicode=Off
RUN chmod a+x composer.phar && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update

#######################
# configuration for nginx
#######################

ADD nginx/nginx.conf /etc/nginx/
ADD nginx/koala.conf /etc/nginx/conf.d/
RUN mv /etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf.bak

# RUN composer config -g repo.packagist composer https://packagist.phpcomposer.com

ADD entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
EXPOSE 443

WORKDIR /usr/share/nginx/html

ENTRYPOINT ["entrypoint.sh"]