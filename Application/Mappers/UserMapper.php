<?php
/**
 * Created by PhpStorm.
 * User: Elin
 * Date: 2014-04-17
 * Time: 20:42
 */

namespace Application\Mappers;

use Application\ENFramework\Database\Models\IDatabaseConnection;

class UserMapper{

   private $databaseConnection;
   private $indexSQL = '
    SELECT
       id,
       username,
       email
    FROM
      users';

   private $createSQL = '
       INSERT INTO
        users
          (
          username,
          email,
          password,
          administrative_access
          )
      VALUES
        (
          :username,
          :email,
          :password,
          :hasAdministrativeAccess
        )
    ';

   private $readSQL = '
    SELECT
       id,
       username,
       email,
       administrative_access AS "hasAdministrativeAccess"
    FROM
      users
    WHERE
      id = :id';

   private $getUserByEmailSQL = '
        SELECT
            id,
            username,
            email,
            password,
            administrative_access AS "hasAdministrativeAccess"
        FROM
          users
        WHERE
          email = :email
    ';

   private $updateSQL = '
       UPDATE
           users
        SET
          username = :username,
          email = :email,
          password = :password,
          administrative_access = :hasAdministrativeAccess
        WHERE
          id = :id
    ';

   private $deleteSQL = '
        DELETE
          FROM
            users
        WHERE
          id = :id

    ';

   public function __construct(IDatabaseConnection $databaseConnection){
      $this->databaseConnection = $databaseConnection;

      return $this;
   }

   public function index(){
      return $this->databaseConnection->runQuery($this->indexSQL, array());
   }

   public function create(array $DBParameters){
      unset($DBParameters['id']);
      $result = $this->databaseConnection->runQuery($this->createSQL, $DBParameters);

      return $this->read($result['lastInsertId']);

   }

   public function update(array $DBParameters){
      $result = $this->databaseConnection->runQuery($this->updateSQL, $DBParameters);

      return $this->read($result['lastInsertId']);
   }

   public function read($id){
      $result = $this->databaseConnection->runQuery($this->readSQL, array('id' => $id));

      return array_shift($result);
   }

   public function getUserByEmail($email){
      $result = $this->databaseConnection->runQuery($this->getUserByEmailSQL, array('email' => $email));

      return array_shift($result);
   }

   public function delete($id){
      return $this->databaseConnection->runQuery($this->deleteSQL, array('id' => $id));
   }
} 