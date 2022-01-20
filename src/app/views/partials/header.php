<!DOCTYPE html>
<html lang="fr">

<head>
    <!--
    ETML
    Author      : Valentin Kaelin
    Date        : 05.12.2019
    Description : Header for the whole project/website, contains the navigation and the login form
    -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>gymeo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/@tailwindcss/forms/dist/forms.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
</head>

<body class="font-sans antialiased bg-gray-200">
    <header>
        <div class="mt-5 container mx-auto">
            <div class="flex justify-between items-center px-4">
                <h1 class="text-xl font-bold uppercase">gymeo</h1>
                <?php if (!$logged) : ?>
                    <form action="/login" method="POST" class="flex">
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-2 px-4 leading-tight focus:outline-none focus:border-gray-500" type="text" name="user" placeholder="Pseudonyme">
                        <button class="ml-2 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Se connecter
                        </button>
                    </form>
                <?php else : ?>
                    <div class="flex items-center">
                        <div><?= $user['user'] ?></div>
                        <a href="/logout" class="ml-2 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Se déconnecter
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <nav class="mt-2 flex items-center px-4 py-3 bg-indigo-200">
                <a href="/" class="border-b-2 border-transparent hover:border-gray-900">Accueil</a>
                <a href="/exercices" class="ml-3 border-b-2 border-transparent hover:border-gray-900">Exercices</a>
                <?php if ($logged) : ?>
                    <span class="mx-3">●</span>
                    <!-- <a href="/teachers/create" class="border-b-2 border-transparent hover:border-gray-900">Ajouter un enseignant</a> -->
                    <a href="/programs" class="border-b-2 border-transparent hover:border-gray-900">Mes programmes</a>
                    <a href="#" class="ml-3 border-b-2 border-transparent hover:border-gray-900">Historique séances</a>
                    <a href="#" class="ml-3 border-b-2 border-transparent hover:border-gray-900">Historique séries</a>
                    <a href="#" class="ml-3 border-b-2 border-transparent hover:border-gray-900">Créer une séance</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>