<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Fonctions helpers globales
 */

/**
 * Importe une vue
 *
 * @param  string $name : nom de la vue
 * @param  array  $data : données à passer à la vue
 */
function view($name, $data = [])
{
    // Données du Controller
    extract($data);

    // Utilisateur connecté
    $user = $_SESSION['user'] ?? null;
    $logged = !empty($user);

    require "app/views/partials/header.php";
    require "app/views/{$name}.view.php";
    require "app/views/partials/footer.php";
}

/**
 * Redirige vers une nouvelle page
 *
 * @param  string $path : chemin de la nouvelle page
 */
function redirect($path)
{
    header("Location: /{$path}");
}

/**
 * "Die and dump": Tue le processus et debug la variable passée en paramètre
 *
 * @param * $variable à afficher
 */
function dd($variable)
{
    die(var_dump($variable));
}

/**
 *  Transforme une date en chaîne de caractères lisible par l'utilisateur
 * 
 * Version custom de la fonction deprecated depuis PHP 8.1
 * Source: https://gist.github.com/bohwaz/42fc223031e2b2dd2585aab159a20f30
 */
function custom_strftime(string $format, $timestamp = null): string
{
    if (null === $timestamp) {
        $timestamp = new \DateTime;
    } elseif (is_numeric($timestamp)) {
        $timestamp = date_create('@' . $timestamp);
    } elseif (is_string($timestamp)) {
        $timestamp = date_create('!' . $timestamp);
    }

    if (!($timestamp instanceof \DateTimeInterface)) {
        throw new \InvalidArgumentException('$timestamp argument is neither a valid UNIX timestamp, a valid date-time string or a DateTime object.');
    }

    $locale = 'fr_FR';
    $locale = substr($locale, 0, 5);

    $intl_formats = [
        '%a' => 'EEE',
        '%A' => 'EEEE',
        '%b' => 'MMM',
        '%B' => 'MMMM',
        '%h' => 'MMM',
        '%p' => 'aa',
        '%P' => 'aa',
    ];

    $intl_formatter = function (\DateTimeInterface $timestamp, string $format) use ($intl_formats, $locale) {
        $tz = $timestamp->getTimezone();
        $date_type = IntlDateFormatter::FULL;
        $time_type = IntlDateFormatter::FULL;
        $pattern = '';

        if ($format == '%c') {
            $date_type = IntlDateFormatter::LONG;
            $time_type = IntlDateFormatter::SHORT;
        } elseif ($format == '%x') {
            $date_type = IntlDateFormatter::SHORT;
            $time_type = IntlDateFormatter::NONE;
        } elseif ($format == '%X') {
            $date_type = IntlDateFormatter::NONE;
            $time_type = IntlDateFormatter::MEDIUM;
        } else {
            $pattern = $intl_formats[$format];
        }

        return (new IntlDateFormatter($locale, $date_type, $time_type, $tz, null, $pattern))->format($timestamp);
    };

    $translation_table = [
        '%a' => $intl_formatter,
        '%A' => $intl_formatter,
        '%d' => 'd',
        '%e' => 'j',
        '%j' => function ($timestamp) {
            return sprintf('%03d', $timestamp->format('z') + 1);
        },
        '%u' => 'N',
        '%w' => 'w',
        '%U' => function ($timestamp) {
            $day = new \DateTime(sprintf('%d-01 Sunday', $timestamp->format('Y')));
            return intval(($timestamp->format('z') - $day->format('z')) / 7);
        },
        '%W' => function ($timestamp) {
            $day = new \DateTime(sprintf('%d-01 Monday', $timestamp->format('Y')));
            return intval(($timestamp->format('z') - $day->format('z')) / 7);
        },
        '%V' => 'W',
        '%b' => $intl_formatter,
        '%B' => $intl_formatter,
        '%h' => $intl_formatter,
        '%m' => 'm',
        '%C' => function ($timestamp) {
            return (int) $timestamp->format('Y') / 100;
        },
        '%g' => function ($timestamp) {
            return substr($timestamp->format('o'), -2);
        },
        '%G' => 'o',
        '%y' => 'y',
        '%Y' => 'Y',
        '%H' => 'H',
        '%k' => 'G',
        '%I' => 'h',
        '%l' => 'g',
        '%M' => 'i',
        '%p' => $intl_formatter,
        '%P' => $intl_formatter,
        '%r' => 'G:i:s A',
        '%R' => 'H:i',
        '%S' => 's',
        '%X' => $intl_formatter,
        '%z' => 'O',
        '%Z' => 'T',
        '%c' => $intl_formatter,
        '%D' => 'm/d/Y',
        '%F' => 'Y-m-d',
        '%s' => 'U',
        '%x' => $intl_formatter,
    ];

    $out = preg_replace_callback('/(?<!%)(%[a-zA-Z])/', function ($match) use ($translation_table, $timestamp) {
        if ($match[1] == '%n') {
            return "\n";
        } elseif ($match[1] == '%t') {
            return "\t";
        }

        if (!isset($translation_table[$match[1]])) {
            throw new \InvalidArgumentException(sprintf('Format "%s" is unknown in time format', $match[1]));
        }

        $replace = $translation_table[$match[1]];

        if (is_string($replace)) {
            return $timestamp->format($replace);
        } else {
            return $replace($timestamp, $match[1]);
        }
    }, $format);

    $out = str_replace('%%', '%', $out);
    return $out;
}
