# Avengers - MarquePage (Symfony)

Application Symfony 7.4 de gestion simple de marque-pages.

## Stack technique

- PHP >= 8.2
- Symfony 7.4
- Doctrine ORM + Doctrine Migrations
- Twig
- PHPUnit 12
- Docker Compose present (services database + mailer)

## Fonctionnalites actuelles

- Lister les marque-pages en base
- Afficher le detail d un marque-page
- Inserer 3 marque-pages de demonstration via une route

## Structure utile

- `src/Controller/MarquePageController.php`: routes et logique principale
- `src/Entity/MarquePage.php`: entite Doctrine
- `templates/MarquePage/index.html.twig`: page liste
- `templates/MarquePage/details.html.twig`: page detail
- `migrations/`: migrations Doctrine

## Prerequis

- Composer
- PHP 8.2+
- Un serveur de base de donnees
- Optionnel: Docker Desktop (si vous voulez utiliser compose)

## Installation

Prérequis rapides: PHP >= 8.2, Composer, une base de données (MySQL ou PostgreSQL), Git.

1) Installer Composer

- Recommandé: installer Composer globalement depuis https://getcomposer.org/download/ (Windows installer).
- Alternative (sans installation globale) :

```powershell
php -r "copy('https://getcomposer.org/installer','composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
# puis dans le projet
php composer.phar install
```

2) Installer les dépendances PHP

```bash
composer install
```

3) Configurer la base de données

- Le projet lit `DATABASE_URL` dans `.env` (préférer créer `.env.local` non commité pour vos secrets).
- Exemple `.env.local` pour MySQL :

```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/avengers_aminhandoyo-camelia?serverVersion=9.1.0&charset=utf8mb4"
```

4) Remplir la base (deux options)

- Option A — importer le dump SQL fourni (rapide) :

	- Créez la base (si nécessaire) puis importez `avengers_aminhandoyo-camelia.sql` via phpMyAdmin ou :

	```bash
	mysql -u root -p avengers_aminhandoyo-camelia < avengers_aminhandoyo-camelia.sql
	```

- Option B — exécuter les migrations Doctrine :

	```bash
	php bin/console doctrine:database:create
	php bin/console doctrine:migrations:migrate
	# (optionnel) charger les fixtures
	php bin/console doctrine:fixtures:load
	```

5) Lancer le serveur local

- Sans Symfony CLI :

```powershell
php -S 127.0.0.1:8080 -t public
```

- Avec Symfony CLI (optionnel) :

```bash
symfony server:start
```

Ouvrez ensuite `http://127.0.0.1:8080/MarquePage/` (adapter le port si besoin).

6) Conseils Windows & dépannage

- Si `composer` n'est pas reconnu : utilisez `php composer.phar install` ou installez Composer globalement.
- Si `php -S` renvoie une erreur de port, changez de port (ex. `8080` ou `8001`) ou exécutez PowerShell en administrateur.
- Message d'erreur type "vendor/autoload_runtime.php missing" signifie que `composer install` n'a pas été exécuté.
- Pour améliorer les perfs sur Windows, ajoutez dans le `php.ini` utilisé par la CLI :

	```ini
	realpath_cache_size=5M
	```

7) Lancement via Docker (optionnel)

- Le projet contient un `compose.yaml`. Par défaut il utilise PostgreSQL : adaptez `DATABASE_URL` si vous préférez MySQL ou changez la configuration Docker.

```bash
docker compose up -d
```

8) Commandes utiles

```bash
php bin/console cache:clear
php bin/phpunit
```

Si vous voulez, je peux ajouter un script PowerShell d'installation automatique pour Windows (installation Composer locale + `composer install` + import SQL). Dites‑moi si vous le souhaitez.

## Lancement en local (sans Docker)

```bash
symfony server:start
```

Si la CLI Symfony n est pas installee:

```bash
php -S 127.0.0.1:8000 -t public
```

Puis ouvrir:

- http://127.0.0.1:8000/MarquePage/

## Lancement via Docker Compose

Le fichier `compose.yaml` configure une base PostgreSQL, alors que `.env` pointe actuellement vers MySQL.

Si vous voulez utiliser Docker tel quel, adaptez `DATABASE_URL` vers PostgreSQL (ou adaptez `compose.yaml` pour MySQL), puis lancez:

```bash
docker compose up -d
```

## Routes principales

Base de route controller:

- `/MarquePage` (prefix)

Routes:

- `GET /MarquePage/` : liste des marque-pages
- `GET /MarquePage/details/{id}` : detail d un marque-page (id numerique)
- `GET /MarquePage/ajouter` : insere 3 marque-pages de demo

## Commandes utiles

Vider le cache:

```bash
php bin/console cache:clear
```

Executer les tests:

```bash
php bin/phpunit
```

## Remarques

- Le nom de route utilise un `M` majuscule (`/MarquePage`), garder cette casse dans l URL.
- La route `/MarquePage/ajouter` ajoute des donnees a chaque appel.

## Auteur

Projet: `avengers_aminhandoyo-camelia`
