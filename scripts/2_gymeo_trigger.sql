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
			INNER JOIN Programme_Exercice ON
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
    BEFORE
INSERT
	ON
	Série 
    FOR EACH ROW 
EXECUTE FUNCTION function_exercice_dans_programme(); 