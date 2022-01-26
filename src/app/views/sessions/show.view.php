<main>
    <div class="mt-6 container px-4 mx-auto">
        <?php $startDate = custom_strftime("%A %d %B %G", strtotime($sessions[0]['datedébut'])); ?>
        <h2 class="text-lg font-semibold">Détails de la séance du <span class="ml-1 font-bold italic"><?= $startDate ?></span></h2>
        <h3 class="mt-6 text-base font-semibold">Séries effectuées</h3>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Exercice</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Répétitions/Temps</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Charge</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($sessions as $serie) :
                ?>
                    <?php if ($serie['nomexercice']) : ?>
                        <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                            <td class="px-4 py-2 truncate max-w-sm"><?= $serie['nomexercice'] ?></td>
                            <td class="px-4 py-2 truncate max-w-sm">
                                <?= $serie['nbrépétitions'] == NULL ? $serie['tempsexécution'] . ' minutes' : $serie['nbrépétitions'] . ' répétitions' ?>
                            </td>
                            <td class="px-4 py-2 truncate max-w-sm"><?= $serie['poids']  == NULL ? '-' : $serie['poids'] . ' kg' ?></td>
                        </tr>
                    <? else : ?>
                        <tr>
                            <td class="px-4 py-2" colspan="3">Aucune série réalisée lors de cette séance</td>
                        </tr>
                    <?php endif; ?>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
    </div>
</main>