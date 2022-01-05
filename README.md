# bdr-project

Gymeo App

## Installation

Dépendances à installer:

- [Composer](https://getcomposer.org/download/)
- [UwAmp](https://www.uwamp.com/fr/?page=download) pour le serveur Apache
- (PHP) dispo via UwAmp

Lors de l'installation de Composer, il faut préciser le chemin du php de UwAmp (`bin/php/php-7.0.3`).

Une fois cela fait, il faut copier le contenu du dossier `src` dans le dossier `www` de UwAmp.

Lors de la création de nouveaux fichiers php, il est nécessaire de mettre à jour les fichiers d'importation de Composer via la commande suivante:

```bash
composer dump-autoload
```
