# Pasos para iniciar el proyecto

1- correr:

    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

2- copiar y configurar el archivo de configuración (.env)

    cp .env.example .env

Tu configuración de base de datos puede ser así:
    
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password

3- Correr:

    ./vendor/bin/sail up -d
    ./vendor/bin/sail artisan key:generate


4- correr: ("sail" es un alias de ./vendor/bin/sail)
    
    sail nom install
    sail npm run dev

    sail artisan migrate
    sail artisan db:seed