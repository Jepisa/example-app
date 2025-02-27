# Pasos para iniciar el proyecto

1 - correr 

    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

---- 

2- copiar y configurar el archivo de configuración (.env)

    cp .env.example .env

d