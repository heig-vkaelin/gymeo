<main>
    <div class="mt-6 container px-4">
        <h2 class="text-lg font-semibold">Liste des utilisateurs</h2>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Id</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Pseudonyme</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Date de Naissance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($users as $user) : ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-2"> <?= $user['id'] ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $user['pseudonyme'] ?></td>
                        <td class="px-4 py-2 truncate max-w-sm"><?= $user['datenaissance'] ?></td>
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