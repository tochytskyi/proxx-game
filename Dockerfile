FROM php:8.1-cli-alpine

COPY . /usr/src/app
WORKDIR /usr/src/app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
#RUN composer config github-oauth.github.com $GITHUB_COMPOSER_TOKEN
RUN composer install

CMD [ "php", "./run.php" ]