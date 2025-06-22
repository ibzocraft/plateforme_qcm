# Plateforme QCM

Une plateforme de Quiz à Choix Multiples développée en PHP avec Bootstrap.

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)
- XAMPP (recommandé pour le développement)


## Fichier .env
Lorsque vous venez de clone le projet pour la première fois vous aurez besoin de créer un fichier .env
et d'y copier le contenu du fichier .env.example.
Après cela, vérifier que :
- DB_NAME correspond à la base de donnée que vous avez créé dans votre sql, sinon créez une BDD vide du même nom.
- BASE_URL correspond au lien du répertoire de base de l'application.

## Creation des tables et seeding
Pour créer la base de données et y intégrer des données de tests lancez les trois scripts suivants:
```bash
php ./includes/database/scripts/create_db.php
```
```bash
php ./includes/database/scripts/create_tables.php
```
```bash
php ./includes/database/scripts/seed_db.php
```
Bien évidemment, lancez ces commandes à partir de la racine du projet.

Ou lancer les trois en même temps:
```bash
php ./includes/database/scripts/create_db.php;php ./includes/database/scripts/create_tables.php;php ./includes/database/scripts/seed_db.php
```

POUR UNE MIGRATION DE REINITIALISATION DE LA BASE COMPLETE:
```bash
php ./includes/database/scripts/drop/drop_db.php;php ./includes/database/scripts/create_db.php;php ./includes/database/scripts/create_tables.php;php ./includes/database/scripts/seed_db.php
```

Sur Linux:

```bash
php ./includes/database/scripts/create_db.php&&php ./includes/database/scripts/create_tables.php&&php ./includes/database/scripts/seed_db.php
```
```bash
php ./includes/database/scripts/drop/drop_db.php&&php ./includes/database/scripts/create_db.php&&php ./includes/database/scripts/create_tables.php&&php ./includes/database/scripts/seed_db.php
```

## Régles de développement
