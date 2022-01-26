<main>
    <div class="mt-6 container px-4 mx-auto">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Suivi des séries</h2>
            <form action="/sessions/end" method="POST" class="flex items-center">
                <span class="hidden md:inline text-indigo-600">
                    <span class="font-semibold italic">Cliquez ici pour finir votre séance de sport !</span>
                    <i class="ml-2 fas fa-arrow-right"></i>
                </span>
                <input hidden name="idSession" value="<?= $_GET['id'] ?>">
                <button class="ml-4 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white text-base font-bold py-2 px-4 rounded" type="submit">
                    Finaliser la séance
                </button>
            </form>
        </div>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Exercice</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Répétitions/Temps</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Poids</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Temps de pause</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tbody>
                <?php
                $i = 0;
                foreach ($session as $serie) : ?>
                    <?php if (!isset($serie['nomexercice'])) break; ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-2">
                            <?= $serie['nomexercice'] ?>
                        </td>
                        <td class="px-4 py-2">
                            <?= $serie['nbrépétitions'] == NULL ? $serie['tempsexécution'] . ' secondes' : $serie['nbrépétitions'] . ' répétitions' ?>
                        </td>
                        <td class="px-4 py-2">
                            <?= $serie['poids']  == NULL ? '-' : $serie['poids'] . ' kg' ?>
                        </td>
                        <td class="px-4 py-2">
                            <?= $serie['tempspause'] . ' secondes' ?>
                        </td>
                    </tr>
                <?php $i++;
                endforeach; ?>
                <tr>
                    <?php if (count($session) <= 1 && !isset($session[0]['nomexercice'])) : ?>
                        <td class="px-4 py-2" colspan="4">Aucune série n'as encore été effectuée</td>
                    <?php endif; ?>
                </tr>
            </tbody>
        </table>

        <h2 class="mt-8 text-lg font-semibold">Ajouter une série</h2>
        <form action="/series" method="POST" class="max-w-md">
            <label class="mt-2 block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="exercice">Exercice</label>
            <select class="pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" id="exercice" name="exercice">
                <?php foreach ($exercices as $exercice) : ?>
                    <option <?= $exercice['id'] ?> value="<?= $exercice['id'] ?>">
                        <?= $exercice['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="mt-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="timeRep">
                    Nombre de Répétitions ou temps en secondes
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="timeRep" type="number" name="timeRep" placeholder="12">
            </div>
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="weight">
                    Poids [kg]
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="weight" type="number" name="weight" placeholder="Non obligatoire">
            </div>
            <input hidden name="idSession" value="<?= $_GET['id'] ?>">

            <button class="mt-2 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white text-sm font-bold py-2 px-4 rounded" type="submit">
                Série terminée
            </button>
        </form>
    </div>
</main>