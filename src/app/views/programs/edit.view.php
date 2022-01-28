<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Formulaire permettant de modifier les réglages des exercices ajoutés au programme
 */
?>

<main>
    <div class="mt-6 container mx-auto px-4">
        <h2 class="text-lg font-semibold">Modification du programme
            <span class="font-bold italic"><?= $program[0]['nomprogramme'] ?></span>
        </h2>

        <form class="mt-4 w-full" method="POST" action="/programs/update">
            <div class="flex flex-wrap -mx-8 -mt-6">
                <?php
                $i = 0;
                foreach ($program as $exercice) : ?>
                    <div class="mt-6 w-full sm:w-1/2 lg:w-1/3 px-8">
                        <h3 class="font-semibold">Exercice <span class="font-bold italic"> <?= $exercice['nomexercice'] ?></span></h3>
                        <input hidden class="hidden" type="number" name="idexercice[]" value="<?= $exercice['idexercice'] ?>">
                        <input hidden class="hidden" type="number" name="idprogramme[]" value="<?= $exercice['idprogramme'] ?>">
                        <label class="mt-1 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Nombre de séries
                        </label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" type="number" name="nbséries[]" value="<?= $exercice['nbséries'] ?>">
                        <label class="mt-1 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Temps de pause (en secondes)
                        </label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" type="number" name="tempspause[]" value="<?= $exercice['tempspause'] ?>">
                        <label class="mt-1 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                            Ordre
                        </label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" type="number" name="ordre[]" value="<?= $i + 1 ?>">
                    </div>

                <?php $i++;
                endforeach; ?>
            </div>

            <div class="mt-4 leading-tight">
                <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Finaliser le programme
                </button>
            </div>

            <?php if (!empty($errors)) : ?>
                <?php include('/app/views/partials/errors.php'); ?>
            <?php endif; ?>

        </form>

        <div class="mt-6 text-right">
            <a href="/" class="text-blue-700 hover:text-blue-500">Retour à la page d'accueil</a>
        </div>
    </div>
</main>