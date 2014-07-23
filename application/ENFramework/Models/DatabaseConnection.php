<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:46
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\ENFramework\Models;


use Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

/**
 * Class DatabaseConnection
 * @package Rentatool\Application\ENFramework\Models
 */
class DatabaseConnection implements IDatabaseConnection {
   /**
    * @var \PDO
    */
   private $databaseConnection;

   public function __construct() {
      $host         = 'localhost';
      $userName     = 'root';
      $password     = '';
      $databaseName = 'Rentatool';

      $PDOOptions = array(
         \PDO::ATTR_ERRMODE                  => \PDO::ERRMODE_EXCEPTION,
         \PDO::ATTR_DEFAULT_FETCH_MODE       => \PDO::FETCH_ASSOC,
         \PDO::MYSQL_ATTR_FOUND_ROWS         => true,
         \PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
      );

      $databaseConnection       = new \PDO(sprintf('mysql:host=%s;dbname=%s', $host, $databaseName), $userName, $password, $PDOOptions);
      $this->databaseConnection = $databaseConnection;
   }

   public function runQuery($query, $params = array()) {
      try {
         $queryResult = [];

         $stmt = $this->databaseConnection->prepare($query);
         $stmt->execute($params);

         $queryHasResultRows = $stmt->columnCount() > 0;

         if ($queryHasResultRows) {
            while ($row = $stmt->fetch()) {
               $queryResult[] = $row;
            }
         }

      } catch (\PDOException $exception) {
         throw new ApplicationException('Kunde inte läsa databas.');
      }

      return $queryResult;
   }
}