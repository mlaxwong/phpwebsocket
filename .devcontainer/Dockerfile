FROM php:8.1.1-fpm

ENV COMPOSER_VERSION 2.1.14
ENV NODE_VERSION=17.3.0
ENV NVM_DIR=/usr/local/nvm
ENV APP_ROOT /app

# Update
RUN apt-get update && \
    apt-get upgrade -y

# Install git, process tools
RUN apt-get -y install \ 
	git \ 
	procps \
    zip \
    curl \
	wget \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    libmagickwand-dev \
	libzip-dev \
	libonig-dev \
    g++

# PHP extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    mbstring \
    pdo_mysql \
    zip

# install imagick
# Version is not officially released https://pecl.php.net/get/imagick but following works for PHP 8
# RUN mkdir -p /usr/src/php/ext/imagick; \
#     curl -fsSL https://github.com/Imagick/imagick/archive/06116aa24b76edaf6b1693198f79e6c295eda8a9.tar.gz | tar xvz -C "/usr/src/php/ext/imagick" --strip 1; \
#     docker-php-ext-install imagick;

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }"
RUN php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} && rm -rf /tmp/composer-setup.php
RUN composer --version

# Install xdebug
RUN yes | pecl install xdebug \
	&& echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" \
		 > /usr/local/etc/php/conf.d/xdebug.ini \
	&& echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
	&& echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
	&& echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
	&& echo "xdebug.log_level=0" >> /usr/local/etc/php/conf.d/xdebug.ini

# Install NodeJS
RUN mkdir ${NVM_DIR} && curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.3/install.sh | bash
ENV NODE_PATH ${NVM_DIR}/v${NODE_VERSION}/lib/node_modules
ENV PATH ${NVM_DIR}/versions/node/v${NODE_VERSION}/bin:$PATH
RUN node -v
RUN npm -v

# Application
WORKDIR ${APP_ROOT}
RUN echo "<?php phpinfo(); ?>" > index.php

# Permission
RUN chmod -R 755 ${APP_ROOT}

VOLUME /app

# Clean up
RUN apt-get autoremove -y \
    && apt-get clean -y \
    && rm -rf /var/lib/apt/lists/*

# VSCode as Git editor 
RUN git config --global user.email "${GIT_CONFIG_USER_EMAIL}"
RUN git config --global user.name "${GIT_CONFIG_USER_NAME}"
RUN git config --global core.editor "code --wait"