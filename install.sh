#!/bin/bash

echo "//////////////////////////////////////////////"
echo "//             INSTALLATION                 //"
echo "//////////////////////////////////////////////"

echo "Quel est le mode de déploiement ? (test,prod)"
read mode

# shellcheck disable=SC1073
if [ $mode = "test"]
then
    echo "CHANNEL TESTING"
    echo "Installation des packages Composer"
    composer install --ignore-platform-reqs --no-interaction --prefer-dist
    touch vendor/autoload.php

    echo "Installation des packages NPM & Build des systèmes"
    npm i
    npm run build

    echo "Initialisation de l'instance laravel"
    cp .env.test .env
    php artisan key:generate
    php artisan storage:link
    chmod -R 777 bootstrap/cache storage/

    echo "Migration et peuplement initial"
    php artisan migrate --seed --force
    php artisan db:seed --class=TestSeeder --force
    php artisan optimize:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear

    echo "Fin de l'installation"
    echo "////////////////////////////////////////////"
    echo "//             RECOMMANDATION             //"
    echo "////////////////////////////////////////////"
    echo "- Définisser le supervisor pour horizon"
    echo "- Vérifier les instances horizon et pulse"
    echo "////////////////////////////////////////////"
    echo "Veuillez utiliser la commande 'php artisan update' afin de mettre à jour l'application manuellement si necessaire"
else
    echo "CHANNEL PRODUCTION"
    echo "Installation des packages Composer"
    composer install --ignore-platform-reqs --no-interaction --prefer-dist
    touch vendor/autoload.php

    echo "Installation des packages NPM & Build des systèmes"
    npm i
    npm run build

    echo "Initialisation de l'instance laravel"
    cp .env.prod .env
    php artisan key:generate
    php artisan storage:link
    chmod -R 777 bootstrap/cache storage/

    echo "Migration et peuplement initial"
    php artisan migrate --seed --force
    php artisan optimize:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear

    echo "Fin de l'installation"
    echo "////////////////////////////////////////////"
    echo "//             RECOMMANDATION             //"
    echo "////////////////////////////////////////////"
    echo "- Définisser le supervisor pour horizon"
    echo "- Vérifier les instances horizon et pulse"
    echo "////////////////////////////////////////////"
    echo "Veuillez utiliser la commande 'php artisan update' afin de mettre à jour l'application manuellement si necessaire"
fi





