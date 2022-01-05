<main>
    <div class="mt-6 container mx-auto">
        <h2 class="text-lg font-semibold">Ajouter un enseignant</h2>

        <form class="mt-4 w-full max-w-md" method="POST" action="/teachers">
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="firstName">
                    Prénom
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="firstName" type="text" name="firstName" placeholder="John">
            </div>
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="lastName">
                    Nom
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="lastName" type="text" name="lastName" placeholder="Doe">
            </div>
            <div class="mt-4">
                <div class="flex items-center"><input id="homme" type="radio" name="gender" value="homme"><label class="ml-2" for="homme">Homme</label></div>
                <div class="flex items-center"><input id="femme" type="radio" name="gender" value="femme"><label class="ml-2" for="femme">Femme</label></div>
                <div class="flex items-center"><input id="autre" type="radio" name="gender" value="autre"><label class="ml-2" for="autre">Autre</label></div>
            </div>

            <div class="mt-4">
                <div class="font-semibold">Section(s):</div>
                <?php foreach ($sections as $section) : ?>
                    <div class="flex items-center">
                        <input id="<?= $section['idSection'] ?>" type="checkbox" name="sections[]" value="<?= $section['idSection'] ?>">
                        <label class="ml-2" for="<?= $section['idSection'] ?>"><?= $section['secName'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-6">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nickname">
                    Surnom
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="nickname" type="text" name="nickname" placeholder="Johnny">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="origin">
                    Origine du surnom
                </label>
                <textarea class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="origin" rows="4" cols="50" name="origin" placeholder="1700 avant JC"></textarea>
            </div>

            <div class="mt-4 leading-tight">
                <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Ajouter
                </button>
                <button class="shadow bg-gray-500 hover:bg-gray-600 focus:outline-none text-gray-800 font-bold py-2 px-4 rounded" type="reset">
                    Effacer
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