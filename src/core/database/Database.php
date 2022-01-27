<?php

/**
 * Auteurs: Loïc Rosset, Alexandre Jaquier, Valentin Kaelin
 * Date: 28.01.2022
 * Description: Gère la connexion avec la base de données
 */

namespace App\Core\Database;

use PDO;
use PDOException;

class Database
{
    private $connector;
    private $req;

    /**
     * Crée la connexion avec la base de données
     */
    function __construct($config)
    {
        try {
            $this->connector = new PDO(
                $config['connection'] . ';dbname=' . $config['name'] . ';options=\'--client_encoding=UTF8\'',
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $e) {
            echo 'Error : ' . $e->getMessage();
        }
    }

    /**
     * Requête simple qui sans aucun paramètre à passer
     */
    public function queryExecute($query)
    {
        $this->req = $this->connector->query($query);
    }

    /**
     * Prépare et exécute une requête afin d'éviter les injections SQL
     * 
     * Ne throw pas en cas d'erreur
     */
    public function prepareExecute($query, $params)
    {
        try {
            $this->prepareExecuteUnCatched($query, $params);
        } catch (PDOException $e) {
            dd($e);
            // TODO: add this in production
            // redirect('');
        }
    }

    /**
     * Prépare et exécute une requête afin d'éviter les injections SQL
     * 
     * Throw en cas d'erreur
     */
    public function prepareExecuteUnCatched($query, $params)
    {
        $this->req = $this->connector->prepare($query);

        foreach ($params as $key => $value) {
            $this->req->bindValue($key, $value['value'], $value['type']);
        }
        $this->req->execute();
    }

    /**
     * Transforme les données reçues d'une requête dans le type souhaité
     */
    private function fetchData($mode)
    {
        // Exemple: PDO::FETCH_ASSOC
        return $this->req->fetchALL($mode);
    }

    /**
     * Récupère toutes les résultats d'une requête
     */
    public function fetchAll()
    {
        return $this->fetchData(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un résultat d'une requête
     */
    public function fetchOne()
    {
        return $this->req->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vide le jeu de documents
     */
    public function closeCursor()
    {
        $this->req->closeCursor();
    }

    /**
     * Retourne le dernier id inséré dans la base de données
     */
    public function getLastInsertId()
    {
        return $this->connector->lastInsertId();
    }

    /**
     * Démarre une transaction
     *
     */
    public function beginTransaction()
    {
        return $this->connector->beginTransaction();
    }

    /**
     * Commit une transaction
     *
     */
    public function commit()
    {
        return $this->connector->commit();
    }

    /**
     * Vérifie si une transaction est en cours ou non
     *
     */
    public function inTransaction()
    {
        return $this->connector->inTransaction();
    }

    /**
     * Annule une transaction
     *
     */
    public function rollback()
    {
        return $this->connector->rollback();
    }
}
