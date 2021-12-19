FROM php:8.1-cli

ENV COMPOSER_VERSION 2.1.14

# Update and install packages
RUN apt-get update
RUN apt-get install -y zip wget

# Install Composer
# see https://github.com/RobLoach/docker-composer
RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }"
RUN php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --version=${COMPOSER_VERSION} && rm -rf /tmp/composer-setup.php

# Application
COPY . /app
WORKDIR /app
RUN composer install

EXPOSE 8081

# Run app
CMD php ./server.php