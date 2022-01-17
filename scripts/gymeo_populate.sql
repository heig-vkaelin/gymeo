set client_encoding to 'UTF8';

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
INSERT INTO Matériel_GroupementMusculaire (idMatériel, nomGroupementMusculaire) VALUES
(1, 'Ceinture scapulaire'),
(2, 'Ceinture scapulaire'),
(2, 'Membres supérieurs'),
(3, 'Ceinture scapulaire'),
(4, 'Membres inférieurs'),
(4, 'Paroi abdominale'),
(5, 'Ceinture scapulaire');

/* Exercice */
INSERT INTO Exercice (nom, description, nbSériesConseillé, nbRépétitionsConseillé, tempsExécutionConseillé, difficulté, idMatériel) VALUES
('Dumbell alternate hammer curl', 'Consiste à soulever des haltères en alternant bras gauche/droit. Effectuez cette exercice debout et droit.', 3, 12, null, 'Facile', 1),
('Fly', 'Ecartez les bras afi d''atteindre un angle de 180° entre vos bras et votre torse.', 4, 10, null, 'Moyen', 2),
('Barbell press', 'Levez les bras au maximum, puis descendez jusqu''à que vos coudes atteignent votre torse.', 2, 15, null, 'Facile', 3),
('Back fortification', '', 4, 8, null, 'Difficile', 3),
('Sprint', 'Effectuez des séquences de sprints de 15 secondes alternées par 15 secondes de marche', 3, null, 5, 'Difficile', 4),
('Abdominaux au sol', '', 3, 10, null, 'Facile', null);

/* Exercice - Groupement musculaire */
INSERT INTO Exercice_GroupementMusculaire (nomExercice, nomGroupementMusculaire) VALUES
('Dumbell alternate hammer curl', 'Membres supérieurs'),
('Fly', 'Ceinture scapulaire'),
('Fly', 'Membres supérieurs'),
('Barbell press', 'Ceinture scapulaire'),
('Barbell press', 'Membres supérieurs'),
('Back fortification', 'Paroi dorsale'),
('Sprint', 'Membres inférieurs'),
('Abdominaux au sol', 'Paroi abdominale');

/* Séance */
INSERT INTO Séance (dateDébut, dateFin, idProgramme) VALUES
('2020-05-14','2020-05-15',1),
('2020-03-14','2020-03-15',1),
('2020-03-14','2020-03-15',2);

/* Série */
INSERT INTO Série (nbrépétitions, tempsexécution, poids, idSéance, nomExercice) VALUES
(5, null, 20, 1, 'Dumbell alternate hammer curl'),
(10, null, 15, 1, 'Dumbell alternate hammer curl'),
(null, 30, null, 1, 'Sprint'),
(28, null, 45, 3, 'Back fortification'),
(20, null, 45, 3, 'Back fortification'),
(15, null, 45, 3, 'Back fortification'),
(30, null, null, 3, 'Abdominaux au sol');

/* Programme - Exercice*/
INSERT INTO Programme_Exercice (nomExercice, idProgramme, tempsPause, nbSéries, ordre) VALUES
('Dumbell alternate hammer curl', 1, 30, 5, 1),
('Sprint', 1, 60, 3, 2),
('Back fortification', 2, 30, 5, 1),
('Abdominaux au sol', 2, 60, 3, 2);

/* Lieu */
INSERT INTO Lieu (nom) VALUES
('Maison'),
('Extérieur'),
('Salle de fitness');

/* Exercice_Lieu */
INSERT INTO Exercice_Lieu (nomExercice, nomLieu) VALUES
('Dumbell alternate hammer curl', 'Maison'),
('Dumbell alternate hammer curl', 'Salle de fitness'),
('Fly', 'Salle de fitness'),
('Barbell press', 'Salle de fitness'),
('Back fortification', 'Salle de fitness'),
/* ??? Faire un sprint en ext avec un tapis roulant*/
('Sprint', 'Extérieur'),
('Sprint', 'Maison'),
('Sprint', 'Salle de fitness'),
('Abdominaux au sol', 'Extérieur'),
('Abdominaux au sol', 'Maison');
-- TODO