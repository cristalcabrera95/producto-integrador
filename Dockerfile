# Usamos la imagen oficial de PHP con Apache
FROM php:8.2-apache

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Habilitamos mod_rewrite (útil para rutas amigables)
RUN a2enmod rewrite

# Instalamos dependencias del sistema necesarias para GD, Intl y Composer
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip intl \
    && rm -rf /var/lib/apt/lists/*

# Instalamos Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Cambiamos el DocumentRoot a public/ para CodeIgniter 4
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Configuramos Apache para CodeIgniter
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/codeigniter.conf \
    && a2enconf codeigniter

# Exponemos el puerto 80
EXPOSE 80

# Iniciamos Apache
CMD ["apache2-foreground"]