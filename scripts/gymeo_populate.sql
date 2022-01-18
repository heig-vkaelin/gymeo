set client_encoding to 'UTF8';

/* TMP: RESET ALL */
TRUNCATE Utilisateur, Programme, Matériel, GroupementMusculaire,
Matériel_GroupementMusculaire, Exercice, Exercice_GroupementMusculaire,
Séance, Série, Programme_Exercice, Lieu, Exercice_Lieu
 RESTART IDENTITY;

/* Utilisateur */
INSERT INTO Utilisateur (pseudonyme, dateNaissance) VALUES 
('Valentin', '1997-11-15'),
('Alexandre', '2000-03-19'),
('Loïc', '2000-02-09');

/* Programme */
INSERT INTO Programme (nom, idUtilisateur) VALUES
('full-body', 1),
('Zoumba training', 2),
('Haut du corps', 2),
('Endurance', 3);

/* Matériel */
INSERT INTO Matériel (nom, description) VALUES
('Haltère', 'Idéal pour travailler les bras'),
('Machine butterfly', 'Efficace pour les pectoraux. Changer la distance du siège en fonction de votre taille'),
('Machine dos et épaules', ''),
('Tapis roulant', 'Variez la vitesse en fonction du temps de la séance'),
('Barre de musculation', 'Le couteau suisse du fitness');

/* Groupement musculaire */
INSERT INTO GroupementMusculaire (nom) VALUES
('Ceinture scapulaire'),
('Membres supérieurs'),
('Membres inférieurs'),
('Paroi abdominale'),
('Paroi dorsale');

/* Matériel - Groupement musculaire */
INSERT INTO Matériel_GroupementMusculaire (idMatériel, idGroupementMusculaire) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(4, 3),
(4, 5),
(5, 1);

/* Exercice */
INSERT INTO Exercice (nom, description, nbSériesConseillé, nbRépétitionsConseillé, tempsExécutionConseillé, difficulté, idMatériel) VALUES
('Dumbell alternate hammer curl', 'Consiste à soulever des haltères en alternant bras gauche/droit. Effectuez cette exercice debout et droit.', 3, 12, null, 'Facile', 1),
('Fly', 'Ecartez les bras afi d''atteindre un angle de 180° entre vos bras et votre torse.', 4, 10, null, 'Moyen', 2),
('Barbell press', 'Levez les bras au maximum, puis descendez jusqu''à que vos coudes atteignent votre torse.', 2, 15, null, 'Facile', 3),
('Back fortification', '', 4, 8, null, 'Difficile', 3),
('Sprint', 'Effectuez des séquences de sprints de 15 secondes alternées par 15 secondes de marche', 3, null, 5, 'Difficile', 4),
('Abdominaux au sol', '', 3, 10, null, 'Facile', null);

/* Exercice - Groupement musculaire */
INSERT INTO Exercice_GroupementMusculaire (idExercice, idGroupementMusculaire) VALUES
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 5),
(5, 3),
(6, 4);

/* Séance */
INSERT INTO Séance (dateDébut, dateFin, idProgramme) VALUES
('2020-05-14 17:30', '2020-05-14 18:30', 1),
('2020-03-14 12:15', '2020-03-14 14:00', 1),
('2020-03-14 18:30', '2020-03-14 20:15', 2);

/* Série */
INSERT INTO Série (nbrépétitions, tempsexécution, poids, idSéance, idExercice) VALUES
(5, null, 20, 1, 1),
(10, null, 15, 1, 1),
(null, 30, null, 1, 5),
(28, null, 45, 3, 4),
(20, null, 45, 3, 4),
(15, null, 45, 3, 4),
(30, null, null, 3, 6);

/* Programme - Exercice*/
INSERT INTO Programme_Exercice (idExercice, idProgramme, tempsPause, nbSéries, ordre) VALUES
(1, 1, 30, 5, 1),
(5, 1, 60, 3, 2),
(4, 2, 30, 5, 1),
(6, 2, 60, 3, 2);

/* Lieu */
INSERT INTO Lieu (nom) VALUES
('Maison'),
('Extérieur'),
('Salle de fitness');

/* Exercice_Lieu */
INSERT INTO Exercice_Lieu (idExercice, idLieu) VALUES
(1, 1),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
/* ??? Faire un sprint en ext avec un tapis roulant*/
(5, 2),
(5, 1),
(5, 3),
(6, 2),
(6, 1);
-- TODO