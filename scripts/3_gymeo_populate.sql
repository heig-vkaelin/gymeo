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
('Hard work', 1),
('NO PAIN NO GAIN', 3),
('Budget plan', 2),
('Only left side', 3);

/* Matériel */
INSERT INTO Matériel (nom, description) VALUES
('Haltère', 'Idéal pour travailler les bras'),
('Machine butterfly', 'Efficace pour les pectoraux. Changez la distance du siège en fonction de votre taille'),
('Machine dos et épaules', ''),
('Barre de musculation', 'Le couteau suisse du fitness'),
('Tapis roulant', 'Variez la vitesse en fonction du temps de la séance'),
('Elastics', 'Idéal pour travailler les bras et les pecs.'),
('Machine de développé couché', 'Précautions avec la machine'),
('Neck builder', 'Cible uniquement la nuque'),
('Fit-Ball', ''),
('Gilet de poids', '');

/* Groupement musculaire */
INSERT INTO GroupementMusculaire (nom) VALUES
('Ceinture scapulaire'),
('Membres supérieurs'),
('Membres inférieurs'),
('Paroi abdominale'),
('Paroi dorsale'),
('Bras'),
('Poitrines'),
('Full body');

/* Matériel - Groupement musculaire */
INSERT INTO Matériel_GroupementMusculaire (idMatériel, idGroupementMusculaire) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(4, 3),
(4, 5),
(4, 7),
(6, 1),
(6, 6),
(6, 7),
(7, 1),
(7, 4),
(7, 6),
(7, 7),
(8, 2),
(9, 8),
(9, 3),
(9, 4),
(10, 4),
(10, 8);

/* Exercice */
INSERT INTO Exercice (nom, description, nbSériesConseillé, nbRépétitionsConseillé, tempsExécutionConseillé, difficulté, idMatériel) VALUES
('Dumbell alternate hammer curl', 'Consiste à soulever des haltères en alternant bras gauche/droit. Effectuez cet exercice debout et droit.', 3, 12, null, 'Facile', 1),
('Fly', 'Ecartez les bras afin d''atteindre un angle de 180° entre vos bras et votre torse.', 4, 10, null, 'Moyen', 2),
('Barbell press', 'Levez les bras au maximum, puis descendez jusqu''à ce que vos coudes atteignent votre torse.', 2, 15, null, 'Facile', 3),
('Back fortification', '', 4, 8, null, 'Difficile', 3),
('Sprint', 'Effectuez des séquences de sprints de 15 secondes alternées par 15 secondes de marche', 3, null, 5, 'Difficile', null),
('Abdominaux au sol', '', 3, 10, null, 'Facile', null),
('EZ bar curl', '', 2, 20, null, 'Difficile', 4),
('Prone leg press', 'Effectuez le mouvement de son amplitude et redescendez lentement', 3, 12, null, 'Difficile', 7),
('Dumbell Lunges', 'Evitez les poids trop lourds lors des premières séances', 3, 20, null, 'Facile', 1),
('Course d''endurance', 'Il faut courir', 1, null, 35, 'Facile', 5),
('Pompes diamant', 'Gardez une distance de 10cm entre vos mains', 3, 8, null, 'Difficile', null),
('Pull ups', 'Ecartez plus ou moins vos mains sur la barre pour muscler plus le dos.', 3, 10, null, 'Moyen', 3),
('Gainage', 'Restez droit', 2, null, 1, 'Moyen', null),
('Barbell romanian deadlift', 'Exercice légendaire permettant de rentrer dans le panthéon de l''élite', 5, 20, null, 'Difficile', 4),
('Dips', '', 3, null, 1, 'Difficile', 10),
('Yoga', 'Respirez régulièrement', 3, 10, null, 'Facile', 9),
('Traction supination', '', 3, 10, null, 'Moyen', 4),
('Tractions pronation', '', 3, 10, null, 'Moyen', 4)
;

/* Exercice - Groupement musculaire */
INSERT INTO Exercice_GroupementMusculaire (idExercice, idGroupementMusculaire) VALUES
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 5),
(5, 3),
(6, 4),
(7, 1),
(7, 2),
(7, 6),
(8, 3),
(9, 3),
(10, 8),
(11, 1),
(11, 2),
(11, 4),
(11, 6),
(11, 7),
(12, 7),
(12, 5),
(13, 4),
(13, 5),
(14, 1),
(14, 2),
(14, 6),
(14, 5),
(15, 4),
(15, 6),
(15, 8),
(16, 8)
;

/* Programme - Exercice*/
INSERT INTO Programme_Exercice (idExercice, idProgramme, tempsPause, nbSéries, ordre) VALUES
(1, 1, 30, 5, 1),
(5, 1, 60, 3, 2),

(4, 2, 30, 5, 1),
(6, 2, 60, 3, 2),
(7, 2, 33, 5, 3),
(3, 2, 22, 3, 4),
(2, 2, 30, 5, 5),
(9, 2, 60, 3, 6),
(15, 2, 1, 20, 7),
(13, 2, 10, 3, 8),

(7, 3, 20, 5, 1),
(2, 3, 160, 5, 2),
(9, 3, 27, 5, 3),
(11, 3, 130, 17, 4),
(5, 3, 30, 2, 5),
(8, 3, 45, 1, 6),
(1, 3, 5, 10, 7),
(4, 3, 100, 2, 8),

