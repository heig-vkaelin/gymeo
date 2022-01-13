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

/* Exercice */
INSERT INTO Exercice (nom, description, nbSériesConseillé, nbRépétitionsConseillé, tempsExécutionConseillé, difficulté, idMatériel) VALUES
('Dumbell alternate hammer curl', 'Consiste à soulever des haltères en alternant bras gauche/droit. Effectuez cette exercice debout et droit.', 3, 12, null, 'Facile', 1),
('Fly', 'Ecartez les bras afi d''atteindre un angle de 180° entre vos bras et votre torse.', 4, 10, null, 'Moyen', 2),
('Barbell press', 'Levez les bras au maximum, puis descendez jusqu''à que vos coudes atteignent votre torse.', 2, 15, null, 'Facile', 3),
('Back fortification', '', 4, 8, null, 'Difficile', 3),
('Sprint', 'Effectuez des séquences de sprints de 15 secondes alternées par 15 secondes de marche', 3, null, 5, 'Difficile', 4),
('Abdominaux au sol', '', 3, 10, null, 'Facile', null);

/* Groupement musculaire */


-- TODO