<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Affiche la liste des séances d'un utilisateur
 */
?>

<main>
    <div class="mt-6 container px-4 mx-auto">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Vos Séances</h2>
        </div>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Programme utilisé</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Date de début</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Heure de début</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Date de fin</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Heure de fin</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($sessions as $session) :
                    $dateB = date('Y-m-d', strtotime($session['datedébut']));
                    $timeB = date('H:i', strtotime($session['datedébut']));
                    $dateE = null;
                    $timeE = null;

                    if (!is_null($session['datefin'])) {
                        $dateE = date('Y-m-d', strtotime($session['datefin']));
                        $timeE = date('H:i', strtotime($session['datefin']));
                    }
                ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-3 truncate max-w-sm">
                            <a href="program?id=<?= $session['idprogramme'] ?>" class="border-b-2 border-transparent hover:border-gray-800">
                                <?= $session['nom'] ?>
                            </a>
                        </td>
                        <td class="px-4 py-3 truncate max-w-sm"><?= $dateB ?></td>
                        <td class="px-4 py-3 truncate max-w-sm"><?= $timeB ?></td>
                        <td class="px-4 py-3 truncate max-w-sm"><?= $dateE == NULL ? ' - ' : $dateE ?></td>
                        <td class="px-4 py-3 truncate max-w-sm"><?= $timeE == NULL ? ' - ' : $timeE ?></td>
                        <td class="px-4 py-3 truncate max-w-sm">
                            <?php if ($timeE == NULL) : ?>
                                <a href="series/create?id=<?= $session['id'] ?>" class="flex-shrink-0 shadow bg-indigo-500 hover:bg-indigo-600 focus:outline-none text-white text-sm py-2 px-4 rounded">
                                    Continuer
                                </a>
                            <?php else : ?>
                                <a href="session?id=<?= $session['id'] ?>" class="flex-shrink-0 shadow bg-indigo-500 hover:bg-indigo-600 focus:outline-none text-white text-sm py-2 px-4 rounded">
                                    Voir détails
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
    </div>
</main>