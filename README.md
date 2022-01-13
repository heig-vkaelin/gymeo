# bdr-project

Gymeo App

## Installation

Dépendances à installer:

- [Composer](https://getcomposer.org/download/)
- [UwAmp](https://www.uwamp.com/fr/?page=download) pour le serveur Apache
- (PHP) dispo via UwAmp

Lors de l'installation de Composer, il faut préciser le chemin du php de UwAmp (`bin/php/php-7.0.3`).

Dans l'interface UwAmp, modifier la version de php par la version 7.X.X dans la select box.

Une fois cela fait, il faut copier le contenu du dossier `src` dans le dossier `www` de UwAmp.

Lors de la création de nouveaux fichiers php, il est nécessaire de mettre à jour les fichiers d'importation de Composer via la commande suivante:

```bash
composer dump-autoload
```

Ensuite, il faut activer les bonnes extensions PHP dans le fichier `bin/php/php-7.0.3/php_uwamp.ini`. Pour se faire, il faut décommenter (enlever le `;` au début de ligne) des lignes suivantes:

- extension=php_pdo_pgsql.dll
- extension=php_pgsql.dll

Lancer l'application sans Uwamp (à faire dans le dossier `src`):

```bash
php -S localhost:8080
```

Le site est maintenant disponible à l'adresse: [localhost:8080](http://localhost:8080/)

## TODO

Fonctionnalités obligatoires

- OK - Un utilisateur peut s’identifier sur l’application via son pseudonyme.

### Exercices à disposition pour les programmes

- L’application dispose de modèles d’exercices partagés entre tous les utilisateurs, expliquant les mouvements à réaliser. Un exercice se catégorise via différents critères : un lieu (ex : en intérieur, au fitness, …), un besoin ou non de matériel et le ou les muscle(s) qu’il travaille.

- L’affichage des exercices peut être trié via plusieurs filtres, simultanément ou non : par lieu, besoin de matériel ou non et par muscle travaillé.

- Un utilisateur peut se créer différents programmes, comprenant des exercices existants, ainsi que les supprimer par la suite. Ces programmes ne sont visibles que par l’utilisateur qui les a créés. L’utilisateur peut ranger les exercices dans un ordre voulu dans son programme.

### Enregistrement des performances de l’utilisateur lors de sa séance

- Lorsque l’utilisateur pratique son activité physique, il peut créer une séance d’un de ces programmes et enregistrer ses performances.

- Les séances concernent les exercices du programme et contiennent plusieurs séries par exercice. Pour chaque série, l’utilisateur peut définir son nombre de répétitions si cela est nécessaire, le temps de réalisation ainsi que le poids utilisé en cas d’utilisation de matériel.

### Historique des séances

- Un utilisateur peut visionner l’historique de ses entraînements, quel programme a été réalisé à quelle date.

- L’utilisateur dispose également d’un historique des séries dans lequel il peut comparer l’évolution de son nombre de répétitions ou du temps de réalisation. Cela lui permet d’avoir une idée générale de l’évolution de ses performances.

- L’historique des séries peut être trié par les différentes propriétés des exercices effectués, comme le lieu, le muscle travaillé ou encore la catégorie du muscle.
