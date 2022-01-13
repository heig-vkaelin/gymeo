<main>
    <div class="mt-6 container px-4">
        <h2 class="text-lg font-semibold">Liste des exercices</h2>
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
                        <!-- <td class="px-4 py-2"> <?= $user['id'] ?></td> -->
                        <td class="px-4 py-2 truncate max-w-sm"><?= $exercice['nom'] ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $exercice['difficulté'] ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $exercice['idmatériel'] ? $exercice['matériel'] : 'Aucun' ?></td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    function deleteTeacher(idTeacher) {
        const confirmation = confirm("Êtes-vous sûr de vouloir supprimer l'enseignant ?");
        if (confirmation) {
            location.href = `teachers/delete?id=${idTeacher}`;
        }
    }
</script>