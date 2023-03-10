# Ecf-restaurant-webap


##### Application web d'un restaurant avec surface administrable et réservation en ligne construite avec Symfony 6.2 dans le cadre d'un projet scolaire.

## Démarche à suivre pour l'exécution en local de l'application:

Dans un premier temps créez un dossier vide sur votre PC pour recevoir le projet et ouvrez-le avec votre éditeur de text préféré.
Assurez-vous que vous avez une vérsion PHP suffisante: PHP 8.1.0 minimum.

Dans le terminal copiez la commande suivante :

- _git clone https://github.com/AndreaFourel/ecf-restaurant-webapp.git_

Entrez dans le dossier clôné avec la commande :

- _cd ecf-restaurant-webapp_

Crééz un dossier **.env.local** à la racine du projet (ecf-restaurant-webapp) et configurez la connexion de l'application avec votre base de donnée. 
Des exemples sont fournis par Symfony dans le ficher **.env** pour sqlite, mysql et postgresql.

Afin d'installer l'ensemble des dépendances du projet, entrez la commande :

- _composer install_

Crééz la base de données avec doctrine (au préalable, assurez-vous d'avoir correctement configuré les informations de connexion dans votre .env.local):

- _php bin/console doctrine:database:create_

Effectuez les migrations:

- _php bin/console doctrine:migration:migrate_

Démarrez le serveur (assurez vous d'être dans le bon dossier):

- _symfony server:start_
## Un fichier .sql est à votre disposition dans le dossier database afin d'apporter un minimum de données à votre base de données. 
Il contient le mail et le mot de passe du superAdmin pour l'environnement local:
- admin1@mail.com
- admin1234!

## Variables d'environnement utilisées en développement et leurs valeurs (à adapter éventuellement)

- API_HOST=https://localhost:8000/api
- HOME_PATH=/
- EMAIL=admin@myrestaurant.com
