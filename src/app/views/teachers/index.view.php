<main>
  <div class="mt-6 container mx-auto">
    <h2 class="text-lg font-semibold">Liste des enseignants</h2>
    <table class="mt-2 bg-white shadow rounded-lg overflow-hidden">
      <thead>
        <tr class="font-semibold">
          <th class="px-4 py-2 bg-gray-800 text-white">Nom</th>
          <th class="px-4 py-2 bg-gray-800 text-white">Surnoms</th>
          <?php if ($logged) :  ?>
            <th class="px-4 py-2 bg-gray-800 text-white">Options</th>
            <th class="px-4 py-2 bg-gray-800 text-white">Voter</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 0;
        foreach ($teachers as $teacher) : ?>
          <tr class="<?= $i % 2 == 0 ? 'bg-gray-100' : '' ?>">
            <td class="px-4 py-2"> <?= $teacher['teaName'] . ' ' . $teacher['teaFirstname']; ?></td>
            <td class="px-4 py-2 truncate max-w-sm"><?= $teacher['nicknames'] ?></td>

            <?php if ($logged) :  ?>
              <td class="px-4 py-2">
                <div class="flex leading-none text-base text-gray-900">
                  <?php if ($user['role'] === 'Admin') : ?>
                    <a href="teachers/edit?id=<?= $teacher['idTeacher'] ?>" class="hover:text-gray-700"><i class="fas fa-pen"></i></a>
                    <button onclick="deleteTeacher(<?= $teacher['idTeacher'] ?>)" class="ml-3 hover:text-gray-700 focus:outline-none"><i class="fas fa-trash"></i></button>
                  <?php endif; ?>
                  <a href="teachers?id=<?= $teacher['idTeacher'] ?>" class="ml-3 hover:text-gray-700"><i class="fas fa-search"></i></a>
                </div>
              </td>
              <td class="px-4 py-2">
                <div class="flex items-center">
                  <?php if ($user['votes'] < 3) : ?>
                    <form action="/teachers/vote" method="POST">
                      <input class="hidden" type="hidden" name="idTeacher" value="<?= $teacher['idTeacher'] ?>">
                      <input class="hidden" type="hidden" name="oldVotes" value="<?= $teacher['teaVotes'] ?>">
                      <button class="p-1 bg-indigo-200 rounded hover:bg-indigo-300">Je vote</button>
                    </form>
                  <?php endif; ?>
                  <?php if ($teacher['teaVotes'] > 0) : ?>
                    <div class="ml-2"><?= $teacher['teaVotes'] ?></div class="ml-2">
                  <?php endif; ?>
                </div>
              </td>
            <?php endif; ?>
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