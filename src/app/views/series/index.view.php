<main>
<div class="mt-6 container px-4">
<div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Suivi des séries</h2>
            <a href="/programs/create" class="flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded">
                Créer une séance
            </a>
</div>
    <?php
            $i = 0;
            foreach (array_keys($series) as $serie) :
    ?>
    <h2 class="text-lg font-semibold"><?= $serie ?></h2>
    <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
        <thead>
            <tr class="font-semibold">
                <th class="px-4 py-2 bg-gray-800 text-white">Répétitions/Temps</th>
                <th class="px-4 py-2 bg-gray-800 text-white">Charge</th>
                <th class="px-4 py-2 bg-gray-800 text-white">Date de début</th>
                <th class="px-4 py-2 bg-gray-800 text-white">Date de fin</th>
                <!-- <th class="px-4 py-2 bg-gray-800 text-white">Date de Naissance</th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                $x = 0;
                foreach ($series[$serie] as $ser) :
                    $dateB = date('Y-m-d',strtotime($ser['datedébut']));
                    $dateE = date('Y-m-d',strtotime($ser['datefin']));
            ?>
                <tr class="<?= $x % 2 == 0 ? 'bg-gray-100' : '' ?>">
                    <td class="px-4 py-2 truncate max-w-sm">
                        <?= $ser['nbrépétitions'] == NULL ? $ser['tempsexécution'] . ' minutes' : $ser['nbrépétitions'] . ' répétitions'  ?>
                    </td>
                    <td class="px-4 py-2 truncate max-w-sm">
                        <?= $ser['poids']  == NULL ? '-' : $ser['poids'] . ' kg' ?>
                    </td>
                    <td class="px-4 py-2 truncate max-w-sm"><?= $dateB ?></td>
                    <td class="px-4 py-2 truncate max-w-sm"><?= $dateE ?></td>
                </tr>
                <?php $x++;
            endforeach; ?>
        </tbody>
    </table>
    <?php $i++;
    endforeach; ?>
</div>
</main>