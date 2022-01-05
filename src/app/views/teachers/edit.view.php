<main>
  <div class="mt-6 container mx-auto">
    <h2 class="text-lg font-semibold">Modification d'un enseignant</h2>

    <form class="mt-4 w-full max-w-md pb-6" method="POST" action="/teachers/update">
      <input class="hidden" type="hidden" name="idTeacher" value="<?= $teacher['idTeacher'] ?>">
      <div class="flex flex-wrap">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="firstName">
          Prénom
        </label>
        <input value="<?= $teacher['teaFirstname'] ?>" class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="firstName" type="text" name="firstName" placeholder="John">
      </div>
      <div class="w-full">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="lastName">
          Nom
        </label>
        <input value="<?= $teacher['teaName'] ?>" class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="lastName" type="text" name="lastName" placeholder="Doe">
      </div>
      <div class="mt-4">
        <div class="flex items-center"><input <?= $teacher['teaGender'] === 'h' ? 'checked' : '' ?> id="homme" type="radio" name="gender" value="homme"><label class="ml-2" for="homme">Homme</label></div>
        <div class="flex items-center"><input <?= $teacher['teaGender'] === 'f' ? 'checked' : '' ?> id="femme" type="radio" name="gender" value="femme"><label class="ml-2" for="femme">Femme</label></div>
        <div class="flex items-center"><input <?= $teacher['teaGender'] === 'a' ? 'checked' : '' ?> id="autre" type="radio" name="gender" value="autre"><label class="ml-2" for="autre">Autre</label></div>
      </div>

      <div class="mt-4">
        <div class="font-semibold">Section(s):</div>
        <?php foreach ($sections as $section) : ?>
          <div class="flex items-center">
            <input <?= strpos($teacher['sections'], $section['secName']) !== false ? 'checked' : '' ?> id="<?= $section['idSection'] ?>" type="checkbox" name="sections[]" value="<?= $section['idSection'] ?>">
            <label class="ml-2" for="<?= $section['idSection'] ?>"><?= $section['secName'] ?></label>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="mt-4 leading-tight">
        <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
          Modifier l'enseignant
        </button>
      </div>

      <?php if (!empty($errors)) : ?>
        <?php include('/app/views/partials/errors.php'); ?>
      <?php endif; ?>

    </form>

    <div class="max-w-md flex items-center justify-center py-4 text-2xl text-gray-700 font-bold">***</div>

    <?php if ($alreadyNamedByUser) : ?>
      <h3 class="block max-w-md w-full py-3 text-lg font-semibold border-b border-gray-400">
        Modifier le surnom de <?= $teacher['teaFirstname'] ?> <?= $teacher['teaName'] ?>
      </h3>

      <form class="mt-6 w-full max-w-md pb-6" method="POST" action="/nicknames/update">
        <input class="hidden" type="hidden" name="idTeacher" value="<?= $nickname['idTeacher'] ?>">
        <input class="hidden" type="hidden" name="idUser" value="<?= $nickname['idUser'] ?>">
        <div>
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nickname">
            Surnom
          </label>
          <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" value="<?= $nickname['nickname'] ?>" id="nickname" type="text" name="nickname" placeholder="Johnny">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="origin">
            Origine du surnom
          </label>
          <textarea class="appearance-none resize-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="origin" rows="2" cols="50" name="origin" placeholder="1700 avant JC"><?= $nickname['origin'] ?></textarea>
        </div>
        <div class="mt-4 leading-tight">
          <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
            Modifier le surnom
          </button>
        </div>
      </form>
    <?php else : ?>
      <h3 class="block max-w-md w-full py-3 text-lg font-semibold border-b border-gray-400">
        Ajouter un surnom supplémentaire
      </h3>
      <form class="mt-6 w-full max-w-md" method="POST" action="/nicknames">
        <input class="hidden" type="hidden" name="idTeacher" value="<?= $teacher['idTeacher'] ?>">
        <input class="hidden" type="hidden" name="idUser" value="<?= $_SESSION['user']['id'] ?>">
        <div>
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nickname">
            Surnom
          </label>
          <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="nickname" type="text" name="nickname" placeholder="Johnny">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="origin">
            Origine du surnom
          </label>
          <textarea class="appearance-none resize-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="origin" rows="2" cols="50" name="origin" placeholder="1700 avant JC"></textarea>
        </div>
        <div class="mt-4 leading-tight">
          <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
            Ajouter un surnom
          </button>
        </div>
      </form>
    <?php endif; ?>

    <div class="mt-6 text-right">
      <a href="/" class="text-blue-700 hover:text-blue-500">Retour à la page d'accueil</a>
    </div>
  </div>
</main>