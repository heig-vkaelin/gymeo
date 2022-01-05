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
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">

</head>

<body class="font-sans antialiased bg-gray-200">
    <header>
        <div class="mt-5 container mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold uppercase">gymeo</h1>
                <?php if (!$logged) : ?>
                    <form action="/login" method="POST" class="flex">
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-2 px-4 leading-tight focus:outline-none focus:border-gray-500" type="text" name="user" placeholder="Utilisateur">
                        <input class="ml-2 appearance-none block w-full bg-white text-gray-700 border border-gray-20 rounded py-2 px-4 leading-tight focus:outline-none focus:border-gray-500" type="password" name="password" placeholder="Mot de passe">
                        <button class="ml-2 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded" type="submit">
                            Se connecter
                        </button>
                    </form>
                <?php else : ?>
                    <div class="flex items-center">
                        <div><?= $user['user'] ?> (<?= $user['role'] ?>)</div>
                        <a href="/logout" class="ml-2 flex-shrink-0 shadow bg-gray-800 hover:bg-gray-900 focus:outline-none text-white font-bold py-2 px-4 rounded">
                            Se déconnecter
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <nav class="mt-2 flex items-center px-4 py-3 bg-indigo-200">
                <a href="/" class="border-b-2 border-transparent hover:border-gray-900">Accueil</a>
                <?php if ($logged && $user['role'] === 'Admin') : ?>
                    <span class="mx-3">●</span>
                    <a href="/teachers/create" class="border-b-2 border-transparent hover:border-gray-900">Ajouter un enseignant</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>