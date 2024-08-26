FROM dunglas/frankenphp:php8.3.10-alpine

RUN install-php-extensions pcntl

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="1"

ENV TZ=America/Sao_Paulo

RUN apk update && apk add \
      bash \
      tzdata \
      postgresql-client \
      libzip-dev \
      gnupg \
      libxslt-dev \
      make \
      pcre-dev \
      unzip \
      wget \
      zip \
      zlib-dev \
      curl \
      curl-dev \
      libpq \
      supervisor \
      nodejs \
      npm

RUN  apk add --no-cache --virtual .build-deps \
      autoconf \
      automake \
      g++ \
      gcc \
      gettext \
      libc-dev \
      libtool \
      linux-headers \
      musl-dev \
      perl-dev \
      postgresql-libs \
      postgresql-dev \
      zlib-dev \
      icu-dev

# Pcntl
RUN docker-php-ext-install pcntl

RUN docker-php-ext-install pdo_pgsql pgsql

# intl
RUN docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-enable intl

WORKDIR /app

COPY . /app

COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

RUN composer install

# RUN composer require laravel/octane sanctum

RUN npm install

EXPOSE 8000

ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--watch"]
# CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]

