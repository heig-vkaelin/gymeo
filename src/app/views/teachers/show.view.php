<main>
    <div class="mt-6 container mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">
                Détail: <?= $teacher['teaName'] . ' ' . $teacher['teaFirstname']; ?>
                <span class="ml-2">
                    <?php switch ($teacher['teaGender']) {
                        case 'h':
                            echo '<i class="fas fa-mars"></i>';
                            break;
                        case 'f':
                            echo '<i class="fas fa-venus"></i>';
                            break;
                        default:
                            echo '<i class="fas fa-wheelchair"></i>';
                            break;
                    }
                    ?>
                </span>
            </h2>
            <div>Section(s): <?= $teacher['sections'] ?></div>
            <?php if ($user['role'] === 'Admin') : ?>
                <span>
                    <a href="teachers/edit?id=<?= $teacher['idTeacher'] ?>" class="hover:text-gray-700"><i class="fas fa-pen"></i></a>
                    <button onclick="deleteTeacher(<?= $teacher['idTeacher'] ?>)" class="ml-3 hover:text-gray-700 focus:outline-none"><i class="fas fa-trash"></i></button>
                </span>
            <?php endif; ?>
        </div>

        <div class="mt-4 text-lg font-semibold">Surnoms:</div>
        <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
            <thead>
                <tr class="font-semibold">
                    <th class="px-4 py-2 bg-gray-800 text-white">Surnom</th>
                    <th class="px-4 py-2 bg-gray-800 text-white">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                foreach ($allRows as $row) : ?>
                    <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
                        <td class="px-4 py-2"> <?= $row['nickname'] ?></td>
                        <td class="px-4 py-2"><?= $row['origin'] ?></td>
                    </tr>
                <?php $i++;
                endforeach; ?>
            </tbody>
        </table>

        <div class="mt-6 text-right">
            <a href="/" class="text-blue-700 hover:text-blue-500">Retour à la page d'accueil</a>
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