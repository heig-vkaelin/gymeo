/* ---------------------------------------------------------------------------- */
/*  Insertion de séries utilisant des exercices non-présents dans le programme  */
/* ---------------------------------------------------------------------------- */

CREATE OR REPLACE
FUNCTION function_exercice_dans_programme() 
    RETURNS TRIGGER AS 
$$ 
BEGIN
	IF(NEW.idExercice NOT IN (
		SELECT DISTINCT
			Programme_Exercice.idExercice
		FROM
			Séance
		INNER JOIN
      Programme_Exercice
    ON
			Séance.idProgramme = Programme_Exercice.idProgramme
		WHERE
			Séance.id = NEW.idSéance)) THEN
			RAISE EXCEPTION 'Une série ne doit être liée qu''à un exercice présent dans le programme utilisé.'
			USING HINT = 'Essayez de changer l''exercice.';
	ELSE
		RETURN NEW;
	END IF;
END;

$$ LANGUAGE plpgsql; 
 
CREATE OR REPLACE TRIGGER vérification_exercice_dans_programme
  BEFORE INSERT
	ON Série FOR EACH ROW 
  EXECUTE FUNCTION function_exercice_dans_programme(); 


/* --------------------------------------------------------------------------------- */
/*  Une série doit contenir le même attribut que l'exercice auquel elle se rattache  */
/*  (soit nbRépétitions soit tempsExécution).                                        */
/* --------------------------------------------------------------------------------- */

CREATE OR REPLACE
FUNCTION function_champ_série_cohérent_exercice() 
    RETURNS TRIGGER AS 
$$
DECLARE
    modèleExercice Exercice%ROWTYPE;
BEGIN
  SELECT 
    *
  INTO
    modèleExercice
  FROM
    Exercice
  WHERE
    id = NEW.idExercice;

	IF ((NEW.nbRépétitions IS NULL AND modèleExercice.nbRépétitionsConseillé IS NOT NULL) OR
    (NEW.tempsExécution IS NULL AND modèleExercice.tempsExécutionConseillé IS NOT NULL)) THEN
			RAISE EXCEPTION 'Une série doit contenir le même attribut de performance que l''exercice auquel elle se rattache.'
			USING HINT = 'Soit un nombre de répétitions, soit un temps d''exécution';
	ELSE
		RETURN NEW;
	END IF;
END;

$$ LANGUAGE plpgsql; 
 
CREATE OR REPLACE TRIGGER vérification_champ_série
  BEFORE INSERT
  ON Série FOR EACH ROW 
  EXECUTE FUNCTION function_champ_série_cohérent_exercice();


/* -------------------------------------------------------------------------------------- */
/*  Une fois la séance terminée, il est impossible d’y ajouter une série supplémentaire.  */
/* -------------------------------------------------------------------------------------- */

CREATE OR REPLACE
FUNCTION function_vérification_fin_séance() 
    RETURNS TRIGGER AS 
$$ 
BEGIN
	IF (NEW.idSéance IN (
		SELECT 
			Séance.id
		FROM
			Séance
		WHERE
			Séance.id = NEW.idSéance
			AND Séance.dateFin IS NOT NULL)) THEN
			RAISE EXCEPTION 'La séance à laquelle la série est ajoutée est déjà finie';
	ELSE
		RETURN NEW;
	END IF;
END;

$$ LANGUAGE plpgsql; 
 
CREATE OR REPLACE TRIGGER avant_insertion_série_non_terminée
  BEFORE INSERT
	ON Série 
  FOR EACH ROW 
  EXECUTE FUNCTION function_vérification_fin_séance(); 
