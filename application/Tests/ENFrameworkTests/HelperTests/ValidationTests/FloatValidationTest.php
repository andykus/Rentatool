<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 24/07/14
 * Time: 22:51
 */

namespace Rentatool\Tests\ENFrameworkTests\HelperTests\ValidationTests;


use Rentatool\Application\ENFramework\Helpers\Validation\FloatValidation;

class FloatValidationTest extends \PHPUnit_Framework_TestCase{

   /**
    * Normal use case should return true.
    */
   public function testNormalValue(){
      $floatValidation = new FloatValidation(array());
      $result          = $floatValidation->validate(3.14);
      $this->assertTrue($result);
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName måste vara ett decimaltal.
    */
   public function testValidateWithString(){
      $floatValidation = new FloatValidation(array('genericName' => 'propertyName'));
      $floatValidation->validate('tjugoåttaochfemtio');
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName måste vara ett decimaltal.
    */
   public function testValidateWithNumericString(){
      $floatValidation = new FloatValidation(array('genericName' => 'propertyName'));
      $floatValidation->validate('4556.44');
   }

   /**
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Ange 3 decimaler för propertyName.
    */
   public function testWrongNumberOfDecimals(){
      $floatValidation = new FloatValidation(array('genericName' => 'propertyName', 'numberOfDecimals' => 3));
      $floatValidation->validate(677444.13);
   }

   /**
    * Test that an exception is thrown when a negative number is inserted and it's
    * not allowed.
    * @expectedException \Rentatool\Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage propertyName får inte vara negativt.
    */
   public function testUnAllowedNegativeNumber(){
      $integerValidation = new FloatValidation(array('genericName' => 'propertyName'));
      $result            = $integerValidation->validate(-45566.655);
      $this->assertTrue($result);
   }
} 