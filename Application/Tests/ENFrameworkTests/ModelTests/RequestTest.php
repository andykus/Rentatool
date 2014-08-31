<?php
/**
 * User: Elin
 * Date: 2014-07-22
 * Time: 09:48
 */

namespace Rentatool\Tests\ENFrameworkTests\ModelTests;


use Rentatool\Application\Collections\RequestMethodCollection;
use Rentatool\Application\ENFramework\Models\Request;

class RequestTest extends \PHPUnit_Framework_TestCase{

   /**
    * Test case that makes sure that ids with more than one number works.
    * Earlier only the first number in the id was used.x
    */
   public function testMultiNumberId(){
      $request = new Request(array(), new RequestMethodCollection(array()));
      $request->setRequestURI('rentalobjects/14');

      $this->assertEquals('14', $request->getId());
   }
} 