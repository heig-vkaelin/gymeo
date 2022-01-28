<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Formulaire permettant de créer un nouveau programme
 */
?>

<main>
    <div class="mt-6 container mx-auto px-4">
        <h2 class="text-lg font-semibold">Créer un programme</h2>

        <form class="mt-4 w-full" method="POST" action="/programs">
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="programName">
                    Nom
                </label>
                <input class="max-w-xl appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="programName" type="text" name="programName" placeholder="Full body">
            </div>

            <div class="mt-6">
                <div class="font-semibold">Exercices:</div>
                <div class="text-sm italic">L'ordre des exercices et les autres informations pourront être modifiés par la suite.</div>
                <div class="mt-3 flex flex-wrap">
                    <?php foreach ($exercices as $exercice) : ?>
                        <div class="flex items-center w-full md:w-1/2 lg:w-1/3">
                            <input id="<?= $exercice['id'] ?>" type="checkbox" name="exercices[]" value="<?= $exercice['id'] ?>">
                            <label class="ml-2 checks"><?= $exercice['nom'] ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mt-8 leading-tight">
                <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Créer
                </button>
                <button class="shadow bg-gray-500 hover:bg-gray-600 focus:outline-none text-white font-bold py-2 px-4 rounded" type="reset">
                    Effacer
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