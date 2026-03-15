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

1. Installer les dependances PHP:

```bash
composer install
```

2. Configurer les variables d environnement:

- Le projet utilise `DATABASE_URL` dans `.env`.
- Valeur actuelle dans `.env`: MySQL local (`mysql://root:@127.0.0.1:3306/avengers_aminhandoyo-camelia?...`).

3. Creer la base et appliquer les migrations:

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

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
