<main>
    <div class="mt-6 container px-4 mx-auto">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">Vos programmes</h2>
            <a href="/programs/create" class="flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded">
                Créer un programme
            </a>
        </div>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Nom</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Nombre d'exercices</th>
                    <!-- <th class="px-4 py-2 bg-gray-800 text-white">Date de Naissance</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($programs as $program) : ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <!-- <td class="px-4 py-2"> <?= $user['id'] ?></td> -->
                        <td class="px-4 py-2 truncate max-w-sm"><?= $program['nom'] ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= 0 ?></td>
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