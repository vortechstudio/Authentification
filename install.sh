#!/bin/bash

HC='\033[0;32m' # Heading Color
SC='\033[0;35m' # Success Color
WC='\033[0;33m' # Warning Color
NC='\033[0m' # No Color

echo -e "${HC}::::::::::::::::INSTALLATION::::::::::::::${NC}"

echo "Quel est le mode de déploiement ? (staging,prod)"
read mode

# shellcheck disable=SC1073
if [ $mode = "staging" ]; then
    echo -e "${WC}CHANNEL TESTING${NC}"
    echo "Installation des packages Composer"
    composer install --ignore-platform-reqs --no-interaction --prefer-dist
    touch vendor/autoload.php

    echo "Installation des packages NPM & Build des systèmes"
    npm i
    npm run build

    echo -e "${HC}Initialisation de l'instance laravel${NC}"
    read -p "PLEASE FIRST UPLOADE YOUR .env FILE TO SERVER AND THEN PRESS y : " answer
    case ${answer:0:1} in
        y|Y )
            if [ -e .env ]; then
                echo -e "${SC} Fichier .env trouvé${NC}"
            else
                echo -e "${WC} Fichier .env non trouvé${NC}"
                exit 1
            fi
        ;;
        * )
            echo  -e "${WC}>PLEASE REMEMBER TO UPLOAD .env FILE ON SERVER THEN MIGRATE & SEED THE DATABASE LATER${NC}"
        ;;
    esac

    echo -e "${HC}Initialisation en cours...${NC}"
    php artisan key:generate
    php artisan storage:link
    echo -e "${SC}Permissions accordées${NC}"
    echo -e "${HC}Vérification et initialisation de la base de donnée${NC}"

    php artisan migrate --seed --force
    php artisan db:seed --class=TestSeeder --force

    echo -e "${HC}Migration Terminer${NC}"

    chmod -R 777 bootstrap/cache storage/
    php artisan optimize:clear

    echo "Fin de l'installation"
    echo "////////////////////////////////////////////"
    echo "//             RECOMMANDATION             //"
    echo "////////////////////////////////////////////"
    echo "- Définisser le supervisor pour horizon"
    echo "- Vérifier les instances horizon et pulse"
    echo "////////////////////////////////////////////"
    echo "Veuillez utiliser la commande 'php artisan update' afin de mettre à jour l'application manuellement si necessaire"
else
    echo -e "${WC}CHANNEL PRODUCTION${NC}"
    echo "Installation des packages Composer"
    composer install --ignore-platform-reqs --no-interaction --prefer-dist
    touch vendor/autoload.php

    echo "Installation des packages NPM & Build des systèmes"
    npm i
    npm run build

    echo -e "${HC}Initialisation de l'instance laravel${NC}"
    read -p "PLEASE FIRST UPLOADE YOUR .env FILE TO SERVER AND THEN PRESS y : " answer
    case ${answer:0:1} in
        y|Y )
            if [ -e .env ]; then
                echo -e "${SC} Fichier .env trouvé${NC}"
            else
                echo -e "${WC} Fichier .env non trouvé${NC}"
                exit 1
            fi
        ;;
        * )
            echo  -e "${WC}>PLEASE REMEMBER TO UPLOAD .env FILE ON SERVER THEN MIGRATE & SEED THE DATABASE LATER${NC}"
        ;;
    esac

    echo -e "${HC}Initialisation en cours...${NC}"
    php artisan key:generate
    php artisan storage:link
    echo -e "${SC}Permissions accordées${NC}"
    echo -e "${HC}Vérification et initialisation de la base de donnée${NC}"

    php artisan migrate --seed --force

    echo -e "${HC}Migration Terminer${NC}"

    chmod -R 777 bootstrap/cache storage/
    php artisan optimize:clear

    echo "Fin de l'installation"
    echo "////////////////////////////////////////////"
    echo "//             RECOMMANDATION             //"
    echo "////////////////////////////////////////////"
    echo "- Définisser le supervisor pour horizon"
    echo "- Vérifier les instances horizon et pulse"
    echo "////////////////////////////////////////////"
    echo "Veuillez utiliser la commande 'php artisan update' afin de mettre à jour l'application manuellement si necessaire"
fi
