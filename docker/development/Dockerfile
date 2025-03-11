FROM dunglas/frankenphp:php8.3.10-alpine

# Instala extensões PHP
RUN install-php-extensions pcntl

# Define timezone
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="1"
ENV TZ=America/Sao_Paulo

# Instala pacotes essenciais
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

# Instala dependências de build
RUN apk add --no-cache --virtual .build-deps \
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

# Instala extensões PHP
RUN docker-php-ext-install pcntl pdo_pgsql pgsql
RUN docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-enable intl

# Define diretório de trabalho
WORKDIR /app

# Cria diretório antes de copiar arquivos
RUN mkdir -p /app

# Copia arquivos do projeto (sem `vendor/` e `node_modules/`)
COPY . /app

# Copia Composer da imagem oficial
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

# Garante que o Composer pode rodar sem problemas de permissão
RUN chmod -R 777 /app

# Instala dependências do PHP
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || cat /app/composer.log

# Instala dependências do NPM
RUN npm install

# Remove pacotes de build para reduzir o tamanho da imagem
RUN apk del .build-deps

# Expõe a porta usada pelo Laravel Octane
EXPOSE 8000

# Define comando de entrada
ENTRYPOINT ["php", "artisan", "octane:frankenphp", "--watch"]
