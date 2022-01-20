<main>
<div class="mt-6 container px-4">
<div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Séries effectuées</h2>
            <a href="/programs/create" class="flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded">
                Créer une séance
            </a>
        </div>
    <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
        <thead>
            <tr class="font-semibold">
                <th class="px-4 py-2 bg-gray-800 text-white">Exercice</th>
                <th class="px-4 py-2 bg-gray-800 text-white">Répétitions/Temps</th>
                <th class="px-4 py-2 bg-gray-800 text-white">Charge</th>
                <!-- <th class="px-4 py-2 bg-gray-800 text-white">Date de Naissance</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($series as $serie) :
            ?>
                <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                    <td class="px-4 py-2 truncate max-w-sm"><?= $serie['nomexercice'] ?></td>
                    <td class="px-4 py-2 truncate max-w-sm">
                        <?= $serie['nbrépétitions'] == NULL ? $serie['tempsexécution'] . ' minutes' : $serie['nbrépétitions'] . ' répétitions' ?>
                    </td>
                    <td class="px-4 py-2 truncate max-w-sm"><?= $serie['poids']  == NULL ? '-' : $serie['poids'] . ' kg' ?></td>
                </tr>
            <?php $i++;
            endforeach; ?>
        </tbody>
    </table>
</div>
</main>