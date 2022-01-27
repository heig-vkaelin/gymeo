<main>
    <div class="mt-6 container mx-auto px-4">
        <div class="">
            <h2 class="text-lg font-semibold">
                Détails du programme: <span class="font-bold italic"><?= $program[0]['nomprogramme'] ?></span>
            </h2>

            <h3 class="mt-4 text-base font-semibold">Exercices du programme</h3>
            <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
                <thead>
                    <tr class="font-semibold">
                        <th class="px-4 py-2 bg-gray-800 text-white">Ordre</th>
                        <th class="px-4 py-2 bg-gray-800 text-white">Exercice</th>
                        <th class="px-4 py-2 bg-gray-800 text-white">Temps de pause</th>
                        <th class="px-4 py-2 bg-gray-800 text-white">Nombre de séries</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($program as $exercice) : ?>
                        <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                            <td class="px-4 py-2">
                                <?= $exercice['ordre'] ?>
                            </td>
                            <td class="px-4 py-2">
                                <?= $exercice['nomexercice'] ?>
                            </td>
                            <td class="px-4 py-2">
                                <?= $exercice['tempspause'] ?> secondes
                            </td>
                            <td class="px-4 py-2">
                                <?= $exercice['nbséries'] ?>
                            </td>
                        </tr>
                    <?php $i++;
                    endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</main>