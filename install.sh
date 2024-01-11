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
    cp .env.staging .env

    echo "Quel est le mot de passe de la base de donnée:"
    read db_password
    sed -i "s/DB_PASSWORD=/DB_PASSWORD=$db_password/g" .env

    echo "Quel est le mot de passe de l'authentificateur MAIL:"
    read mail_password
    sed -i "s/MAIL_PASSWORD=/MAIL_PASSWORD=$mail_password/g" .env

    echo "Quel est la secret pass key de pusher:"
    read pusher_app_secret
    sed -i "s/PUSHER_APP_SECRET=/PUSHER_APP_SECRET=$pusher_app_secret/g" .env

    echo "Quel est le token de Github:"
    read github_token
    sed -i "s/GITHUB_TOKEN=/GITHUB_TOKEN=$github_token/g" .env

    echo "Quel est la clé d'accès à JIRA:"
    read jira_password
    sed -i "s/JIRA_PASSWORD=/JIRA_PASSWORD=$jira_password/g" .env

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

    echo "Quel est le mot de passe de la base de donnée:"
    read db_password
    sed -i "s/DB_PASSWORD=/DB_PASSWORD=$db_password/g" .env

    echo "Quel est le mot de passe de l'authentificateur MAIL:"
    read mail_password
    sed -i "s/MAIL_PASSWORD=/MAIL_PASSWORD=$mail_password/g" .env

    echo "Quel est la secret pass key de pusher:"
    read pusher_app_secret
    sed -i "s/PUSHER_APP_SECRET=/PUSHER_APP_SECRET=$pusher_app_secret/g" .env

    echo "Quel est le token de Github:"
    read github_token
    sed -i "s/GITHUB_TOKEN=/GITHUB_TOKEN=$github_token/g" .env

    echo "Quel est la clé d'accès à JIRA:"
    read jira_password
    sed -i "s/JIRA_PASSWORD=/JIRA_PASSWORD=$jira_password/g" .env

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





