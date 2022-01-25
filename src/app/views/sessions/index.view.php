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
                    <!-- <th class="px-4 py-2 bg-gray-800 text-white">Date de Naissance</th> -->
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
                        <td class="px-4 py-2 truncate max-w-sm">
                            <a href="series?id=<?= $session['id'] ?>" class="border-b-2 border-transparent hover:border-gray-800">
                                <?= $session['nom'] ?></a>
                        </td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $dateB ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $timeB ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $dateE == NULL ? ' - ' : $dateE ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $timeE == NULL ? ' - ' : $timeE ?></td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
    </div>
</main>