(7, 4, 20, 5, 1),
(6, 4, 10, 5, 2),
(2, 4, 20, 4, 3),
(11, 4, 10, 2, 4),

(3, 6, 20, 5, 1),
(2, 6, 160, 5, 2),
(1, 6, 27, 5, 3),
(6, 6, 130, 17, 4),
(5, 6, 30, 2, 5),
(4, 6, 45, 1, 6),
(9, 6, 10, 10, 7),
(8, 6, 100, 2, 8),
(7, 6, 20, 5, 9),
(12, 6, 160, 5, 10),
(11, 6, 27, 5, 11),
(10, 6, 130, 17, 12),
(15, 6, 30, 2, 13),
(14, 6, 45, 1, 14),
(13, 6, 100, 10, 15),
(10, 7, 20, 10, 15);

/* Séance - pas encore terminées */
INSERT INTO Séance (dateDébut, idProgramme) VALUES
('2020-05-14 17:30',  1),
('2020-03-14 12:15',  1),
('2020-03-14 18:30',  2),
('2008-05-14 23:30',  2),
('2015-07-14 12:15',  2),
('2020-05-17 17:30',  2),
('2019-03-14 18:30',  2)/*,
('2019-05-14 23:30', '2019-05-15 00:30', 2),
('2019-07-14 12:15', '2019-07-14 14:00', 2),
('2019-05-17 17:30', '2019-05-17 19:30', 2),
('2019-03-10 12:15', '2019-03-10 14:00', 3),
('2020-05-14 17:30', '2020-05-14 18:30', 3),
('2020-03-14 12:15', '2020-03-14 14:00', 4),
('2020-03-14 18:30', '2020-03-14 20:15', 4),
('2020-05-14 23:30', '2020-05-15 00:30', 4),
('2015-07-14 12:15', '2020-07-14 14:00', 4),
('2020-05-17 17:30', '2020-05-17 19:30', 5),
('2019-03-10 12:15', '2019-03-10 14:00', 5),
('2020-05-17 17:30', '2020-05-17 19:30', 6),
('2019-03-10 16:15', '2019-03-10 17:00', 7)*/
;

/* Série */
INSERT INTO Série (nbrépétitions, tempsexécution, poids, idSéance, idExercice) VALUES
(5, null, 20, 1, 1),
(10, null, 15, 1, 1),
(null, 30, null, 1, 5),

(28, null, 45, 3, 4),
(20, null, 45, 3, 4),
(15, null, 45, 3, 4),
(30, null, null, 3, 6),

(28, null, 45, 4, 4),
(20, null, 45, 4, 4),
(15, null, 45, 4, 4),
(30, null, null, 4, 6),
(28, null, 45, 4, 2),
(20, null, 45, 4, 2),
(15, null, 45, 4, 3),
(30, null, 20, 4, 3),
(28, null, 45, 4, 3),
(20, null, 45, 4, 4),
(15, null, 45, 4, 4),
(30, null, null, 4, 6),
(30, null, 20, 4, 9),
(28, null, 45, 4, 9),
(20, null, null, 4, 13),
(15, null, null, 4, 13),
(30, null, null, 4, 13),
(30, null, null, 4, 13),
(28, null, 45, 4, 15),
(20, null, 45, 4, 15),
(15, null, 45, 4, 15),
(30, null, 30, 4, 15)
;

/* Séance - Fin de la création */
UPDATE Séance SET dateFin = '2020-05-14 18:30' WHERE Séance.id = 1;
UPDATE Séance SET dateFin = '2020-03-14 14:00' WHERE Séance.id = 2;
UPDATE Séance SET dateFin = '2020-03-14 20:15' WHERE Séance.id = 3;
UPDATE Séance SET dateFin = '2008-05-15 00:30' WHERE Séance.id = 4;
UPDATE Séance SET dateFin = '2020-07-14 14:00' WHERE Séance.id = 5;
UPDATE Séance SET dateFin = '2020-05-17 19:30' WHERE Séance.id = 6;
UPDATE Séance SET dateFin = '2019-03-14 20:15' WHERE Séance.id = 7;

/* Lieu */
INSERT INTO Lieu (nom) VALUES
('Maison'),
('Extérieur'),
('Salle de fitness');

/* Exercice_Lieu */
INSERT INTO Exercice_Lieu (idExercice, nomLieu) VALUES
(1, 'Maison'),
(1, 'Salle de fitness'),
(2, 'Salle de fitness'),
(3, 'Salle de fitness'),
(4, 'Salle de fitness'),
/* ??? Faire un sprint en ext avec un tapis roulant*/
(5, 'Extérieur'),
(5, 'Maison'),
(5, 'Salle de fitness'),
(6, 'Extérieur'),
(6, 'Maison'),
(7, 'Salle de fitness'),
(8, 'Salle de fitness'),
(9, 'Salle de fitness'),
(10, 'Maison'),
(10, 'Extérieur'),
(10, 'Salle de fitness'),
(11, 'Salle de fitness'),
(11, 'Extérieur'),
(12, 'Salle de fitness'),
(13, 'Salle de fitness'),
(14, 'Salle de fitness'),
(15, 'Salle de fitness'),
(16, 'Maison'),
(16, 'Extérieur')
;
-- TODO
