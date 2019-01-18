FROM composer:1.8.0 as vendor

COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM node:10.6.0 as assets

COPY package.json webpack.mix.js package-lock.json /app/
COPY resources/js/ /app/resources/js/
COPY resources/sass/ /app/resources/sass/

WORKDIR /app

RUN npm install && npm run-script production

FROM php:7.2.14-cli

## Install tools required for testing the app on CircleCI
# Ref. https://circleci.com/docs/2.0/custom-images/#adding-required-and-custom-tools-or-files
RUN apt-get update && \
    apt-get install -y \
        git \
        ssh \
        tar \
        gzip \
        ca-certificates \
        zip unzip \
        gnupg

## Install sqlsrv and pdo_sqlsrv
# Ref. https://github.com/Microsoft/msphpsql/wiki/Install-and-configuration#docker-files
# Add Microsoft repo for Microsoft ODBC Driver 13 for Linux
RUN apt-get update && apt-get install -y \
    apt-transport-https \
    && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/9/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update

# Install Dependencies
RUN ACCEPT_EULA=Y apt-get install -y \
    unixodbc \
    unixodbc-dev \
    mssql-tools \
    libgss3 \
    odbcinst \
    msodbcsql17 \
    locales \
    && echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# Install pdo_sqlsrv and sqlsrv from PECL. Replace pdo_sqlsrv-4.1.8preview with preferred version.
RUN pecl install pdo_sqlsrv-5.3.0 sqlsrv-4.1.8preview \
    && docker-php-ext-enable pdo_sqlsrv sqlsrv

RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug

RUN mkdir /app

WORKDIR /app

COPY . /app
COPY --from=vendor /app/vendor/ /app/vendor/
COPY --from=assets /app/public/js/ /app/public/js/
COPY --from=assets /app/public/css/ /app/public/css/
COPY --from=assets /app/public/fonts/ /app/public/fonts/
COPY --from=assets /app/public/mix-manifest.json /app/public/mix-manifest.json

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]
