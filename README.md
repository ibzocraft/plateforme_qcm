# Plateforme QCM

Une plateforme de Quiz à Choix Multiples développée en PHP avec Bootstrap.

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache/Nginx)
- XAMPP (recommandé pour le développement)

## Installation

1. Clonez ce dépôt dans votre dossier htdocs de XAMPP
2. Créez une base de données MySQL nommée `plateforme_qcm`
3. Importez le schéma de la base de données (à venir)
4. Configurez les paramètres de connexion dans `config.php`
5. Accédez à l'application via votre navigateur : `http://localhost/Web/plateforme_qcm`

## Structure du projet

```
plateforme_qcm/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── main.js
├── includes/
├── references/
│   └── Instructions.docx
├── config.php
├── index.php
└── README.md
```

## Fonctionnalités

- Interface responsive avec Bootstrap 5
- Gestion des utilisateurs
- Création et gestion de quiz
- Système de notation
- Statistiques et rapports

## Technologies utilisées

- PHP
- MySQL
- Bootstrap 5 (CDN)
- JavaScript
- HTML5/CSS3

## Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou à soumettre une pull request.

## Licence

Ce projet est sous licence MIT. 