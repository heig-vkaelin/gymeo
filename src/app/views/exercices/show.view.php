<main>
    <div class="mt-6 container mx-auto px-4">
        <div class="">
            <h2 class="text-lg font-semibold">
                Exercice: <?= $exercice['nom'] ?>
            </h2>
            <div class="">
                <span>Difficulté: <?= $exercice['difficulté'] ?></span>
                <?php switch ($exercice['difficulté']) {
                    case 'Difficile':
                        echo '<i class="fas fa-grin-beam-sweat"></i>';
                        break;
                    case 'Moyen':
                        echo '<i class="fas fa-grin-beam-sweat"></i>';
                        break;
                    case 'Facile':
                        echo '<i class="fas fa-grin-beam-sweat"></i>';
                        break;
                    default:
                        break;
                }
                ?>
            </div>
            <div>Matériel: <?= '' ?></div>
        </div>

        <div class="mt-4 text-lg font-semibold">Lieux:</div>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Lieu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                /*
                $i = 0;
                foreach ($allRows as $row) : ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-2"> <?= $row['nickname'] ?></td>
                        <td class="px-4 py-2"><?= $row['origin'] ?></td>
                    </tr>
                <?php $i++;
                endforeach;
                */ ?>
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <a href="/exercices" class="text-blue-700 hover:text-blue-500">Retour aux exercices</a>
        </div>
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