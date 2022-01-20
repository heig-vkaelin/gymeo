<main>
    <div class="mt-6 container mx-auto px-4">
        <h2 class="text-lg font-semibold">Créer une Séance</h2>

        <form class="mt-4 w-full max-w-md" method="POST" action="/sessions">
            <div class="mt-4">
                <div class="font-semibold">Choisissez un programme d'entraînement :</div>
                <?php foreach ($programs as $program) : ?>
                    <div class="flex items-center">
                        <input class="checks" id="<?= $program['id'] ?>" type="radio" name="program" value="<?= $program['id'] ?>">
                        <label class="ml-2 checks" for="<?= $program['id'] ?>"><?= $program['nom'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-4 leading-tight">
                <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Créer
                </button>
            </div>

            <?php if (!empty($errors)) : ?>
                <?php include('/app/views/partials/errors.php'); ?>
            <?php endif; ?>
        </form>

        <div class="mt-6 text-right">
            <a href="/" class="text-blue-700 hover:text-blue-500">Retour à la page d'accueil</a>
        </div>
    </div>
</main>