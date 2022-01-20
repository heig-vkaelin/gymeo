<main>
    <div class="mt-6 container px-4">
        <div>
            <p class="font-semibold">Filtres:</p>
            <form action="/exercices" method="GET" class="flex items-center">
                <label class="text-sm font-medium text-gray-700" for="location">Lieu</label>
                <select class="ml-2 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" id="location" name="location">
                    <option value="-1">-- Non selectionné</option>
                    <?php foreach ($locations as $location) : ?>
                        <option <?= $_GET['location'] == $location['id'] ? 'selected' : '' ?> value="<?= $location['id'] ?>">
                            <?= $location['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label class="ml-10 text-sm font-medium text-gray-700" for="material">Matériel</label>
                <select class="ml-2 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" id="material" name="material">
                    <option value="-1">-- Non selectionné</option>
                    <option <?= $_GET['material'] == 'true' ? 'selected' : '' ?> value="true">
                        Besoin de matériel
                    </option>
                    <option <?= $_GET['material'] == 'false' ? 'selected' : '' ?> value="false">
                        Aucun matériel nécessaire
                    </option>
                </select>
                <label class="ml-10 text-sm font-medium text-gray-700" for="muscle">Groupement Musculaire</label>
                <select class="ml-2 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" id="muscle" name="muscle">
                    <option value="-1">-- Non selectionné</option>
                    <?php foreach ($muscles as $muscle) : ?>
                        <option <?= $_GET['muscle'] == $muscle['id'] ? 'selected' : '' ?> value=" <?= $muscle['id'] ?>">
                            <?= $muscle['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="ml-4 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white text-sm font-bold py-2 px-4 rounded" type="submit">
                    Filtrer
                </button>
            </form>
        </div>
        <h2 class="mt-4 text-lg font-semibold">Liste des exercices</h2>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold text-left">
                    <th class="px-4 py-2 bg-gray-800 text-white">Exercice</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Difficulté</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Matériel</th>
                    <!-- <th class="px-4 py-2 bg-gray-800 text-white">Date de Naissance</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($exercices as $exercice) : ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-2 truncate max-w-sm">
                            <a href="exercice?id=<?= $exercice['id'] ?>" class="border-b-2 border-transparent hover:border-gray-800">
                                <?= $exercice['nom'] ?>
                            </a>
                        </td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $exercice['difficulté'] ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $exercice['idmatériel'] ? $exercice['matériel'] : 'Aucun' ?></td>
                    </tr>
                <?php $i++;
                endforeach; ?>
                <?php if (count($exercices) == 0) : ?>
                    <tr>
                        <td class="px-4 py-2" colspan="3">Aucun exercice ne correspond à la recherche.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>