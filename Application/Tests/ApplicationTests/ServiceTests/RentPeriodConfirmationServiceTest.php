<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 31/12/14
 * Time: 17:14
 */

namespace Tests\ServiceTests;


use Application\Models\RentPeriod;
use Application\Models\RentPeriodConfirmation;
use Application\Services\RentPeriodConfirmationService;

class RentPeriodConfirmationServiceTest extends \PHPUnit_Framework_TestCase{

   public function testRead(){

      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $rentPeriodServiceMock->expects($this->once())
                            ->method('read')
                            ->will($this->returnValue(new RentPeriod(array())));

      $userServiceMock = $this->getMockBuilder('Application\Services\UserService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentalObjectMock = $this->getMockBuilder('Application\Models\RentalObject')
                               ->disableOriginalConstructor()
                               ->getMock();

      $rentalObjectMock->expects($this->once())
                       ->method('getUserId')
                       ->will($this->returnValue(1));

      $rentalObjectServiceMock->expects($this->once())
                              ->method('read')
                              ->will($this->returnValue($rentalObjectMock));

      $rentPeriodConfirmationService = new RentPeriodConfirmationService($rentPeriodServiceMock, $userServiceMock, $rentalObjectServiceMock);

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userServiceMock->expects($this->once())
                      ->method('read')
                      ->will($this->returnValue($userMock));

      $rentPeriodConfirmationFactoryMock = $this->getMockBuilder('Application\Factories\RentPeriodConfirmationFactory')
                                                ->disableOriginalConstructor()
                                                ->getMock();
      $rentPeriodConfirmationFactoryMock->expects($this->once())
                                        ->method('getRentPeriodConfirmation')
                                        ->will($this->returnValue(new RentPeriodConfirmation(array())));

      $rentPeriodConfirmation = $rentPeriodConfirmationService->read(9, $userMock, $rentPeriodConfirmationFactoryMock);

      $this->assertInstanceOf('Application\Models\RentPeriodConfirmation', $rentPeriodConfirmation);
   }

   /**
    * The renter id is not the same as the current user id and an error will be thrown
    * @expectedException \Application\PHPFramework\ErrorHandling\Exceptions\ApplicationException
    * @expectedExceptionMessage Du har inte rättighet att visa den här bokningsbekräftelsen.
    */
   public function testReadWithoutPermission(){

      $rentPeriodServiceMock = $this->getMockBuilder('Application\Services\RentPeriodService')
                                    ->disableOriginalConstructor()
                                    ->getMock();

      $rentPeriodMock = $this->getMockBuilder('Application\Models\RentPeriod')
                             ->disableOriginalConstructor()
                             ->getMock();

      $rentPeriodMock->expects($this->once())
                     ->method('getRenterId')
                     ->will($this->returnValue(2));

      $rentPeriodServiceMock->expects($this->once())
                            ->method('read')
                            ->will($this->returnValue($rentPeriodMock));

      $userServiceMock = $this->getMockBuilder('Application\Services\UserService')
                              ->disableOriginalConstructor()
                              ->getMock();

      $rentalObjectServiceMock = $this->getMockBuilder('Application\Services\RentalObjectService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

      $rentPeriodConfirmationService = new RentPeriodConfirmationService($rentPeriodServiceMock, $userServiceMock, $rentalObjectServiceMock);

      $userMock = $this->getMockBuilder('Application\Models\User')
                       ->disableOriginalConstructor()
                       ->getMock();

      $userMock->expects($this->once())
               ->method('getId')
               ->will($this->returnValue(1));

      $rentPeriodConfirmationFactoryMock = $this->getMockBuilder('Application\Factories\RentPeriodConfirmationFactory')
                                                ->disableOriginalConstructor()
                                                ->getMock();

      $rentPeriodConfirmationService->read(9, $userMock, $rentPeriodConfirmationFactoryMock);
   }
} 