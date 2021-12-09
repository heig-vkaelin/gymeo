SET client_encoding TO 'UTF-8';

/* ---------------------------------------------------------------------------- */
/*                               Création des types                             */
/* ---------------------------------------------------------------------------- */
CREATE TYPE DIFFICULTE AS ENUM('Facile', 'Moyen', 'Difficile');

/* ---------------------------------------------------------------------------- */
/*                               Création des tables                            */
/* ---------------------------------------------------------------------------- */
DROP TABLE IF EXISTS GroupementMusculaire CASCADE;
CREATE TABLE GroupementMusculaire(
    nom VARCHAR(50),
    CONSTRAINT PK_GroupementMusculaire PRIMARY KEY (nom)
);

DROP TABLE IF EXISTS Matériel CASCADE;
CREATE TABLE Matériel(
    id SERIAL,
    nom VARCHAR(50),
    description TEXT,
    CONSTRAINT PK_Matériel PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Exercice;
CREATE TABLE Exercice (
    nom VARCHAR(50),
    description TEXT,
    nbSériesConseillé SMALLINT CHECK (nbSériesConseillé > 0),
    nbRépétitionsConseillé SMALLINT CHECK (nbSériesConseillé > 0),
    tempsExécutionConseiller INTEGER CHECK (tempsExécutionConseiller > 0),
    difficulté DIFFICULTE NOT NULL,
    idMatériel INTEGER,
    CONSTRAINT PK_Exercice PRIMARY KEY (nom)
);

DROP TABLE IF EXISTS Programme;
CREATE TABLE Programme (
    id SERIAL,
    nom VARCHAR(50) NOT NULL,
    idUtilisateur INTEGER NOT NULL,
    CONSTRAINT PK_Programme PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Lieu CASCADE;
CREATE TABLE Lieu (
    nom VARCHAR(50),
    CONSTRAINT PK_Lieu PRIMARY KEY (nom)
);

DROP TABLE IF EXISTS Séance CASCADE;
CREATE TABLE Séance (
    id SERIAL,
    date DATE NOT NULL,
    estTerminée BOOLEAN DEFAULT FALSE NOT NULL,
    idProgramme INTEGER NOT NULL,
    CONSTRAINT PK_Séance PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Série CASCADE;
CREATE TABLE Série (
    id SERIAL,
    nbRépétitions SMALLINT,
    tempsExécution INTEGER,
    poids SMALLINT,
    idSéance INTEGER NOT NULL,
    nomExercice VARCHAR(50) NOT NULL,
    CONSTRAINT PK_Série PRIMARY KEY (id)
);


DROP TABLE IF EXISTS Utilisateur CASCADE;
CREATE TABLE Utilisateur (
    id SERIAL,
    pseudonyme VARCHAR(30) UNIQUE NOT NULL,
    dateNaissance DATE NOT NULL,
    CONSTRAINT PK_Utilisateur PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Matériel_GroupementMusculaire CASCADE;
CREATE TABLE Matériel_GroupementMusculaire (
    idMatériel INTEGER,
    nomGroupementMusculaire VARCHAR(50),
    CONSTRAINT PK_Matériel_GroupementMusculaire PRIMARY KEY (idMatériel, nomGroupementMusculaire)
);

DROP TABLE IF EXISTS Exercice_GroupementMusculaire CASCADE;
CREATE TABLE Exercice_GroupementMusculaire (
    nomExercice VARCHAR(50),
    nomGroupementMusculaire VARCHAR(50),
    CONSTRAINT PK_Exercice_GroupementMusculaire PRIMARY KEY (nomExercice, nomGroupementMusculaire)
);

DROP TABLE IF EXISTS Programme_Exercice CASCADE;
CREATE TABLE Programme_Exercice (
    nomExercice VARCHAR(50),
    idProgramme INTEGER,
    tempsPause SMALLINT,
    nbSéries SMALLINT,
    ordre SMALLINT NOT NULL,
    CONSTRAINT PK_Programme_Exercice PRIMARY KEY (nomExercice, idProgramme)
);

/* ---------------------------------------------------------------------------- */
/*                               Création des index                             */
/* ---------------------------------------------------------------------------- */
CREATE INDEX IDX_FK_Exercice_idMatériel ON Exercice(idMatériel, ASC);

CREATE INDEX IDX_FK_Programme_idUtilisateur ON Programme(idUtilisateur, ASC);

CREATE INDEX IDX_FK_Séance_idProgramme ON Séance(idProgramme, ASC);

CREATE INDEX IDX_FK_Programme_idMatériel ON Programme(idUtilisateur, ASC);

CREATE INDEX IDX_FK_Série_nomExercice ON Série(nomExercice, ASC);

CREATE INDEX IDX_FK_Série_idSéance ON Série(idSéance, ASC);

CREATE INDEX IDX_FK_Matériel_GroupementMusculaire_idMatériel ON Matériel_GroupementMusculaire(idMatériel, ASC);

CREATE INDEX IDX_FK_Matériel_GroupementMusculaire_nomGroupementMusculaire ON Matériel_GroupementMusculaire(nomGroupementMusculaire, ASC);

/* TODO FINIR LES INDEX */
FK_Matériel_GroupementMusculaire_idMatériel
FK_Matériel_GroupementMusculaire_nomGroupementMusculaire

FK_Programme_Exercice_nomExercice
FK_Programme_Exercice_idProgramme

/* ---------------------------------------------------------------------------- */
/*                               Création des contraintes                       */
/* ---------------------------------------------------------------------------- */
ALTER TABLE Exercice
    ADD CONSTRAINT FK_Exercice_idMatériel
        FOREIGN KEY (idMatériel)
            REFERENCES Matériel (id)
ON DELETE SET NULL
ON UPDATE CASCADE;

ALTER TABLE Programme
    ADD CONSTRAINT FK_Programme_idUtilisateur
        FOREIGN KEY (idUtilisateur)
            REFERENCES Utilisateur (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Séance
    ADD CONSTRAINT FK_Séance_idProgramme
        FOREIGN KEY (idProgramme)
            REFERENCES Programme (id)
ON DELETE SET NULL
ON UPDATE CASCADE;

ALTER TABLE Série
    ADD CONSTRAINT FK_Série_idSéance
        FOREIGN KEY (idSéance)
            REFERENCES Séance (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Série
    ADD CONSTRAINT FK_Série_nomExercice
        FOREIGN KEY (nomExercice)
            REFERENCES Exercice (nom)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Matériel_GroupementMusculaire
    ADD CONSTRAINT FK_Matériel_GroupementMusculaire_idMatériel
        FOREIGN KEY (idMatériel)
            REFERENCES Matériel (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Matériel_GroupementMusculaire
    ADD CONSTRAINT FK_Matériel_GroupementMusculaire_nomGroupementMusculaire
        FOREIGN KEY (nomGroupementMusculaire)
            REFERENCES GroupementMusculaire (nom)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Exercice_GroupementMusculaire
    ADD CONSTRAINT FK_Exercice_GroupementMusculaire_idMatériel
        FOREIGN KEY (idMatériel)
            REFERENCES Matériel (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Exercice_GroupementMusculaire
    ADD CONSTRAINT FK_Exercice_GroupementMusculaire_nomGroupementMusculaire
        FOREIGN KEY (nomGroupementMusculaire)
            REFERENCES GroupementMusculaire (nom)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Programme_Exercice
    ADD CONSTRAINT FK_Programme_Exercice_nomExercice
        FOREIGN KEY (nomExercice)
            REFERENCES Exercice (nom)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Programme_Exercice
    ADD CONSTRAINT FK_Programme_Exercice_idProgramme
        FOREIGN KEY (idProgramme)
            REFERENCES Programme (id)
ON DELETE CASCADE
ON UPDATE CASCADE;
