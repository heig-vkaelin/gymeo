<main>
    <div class="mt-6 container px-4">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Suivi des séries</h2>
            <form action="/series" method="POST" class="flex">
                <button class="ml-4 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white text-sm font-bold py-2 px-4 rounded" type="submit">
                    Finaliser la séance
                </button>
            </form>
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

                    ?>
                </tbody>
            </table>
        <?php $i++;
        endforeach; ?>
        <?php if (count($series) == 0) : ?>
            <h2 class="text-lg font-semibold">Aucune série n'as encore été effectuée</h2>

        <?php endif; ?>
        <form action="/series" method="POST">
            <label class="text-sm font-medium text-gray-700" for="exercice">Exercice</label>
            <select class="ml-2 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" id="exercice" name="exercice">
                <option value="-1">-- Non selectionné</option>
                <?php foreach ($exercices as $exercice) : ?>
                    <option <?= $exercice['id'] ?> value="<?= $exercice['id'] ?>">
                        <?= $exercice['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="repetition">
                    repetitions
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="repetition" type="number" name="repetition" placeholder="Full body">
            </div>
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                    temps
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="time" type="number" name="time" placeholder="Full body">
            </div>
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="weight">
                    Poids
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="weight" type="number" name="weight" placeholder="Full body">
            </div>
            <input hidden name="idSession" value="<?= $_GET['idSession'] ?>">

            <button class="ml-4 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white text-sm font-bold py-2 px-4 rounded" type="submit">
                Série terminée
            </button>
        </form>
    </div>
</main>