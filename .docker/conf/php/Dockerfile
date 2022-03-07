FROM php:8.1.3-apache

# Alterando a pasta pública
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && echo "America/Sao_Paulo" > /etc/timezone

# Atualizando e instalando bibliotecas
RUN apt-get update \
    && apt-get upgrade -y \
    && apt-get install -y \
		npm \
        cron \
        vim \
        curl \
        zip \
		libbz2-dev \
        libzip-dev \
        zlib1g-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libmcrypt-dev \
        libcurl3-dev \
        libldap2-dev \
        libxml2-dev \
    # Habilitando o modo de reescrita do Apache
    && a2enmod rewrite \
	# Instalação de extensões do PHP
	&& docker-php-ext-install \
        pdo_mysql \
		zip \
        gd \
		curl

# Instalação do composer	
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalação e configuração do XDebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >>  /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=docker" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.default_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
	&& docker-php-ext-enable xdebug