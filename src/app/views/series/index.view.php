<main>
    <div class="mt-6 container px-4 mx-auto">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Historique des séries par exercice</h2>
        </div>
        <div class="mt-6 space-y-6">
            <?php
            $i = 0;
            foreach (array_keys($series) as $serie) :
            ?>
                <div>
                    <h3 class="text-base font-semibold"><?= $serie ?></h3>
                    <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
                        <thead>
                            <tr class="font-semibold">
                                <th class="px-4 py-2 bg-gray-800 text-white">Répétitions/Temps</th>
                                <th class="px-4 py-2 bg-gray-800 text-white">Charge</th>
                                <th class="px-4 py-2 bg-gray-800 text-white">Date de début</th>
                                <th class="px-4 py-2 bg-gray-800 text-white">Date de fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $x = 0;
                            foreach ($series[$serie] as $ser) :
                                $dateB = date('Y-m-d', strtotime($ser['datedébut']));

                                $dateE = null;

                                if (!is_null($ser['datefin'])) {
                                    $dateE = date('Y-m-d', strtotime($ser['datefin']));
                                }
                            ?>
                                <tr class="<?= $x % 2 == 0 ? 'bg-gray-100' : '' ?>">
                                    <td class="px-4 py-2 truncate max-w-sm">
                                        <?= $ser['nbrépétitions'] == NULL ? $ser['tempsexécution'] . ' secondes' : $ser['nbrépétitions'] . ' répétitions'  ?>
                                    </td>
                                    <td class="px-4 py-2 truncate max-w-sm">
                                        <?= $ser['poids']  == NULL ? '-' : $ser['poids'] . ' kg' ?>
                                    </td>
                                    <td class="px-4 py-2 truncate max-w-sm"><?= $dateB ?></td>
                                    <td class="px-4 py-2 truncate max-w-sm"><?= $dateE == NULL ? ' - ' : $dateE ?></td>
                                </tr>
                            <?php $x++;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php $i++;
            endforeach; ?>
        </div>
    </div>
</main>