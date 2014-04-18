<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-03-04
 * Time: 19:31
 * To change this template use File | Settings | File Templates.
 */

namespace GoFish\Mapper;

use GoFish\Application\ENFramework\Models\IDatabaseConnection;

class CaughtFishMapper
{
    /**
     * @var \GoFish\Application\ENFramework\Models\IDatabaseConnection
     */
    private $databaseConnection;

    private $getIndexSQL = 'SELECT
        caught_fish.id,
        fish_id,
        user_id,
        weight,
        measurement,
        fish.name
        FROM caught_fish
        INNER JOIN fish ON caught_fish.id = fish.id';

    private $create = '
       INSERT INTO
        caught_fish
          (
          fish_id,
          user_id,
          weight,
          measurement
          )
      VALUES
        (
          :fishId,
          :userId,
          :weight,
          :measurement
          )
    ';

    public function __construct(IDatabaseConnection $databaseConnection){
        $this->databaseConnection = $databaseConnection;
    }

    private function getIndexSQL()
    {
        return $this->getIndexSQL;
    }

    public function index($params)
    {
        $caughtFishes = $this->databaseConnection->runQuery($this->getIndexSQL(), $params);
        return $caughtFishes;
    }

    public function create($params)
    {
        $result = $this->databaseConnection->runQuery($this->create, $params);
        return $result;
    }
}