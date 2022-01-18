<main>
    <div class="mt-6 container mx-auto px-4">
        <h2 class="text-lg font-semibold">Créer un programme</h2>

        <form class="mt-4 w-full max-w-md" method="POST" action="/programs">
            <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="programName">
                    Nom
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="programName" type="text" name="programName" placeholder="Full body">
            </div>
            <!-- <div>
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="lastName">
                    Nom
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="lastName" type="text" name="lastName" placeholder="Doe">
            </div> -->
            <!-- <div class="mt-4">
                <div class="flex items-center"><input id="homme" type="radio" name="gender" value="homme"><label class="ml-2" for="homme">Homme</label></div>
                <div class="flex items-center"><input id="femme" type="radio" name="gender" value="femme"><label class="ml-2" for="femme">Femme</label></div>
                <div class="flex items-center"><input id="autre" type="radio" name="gender" value="autre"><label class="ml-2" for="autre">Autre</label></div>
            </div> -->

            <div class="mt-4">
                <div class="font-semibold">Exercices:</div>
                <div class="text-sm italic">L'ordre des exercices et les autres informations pourront être modifiés par la suite.</div>
                <?php foreach ($exercices as $exercice) : ?>
                    <div class="flex items-center">
                        <!-- <?php if($exercice['nbrépétitionsconseillé']): ?>
                            <input hidden data-id="<?=$exercice['id'] . '-repeat'?>" type="checkbox" name="nbRépétitions[]" value="<?= $exercice['nbrépétitionsconseillé'] ?>">
                        <?php else : ?>
                            <input hidden data-id="<?=$exercice['id'] . '-time'?>" type="checkbox" name="tempsExécution[]" value="<?= $exercice['tempsexécutionconseillé'] ?>">
                        <?php endif; ?>
                        <input hidden data-id="<?=$exercice['id'] . '-serie'?>" type="checkbox" name="nbSéries[]" value="<?= $exercice['nbsériesconseillé'] ?>"> -->
                        
                        <input class="checks" id="<?= $exercice['id'] ?>" type="checkbox" name="exercices[]" value="<?= $exercice['id'] ?>">
                        <label class="ml-2 checks"><?= $exercice['nom'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- <div class="mt-6">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="nickname">
                    Surnom
                </label>
                <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:border-gray-500" id="nickname" type="text" name="nickname" placeholder="Johnny">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="origin">
                    Origine du surnom
                </label>
                <textarea class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:border-gray-500" id="origin" rows="4" cols="50" name="origin" placeholder="1700 avant JC"></textarea>
            </div> -->

            <div class="mt-4 leading-tight">
                <button class="shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                    Créer
                </button>
                <button class="shadow bg-gray-500 hover:bg-gray-600 focus:outline-none text-white font-bold py-2 px-4 rounded" type="reset">
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

<script>
// const hiddenInput = ['serie', 'time', 'repeat']
// const checkboxes = document.querySelectorAll('.checks')
// const onCheckBoxClick = (e) => {
//     const checked = e.target.checked

//     hiddenInput.forEach(name => {
//         const domInput = document.querySelector(`input[data-id="${e.target.id}-${name}"]`)
//         if (domInput) {
//             domInput.checked = checked
//         }
//     })
// }
// checkboxes.forEach(box => 
//   box.addEventListener('click', onCheckBoxClick)
// )

</script>