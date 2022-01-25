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
     * Create the database connection
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
     * Query simple queries when there is no params to pass
     */
    public function queryExecute($query)
    {
        $this->req = $this->connector->query($query);
    }

    /**
     * Prepare and execute a query to avoid sql injections
     */
    public function prepareExecute($query, $params)
    {
        $this->req = $this->connector->prepare($query);

        try {
            foreach ($params as $key => $value) {
                $this->req->bindValue($key, $value['value'], $value['type']);
            }
            $this->req->execute();
        } catch (PDOException $e) {
            dd($e);
            // TODO: add this in production
            // redirect('');
        }
    }

    /**
     * Transfrom the fetched data into the selected type
     */
    private function fetchData($mode)
    {
        // Ex: PDO::FETCH_ASSOC
        return $this->req->fetchALL($mode);
    }

    public function fetchAll()
    {
        return $this->fetchData(PDO::FETCH_ASSOC);
    }

    public function fetchOne()
    {
        return $this->req->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Empty the record set
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
     * Return all the teachers from the db
     */
    public function getAllTeacher()
    {
        $this->queryExecute('
            SELECT t_teacher.idTeacher, t_teacher.teaName, t_teacher.teaFirstname, t_teacher.teaGender, t_teacher.teaVotes,
            GROUP_CONCAT(t_nickname.nickname) AS nicknames
            FROM t_teacher
            LEFT JOIN t_nickname ON t_nickname.idTeacher = t_teacher.idTeacher
            GROUP BY t_teacher.idTeacher
            ORDER BY t_teacher.teaVotes DESC
        ');

        $result = $this->fetchData(PDO::FETCH_ASSOC);
        $this->closeCursor();
        return $result;
    }

    /**
     * Return data about the searched by id teacher
     */
    public function getOneTeacher($id)
    {
        $query = "
            SELECT t_teacher.idTeacher, t_teacher.teaName, t_teacher.teaFirstname, t_teacher.teaGender,
            t_nickname.idUser, t_nickname.nickname, t_nickname.origin,
            GROUP_CONCAT(DISTINCT t_section.secName) as sections
            FROM t_teacher
            LEFT JOIN t_nickname ON t_nickname.idTeacher = t_teacher.idTeacher
            INNER JOIN t_teach ON t_teach.idTeacher = t_teacher.idTeacher
            INNER JOIN t_section ON t_section.idSection = t_teach.idSection
            WHERE t_teacher.idTeacher = :id
            GROUP BY t_nickname.nickname
        ";

        $this->prepareExecute($query, [
            'id' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $result = $this->fetchData(PDO::FETCH_ASSOC);
        if (empty($result)) {
            redirect('');
        }
        $this->closeCursor();
        return $result;
    }

    /**
     * Verify if a section id exists in the db
     */
    public function checkSectionExists($id)
    {
        $query = "
            SELECT t_section.idSection, t_section.secName
            FROM t_section
            WHERE t_section.idSection = :id
        ";

        $this->prepareExecute($query, [
            'id' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $result = $this->fetchData(PDO::FETCH_ASSOC);
        if (empty($result)) {
            return false;
        }
        $this->closeCursor();
        return true;
    }

    /**
     * Return all the sections from the db
     */
    public function getAllSections()
    {
        $this->queryExecute('
            SELECT t_section.idSection, t_section.secName
            FROM t_section
        ');

        $result = $this->fetchData(PDO::FETCH_ASSOC);
        $this->closeCursor();
        return $result;
    }

    /**
     * Create a teacher with values passed in $infos array
     */
    public function createTeacher($infos)
    {
        // Techer
        $queryTeacher = "
            INSERT into t_teacher
            (teaName, teaFirstname, teaGender)
            VALUES (:teaName, :teaFirstname, :teaGender)
        ";

        $this->prepareExecute($queryTeacher, [
            'teaName' => [
                'value' => $infos['lastName'],
                'type' => PDO::PARAM_STR
            ],
            'teaFirstname' => [
                'value' => $infos['firstName'],
                'type' => PDO::PARAM_STR
            ],
            'teaGender' => [
                'value' => $infos['gender'],
                'type' => PDO::PARAM_STR
            ]
        ]);

        // Sections
        $idTeacher = $this->connector->lastInsertId();
        foreach ($infos['sections'] as $section) {
            $queryTeaches = "
                INSERT into t_teach
                (idSection, idTeacher)
                VALUES (:idSection, :idTeacher)
            ";

            $this->prepareExecute($queryTeaches, [
                'idSection' => [
                    'value' => $section,
                    'type' => PDO::PARAM_INT
                ],
                'idTeacher' => [
                    'value' => $idTeacher,
                    'type' => PDO::PARAM_INT
                ]
            ]);
        }

        // Nickname
        $queryNickname = "
            INSERT into t_nickname
            (idTeacher, idUser, nickname, origin)
            VALUES (:idTeacher, :idUser, :nickname, :origin)
        ";

        $this->prepareExecute($queryNickname, [
            'idTeacher' => [
                'value' => $idTeacher,
                'type' => PDO::PARAM_INT
            ],
            'idUser' => [
                'value' => $_SESSION['user']['id'],
                'type' => PDO::PARAM_INT
            ],
            'nickname' => [
                'value' => $infos['nickname'],
                'type' => PDO::PARAM_STR
            ],
            'origin' => [
                'value' => $infos['origin'],
                'type' => PDO::PARAM_STR
            ]
        ]);

        $this->closeCursor();
    }

    /**
     * Update a selected teacher with the new infos
     */
    public function updateTeacher($infos)
    {
        $queryTeacher = "
      UPDATE t_teacher
      SET teaName = :lastName, teaFirstName = :firstName, teaGender = :gender
      WHERE idTeacher = :idTeacher
    ";

        $this->prepareExecute($queryTeacher, [
            'firstName' => [
                'value' => $infos['firstName'],
                'type' => PDO::PARAM_STR
            ],
            'lastName' => [
                'value' => $infos['lastName'],
                'type' => PDO::PARAM_STR
            ],
            'gender' => [
                'value' => $infos['gender'],
                'type' => PDO::PARAM_STR
            ],
            'idTeacher' => [
                'value' => $infos['idTeacher'],
                'type' => PDO::PARAM_INT
            ]
        ]);

        // Delete old sections of the teacher
        $queryDeleteTeach = "
      DELETE FROM t_teach
      WHERE t_teach.idTeacher = :idTeacher
    ";

        $this->prepareExecute($queryDeleteTeach, [
            'idTeacher' => [
                'value' => $infos['idTeacher'],
                'type' => PDO::PARAM_INT
            ]
        ]);

        // Add the new sections of the teacher
        foreach ($infos['sections'] as $section) {
            $queryTeaches = "
        INSERT into t_teach
        (idSection, idTeacher)
        VALUES (:idSection, :idTeacher)
      ";

            $this->prepareExecute($queryTeaches, [
                'idSection' => [
                    'value' => $section,
                    'type' => PDO::PARAM_INT
                ],
                'idTeacher' => [
                    'value' => $infos['idTeacher'],
                    'type' => PDO::PARAM_INT
                ]
            ]);
        }

        $this->closeCursor();
    }

    /**
     * Delete a selected teacher by id. 
     * It also removes all his sections and nicknames
     */
    public function deleteOneTeacher($id)
    {
        // Delete from t_teach
        $queryTeach = "
            DELETE FROM t_teach
            WHERE t_teach.idTeacher = :idTeacher
        ";

        $this->prepareExecute($queryTeach, [
            'idTeacher' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        // Delete from t_nickname
        $queryNickname = "
            DELETE FROM t_nickname
            WHERE t_nickname.idTeacher = :idTeacher
        ";

        $this->prepareExecute($queryNickname, [
            'idTeacher' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        // Delete from t_teacher
        $queryTeacher = "
            DELETE FROM t_teacher
            WHERE t_teacher.idTeacher = :idTeacher
        ";

        $this->prepareExecute($queryTeacher, [
            'idTeacher' => [
                'value' => $id,
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }

    /**
     * Create a teacher's nickname with values passed in $infos array
     */
    public function createNickname($infos)
    {
        // Nickname
        $queryNickname = "
      INSERT into t_nickname
      (idTeacher, idUser, nickname, origin)
      VALUES (:idTeacher, :idUser, :nickname, :origin)
    ";

        $this->prepareExecute($queryNickname, [
            'idTeacher' => [
                'value' => $infos['idTeacher'],
                'type' => PDO::PARAM_INT
            ],
            'idUser' => [
                'value' => $_SESSION['user']['id'],
                'type' => PDO::PARAM_INT
            ],
            'nickname' => [
                'value' => $infos['nickname'],
                'type' => PDO::PARAM_STR
            ],
            'origin' => [
                'value' => $infos['origin'],
                'type' => PDO::PARAM_STR
            ]
        ]);

        $this->closeCursor();
    }

    /**
     * Update a selected teacher's nickname with the new infos
     */
    public function updateNickname($infos)
    {
        $queryTeacher = "
      UPDATE t_nickname
      SET nickname = :nickname, origin = :origin
      WHERE idTeacher = :idTeacher and idUser = :idUser
    ";

        $this->prepareExecute($queryTeacher, [
            'nickname' => [
                'value' => $infos['nickname'],
                'type' => PDO::PARAM_STR
            ],
            'origin' => [
                'value' => $infos['origin'],
                'type' => PDO::PARAM_STR
            ],
            'idUser' => [
                'value' => $infos['idUser'],
                'type' => PDO::PARAM_INT
            ],
            'idTeacher' => [
                'value' => $infos['idTeacher'],
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }

    /**
     * The logged user vote for a specific teacher
     */
    public function voteForATeacher($infos)
    {
        $queryTeacher = "
      UPDATE t_teacher
      SET teaVotes = :votes
      WHERE idTeacher = :idTeacher
    ";

        $this->prepareExecute($queryTeacher, [
            'votes' => [
                'value' => $infos['votes'],
                'type' => PDO::PARAM_INT
            ],
            'idTeacher' => [
                'value' => $infos['idTeacher'],
                'type' => PDO::PARAM_INT
            ]
        ]);

        $queryUser = "
      UPDATE t_user
      SET useVotes = :votes
      WHERE idUser = :idUser
    ";

        // Add one vote to User
        $_SESSION['user']['votes']++;

        $this->prepareExecute($queryUser, [
            'votes' => [
                'value' => $_SESSION['user']['votes'],
                'type' => PDO::PARAM_INT
            ],
            'idUser' => [
                'value' => $_SESSION['user']['id'],
                'type' => PDO::PARAM_INT
            ]
        ]);

        $this->closeCursor();
    }
}
