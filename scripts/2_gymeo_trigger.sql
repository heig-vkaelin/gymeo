/* ---------------------------------------------------------------------------- */
/*  Insertion de séries utilisant des exercices non-présents dans le programme  */
/* ---------------------------------------------------------------------------- */

CREATE OR REPLACE
FUNCTION vérification_exercice_série() 
    RETURNS TRIGGER AS 
$$ 
BEGIN
	IF(NEW.idexercice NOT IN (
		SELECT DISTINCT
			programme_exercice.idexercice
		FROM
			séance
			INNER JOIN programme_exercice ON
			séance.idprogramme = programme_exercice.idprogramme
		WHERE
			séance.id = NEW.idséance)) THEN
			RAISE EXCEPTION 'Une série ne doit être liée qu''à un exercice présent dans le programme utilisé.'
			USING HINT = 'Essayez de changer l''exercice.';
	ELSE
		RETURN NEW;
	END IF;
END;

$$ LANGUAGE plpgsql; 
 
CREATE OR REPLACE TRIGGER avant_insertion_série
    BEFORE
INSERT
	ON
	série 
    FOR EACH ROW 
EXECUTE FUNCTION vérification_exercice_série(); 