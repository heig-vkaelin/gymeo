<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Affiche les détails d'un exercice
 */
?>

<main>
    <div class="mt-6 container mx-auto px-4">
        <div class="">
            <h2 class="text-lg font-semibold">
                Informations de l'exercice: <span class="font-bold italic"><?= $exercice['nom'] ?></span>
            </h2>
            <div class="mt-2 italic"><?= $exercice['description'] ?></div>
            <div class="mt-6">Nombre de séries recommandé: <?= $exercice['nbsériesconseillé'] ?></div>
            <?php if ($exercice['nbrépétitionsconseillé']) : ?>
                <div>Nombre de répétitions recommandé: <?= $exercice['nbrépétitionsconseillé'] ?></div>
            <?php else : ?>
                <div>Temps d'exécution recommandé: <?= $exercice['tempsexécutionconseillé'] ?> secondes</div>
            <?php endif; ?>
            <div class="mt-2">
                <span>Difficulté: <span class="font-bold"><?= $exercice['difficulté'] ?></span></span>
            </div>
            <div class="mt-2 text-lg font-semibold">Matériel nécessaire:</div>
            <div class="pl-4">
                <?php if ($exercice['idmatériel']) : ?>
                    <span><?= $exercice['nommatériel'] ?>: </span>
                    <span><?= $exercice['descriptionmatériel'] ?></span>
                <?php else : ?>
                    <div>Aucun</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-4 text-lg font-semibold">Lieux idéals pour pratiquer l'exercice:</div>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold text-left">
                    <th class="px-4 py-2 bg-gray-800 text-white">Lieu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $lieux = explode(', ', $exercice['lieux']);
                foreach ($lieux as $lieu) : ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-2"> <?= $lieu ?></td>
                    </tr>
                <?php $i++;
                endforeach;
                ?>
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <a href="/exercices" class="text-blue-700 hover:text-blue-500">Retour aux exercices</a>
        </div>
    </div>
</main>

<script>
    function deleteTeacher(idTeacher) {
        const confirmation = confirm("Êtes-vous sûr de vouloir supprimer l'enseignant ?");
        if (confirmation) {
            location.href = `teachers/delete?id=${idTeacher}`;
        }
    }
</script>