SET client_encoding TO 'UTF-8';

-- TODO - retours de l'assistant
-- Check les not null, plutôt cascade (surtout que le champ est NOT NULL) 
-- “On delete restrict” si on veut être + spécifique

-- TODO - CI à implémenter
-- Un exercice utilisant un matériel doit travailler les mêmes groupements musculaires que ce dernier. 
-- Une série doit contenir le même attribut que l’exercice auquel elle se rattache (soit nbRépétitions soit tempsExécution). 
-- L'exercice d’une série doit faire partie du programme de cette dernière. 
-- Une fois la séance terminée, il est impossible d’y ajouter une série supplémentaire. 
-- Les numéros des exercices d’un programme s’incrémentent, il n’y a pas de saut entre les différents numéros. Ceux-ci commencent à 1. 

/* ---------------------------------------------------------------------------- */
/*                               Création des types                             */
/* ---------------------------------------------------------------------------- */
DROP TYPE IF EXISTS DIFFICULTE CASCADE;
CREATE TYPE DIFFICULTE AS ENUM('Facile', 'Moyen', 'Difficile');

/* ---------------------------------------------------------------------------- */
/*                               Création des tables                            */
/* ---------------------------------------------------------------------------- */
DROP TABLE IF EXISTS GroupementMusculaire CASCADE;
CREATE TABLE GroupementMusculaire(
    id SERIAL,
    nom VARCHAR(50),
    CONSTRAINT PK_GroupementMusculaire PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Matériel CASCADE;
CREATE TABLE Matériel(
    id SERIAL,
    nom VARCHAR(50) NOT NULL,
    description TEXT,
    CONSTRAINT PK_Matériel PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Exercice CASCADE;
CREATE TABLE Exercice (
    id SERIAL,
    nom VARCHAR(50),
    description TEXT,
    nbSériesConseillé SMALLINT NOT NULL,
    nbRépétitionsConseillé SMALLINT,
    tempsExécutionConseillé INTEGER,
    difficulté DIFFICULTE NOT NULL,
    idMatériel INTEGER,
    CONSTRAINT PK_Exercice PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Programme CASCADE;
CREATE TABLE Programme (
    id SERIAL,
    nom VARCHAR(50) NOT NULL,
    idUtilisateur INTEGER NOT NULL,
    CONSTRAINT PK_Programme PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Lieu CASCADE;
CREATE TABLE Lieu (
    id SERIAL,
    nom VARCHAR(50),
    CONSTRAINT PK_Lieu PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Séance CASCADE;
CREATE TABLE Séance (
    id SERIAL,
    dateDébut TIMESTAMP(0) NOT NULL,
    dateFin TIMESTAMP(0),
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
    idExercice INTEGER NOT NULL,
    CONSTRAINT PK_Série PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Utilisateur CASCADE;
CREATE TABLE Utilisateur (
    id SERIAL,
    pseudonyme VARCHAR(30) NOT NULL,
    dateNaissance DATE NOT NULL,
    CONSTRAINT PK_Utilisateur PRIMARY KEY (id)
);

DROP TABLE IF EXISTS Matériel_GroupementMusculaire CASCADE;
CREATE TABLE Matériel_GroupementMusculaire (
    idMatériel INTEGER,
    idGroupementMusculaire INTEGER,
    CONSTRAINT PK_Matériel_GroupementMusculaire PRIMARY KEY (idMatériel, idGroupementMusculaire)
);

DROP TABLE IF EXISTS Exercice_GroupementMusculaire CASCADE;
CREATE TABLE Exercice_GroupementMusculaire (
    idExercice INTEGER,
    idGroupementMusculaire INTEGER,
    CONSTRAINT PK_Exercice_GroupementMusculaire PRIMARY KEY (idExercice, idGroupementMusculaire)
);

DROP TABLE IF EXISTS Programme_Exercice CASCADE;
CREATE TABLE Programme_Exercice (
    idExercice INTEGER,
    idProgramme INTEGER,
    tempsPause SMALLINT NOT NULL,
    nbSéries SMALLINT NOT NULL,
    ordre SMALLINT NOT NULL,
    CONSTRAINT PK_Programme_Exercice PRIMARY KEY (idExercice, idProgramme)
);

DROP TABLE IF EXISTS Exercice_Lieu CASCADE;
CREATE TABLE Exercice_Lieu (
    idExercice INTEGER,
    idLieu INTEGER,
    CONSTRAINT PK_Exercice_Lieu PRIMARY KEY (idExercice, idLieu)
);

/* ---------------------------------------------------------------------------- */
/*                               Création des index                             */
/* ---------------------------------------------------------------------------- */
CREATE INDEX IDX_FK_Exercice_idMatériel ON Exercice(idMatériel ASC);

CREATE INDEX IDX_FK_Programme_idUtilisateur ON Programme(idUtilisateur ASC);

CREATE INDEX IDX_FK_Séance_idProgramme ON Séance(idProgramme ASC);

CREATE INDEX IDX_FK_Programme_idMatériel ON Programme(idUtilisateur ASC);

CREATE INDEX IDX_FK_Série_idExercice ON Série(idExercice ASC);

CREATE INDEX IDX_FK_Série_idSéance ON Série(idSéance ASC);

/* ---------------------------------------------------------------------------- */
/*                               Création des contraintes                       */
/* ---------------------------------------------------------------------------- */

/* Clés étrangères */
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
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Série
    ADD CONSTRAINT FK_Série_idSéance
        FOREIGN KEY (idSéance)
            REFERENCES Séance (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Série
    ADD CONSTRAINT FK_Série_idExercice
        FOREIGN KEY (idExercice)
            REFERENCES Exercice (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Matériel_GroupementMusculaire
    ADD CONSTRAINT FK_Matériel_GroupementMusculaire_idMatériel
        FOREIGN KEY (idMatériel)
            REFERENCES Matériel (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Matériel_GroupementMusculaire
    ADD CONSTRAINT FK_Matériel_GroupementMusculaire_idGroupementMusculaire
        FOREIGN KEY (idGroupementMusculaire)
            REFERENCES GroupementMusculaire (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Exercice_GroupementMusculaire
    ADD CONSTRAINT FK_Exercice_GroupementMusculaire_idMatériel
        FOREIGN KEY (idExercice)
            REFERENCES Exercice (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Exercice_GroupementMusculaire
    ADD CONSTRAINT FK_Exercice_GroupementMusculaire_idGroupementMusculaire
        FOREIGN KEY (idGroupementMusculaire)
            REFERENCES GroupementMusculaire (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Programme_Exercice
    ADD CONSTRAINT FK_Programme_Exercice_idExercice
        FOREIGN KEY (idExercice)
            REFERENCES Exercice (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Programme_Exercice
    ADD CONSTRAINT FK_Programme_Exercice_idProgramme
        FOREIGN KEY (idProgramme)
            REFERENCES Programme (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Exercice_Lieu
    ADD CONSTRAINT FK_Exercice_Lieu_idExercice
        FOREIGN KEY (idExercice)
            REFERENCES Exercice (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE Exercice_Lieu
    ADD CONSTRAINT FK_Exercice_Lieu_idLieu
        FOREIGN KEY (idLieu)
            REFERENCES Lieu (id)
ON DELETE CASCADE
ON UPDATE CASCADE;

/* Unique */
ALTER TABLE GroupementMusculaire
    ADD CONSTRAINT UC_GroupementMusculaire_nom
        UNIQUE (nom);

ALTER TABLE Exercice
    ADD CONSTRAINT UC_Exercice_nom
        UNIQUE (nom);

ALTER TABLE Lieu
    ADD CONSTRAINT UC_Lieu_nom
        UNIQUE (nom);

ALTER TABLE Utilisateur
    ADD CONSTRAINT UC_Utilisateur_pseudonyme
        UNIQUE (pseudonyme);

-- TODO: Que faire de cette UC...
-- ALTER TABLE Programme_Exercice
--     ADD CONSTRAINT UC_Programme_Exercice_idProgramme_ordre
--         UNIQUE (idProgramme, ordre);

/* Checks triviaux */
ALTER TABLE Utilisateur 
    ADD CONSTRAINT CK_Utilisateur_dateNaissance
        CHECK (dateNaissance < CURRENT_DATE);

ALTER TABLE Exercice 
    ADD CONSTRAINT CK_Exerice_nbSériesConseillé
        CHECK (nbSériesConseillé > 0),

    ADD CONSTRAINT CK_Exercice_nbRépétitionsConseillé
        CHECK (nbRépétitionsConseillé > 0),
        
    ADD CONSTRAINT CK_Exercice_tempsExécutionConseillé
        CHECK (tempsExécutionConseillé > 0);

ALTER TABLE Séance
    ADD CONSTRAINT CK_Séance_dateDébut_dateFin
        CHECK (dateDébut < dateFin);

ALTER TABLE Série 
    ADD CONSTRAINT CK_Série_nbRépétitions
        CHECK (nbRépétitions > 0),

    ADD CONSTRAINT CK_Série_tempsExécution
        CHECK (tempsExécution > 0),

    ADD CONSTRAINT CK_Série_poids
        CHECK (poids > 0);

ALTER TABLE Programme_Exercice 
    ADD CONSTRAINT CK_Programme_Exercice_tempsPause
        CHECK (tempsPause > 0),
        
    ADD CONSTRAINT CK_Programme_Exercice_nbSéries
        CHECK (nbSéries > 0),

    ADD CONSTRAINT CK_Programme_Exercice_ordre
        CHECK (ordre > 0);


/* Autres */
ALTER TABLE Exercice 
    ADD CONSTRAINT CK_Exerice_nbRépétitionsConseillé_tempsExécutionConseillé
        CHECK 
        (
            ( CASE WHEN nbRépétitionsConseillé IS NULL THEN 0 ELSE 1 END
            + CASE WHEN tempsExécutionConseillé IS NULL THEN 0 ELSE 1 END
            ) = 1
        );

ALTER TABLE Série 
    ADD CONSTRAINT CK_Série_nbRépétitions_tempsExécution
        CHECK 
        (
            ( CASE WHEN nbRépétitions IS NULL THEN 0 ELSE 1 END
            + CASE WHEN tempsExécution IS NULL THEN 0 ELSE 1 END
            ) = 1
        );
