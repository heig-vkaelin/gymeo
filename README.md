# Project BDR - gymeo

## Introduction

Notre application gymeo a pour but de permettre à toute personne pratiquant de l’entraînement physique comme du fitness, du CrossFit ou encore du Street Workout, de pouvoir enregistrer ses séances et visualiser sa progression. Les utilisateurs peuvent créer des programmes à partir d’exercices existants et visionner leurs historiques de séances.

## Installation

Le projet a mis en place avec Docker. Il est donc nécessaire d’avoir [Docker](https://docs.docker.com/desktop/) et Docker-Compose sur sa machine.

Docker-Compose s’installe automatiquement à l’installation de Docker.

Aucun autre prérequis n’est nécessaire, PHP et Postgresql sont directement installés et configurés dans le container Docker.

Une fois cela fait, le lancement du site et de la base de données se fait en réalisant la commande suivante à la racine du répertoire:

```bash
docker-compose up
```

Il est également possible d’ajouter l’attribut `-d` à la commande afin de pouvoir fermer la console tout en gardant l’application en ligne.

Par la suite, le site est disponible à l’adresse suivante: [localhost:8080](http://localhost:8080/)

Quant à la base de données, elle a été créée et remplie automatiquement. Il est possible de s’y connecter via n’importe quel logiciel de gestion de base de données (ex: DBeaver) en utilisant les informations suivantes:

```bash
Host: localhost
Port: 5433
Utilisateur: postgres
Mot de passe: admin
Nom de la base de données: gymeo
```

Pour finir, l’arrêt du container se fait via la commande suivante (toujours à la racine du répertoire):

```bash
docker-compose down
```

### Remise à zéro de la base de données

Afin de retourner à l’état initial de la base de données, quelques opérations doivent être effectuées sur Docker.

Premièrement, il est nécessaire de stopper le container avec la commande expliquée précédemment: `docker-compose down`.

Ensuite il faut supprimer le volume utilisé par ledit container. Cette opération peut être effectuée en ligne de commande:
`docker volume rm bdr-project_pgdata`

Pour finir, il faut relancer le container via la commande expliquée précédemment `docker-compose up`.

## Fonctionnalités de l'application

- Un utilisateur peut s’identifier sur l’application via son pseudonyme.

### Exercices à disposition pour les programmes

- L’application dispose de modèles d’exercices partagés entre tous les utilisateurs, expliquant les mouvements à réaliser. Un exercice se catégorise via différents critères : un lieu (ex : en intérieur, au fitness, …), un besoin ou non de matériel et le ou les muscle(s) qu’il travaille.

- L’affichage des exercices peut être trié via plusieurs filtres, simultanément ou non : par lieu, besoin de matériel ou non et par muscle travaillé.

- Un utilisateur peut se créer différents programmes, comprenant des exercices existants, ainsi que les supprimer par la suite. Ces programmes ne sont visibles que par l’utilisateur qui les a créés. L’utilisateur peut ranger les exercices dans un ordre voulu dans son programme. L'utilisateur peut modifier ces programmes en tout temps.

### Enregistrement des performances de l’utilisateur lors de sa séance

- Lorsque l’utilisateur pratique son activité physique, il peut créer une séance d’un de ces programmes et enregistrer ses performances.

- Les séances concernent les exercices du programme et contiennent plusieurs séries par exercice. Pour chaque série, l’utilisateur peut définir son nombre de répétitions si cela est nécessaire, le temps de réalisation ainsi que le poids utilisé en cas d’utilisation de matériel.

### Historique des séances

- Un utilisateur peut visionner l’historique de ses entraînements, quel programme a été réalisé à quelle date.

- L’utilisateur dispose également d’un historique des séries dans lequel il peut comparer l’évolution de son nombre de répétitions ou du temps de réalisation. Cela lui permet d’avoir une idée générale de l’évolution de ses performances.
