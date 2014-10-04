<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 15/08/14
 * Time: 19:26
 */

namespace Application\PHPFramework\Database\Factories;

use Application\PHPFramework\Database\Configuration\LocalDatabaseConfiguration;
use Application\PHPFramework\Database\Configuration\ProductionDatabaseConfiguration;
use Application\PHPFramework\Database\Models\PDOContainer;

class DatabaseConnectionFactory implements IDatabaseConnectionFactory{

   public function build(){
      if ($this->isLocalHost()){
         $connection = $this->getLocalDatabaseConnection();
      } else{
         $connection = $this->getProductionDatabaseConnection();
      }

      return $connection;
   }

   private function getLocalDatabaseConnection(){
      return PDOContainer::getInstance(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                                               LocalDatabaseConfiguration::$host,
                                               LocalDatabaseConfiguration::$databaseName),
                                       LocalDatabaseConfiguration::$username,
                                       LocalDatabaseConfiguration::$password,
                                       LocalDatabaseConfiguration::getPDOOptions());
   }

   private function getProductionDatabaseConnection(){
      return PDOContainer::getInstance(sprintf('mysql:host=%s;dbname=%s;charset=utf8',
                                              ProductionDatabaseConfiguration::$host,
                                              ProductionDatabaseConfiguration::$databaseName),
                                       ProductionDatabaseConfiguration::$username,
                                       ProductionDatabaseConfiguration::$password,
                                       ProductionDatabaseConfiguration::getPDOOptions());
   }

   private function isLocalHost(){
      return array_key_exists("REMOTE_ADDR", $_SERVER) === false || $_SERVER["REMOTE_ADDR"] === '::1' || $_SERVER["REMOTE_ADDR"] === '127.0.0.1';
   }
} 