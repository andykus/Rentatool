<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elin
 * Date: 2014-04-06
 * Time: 19:50
 * To change this template use File | Settings | File Templates.
 */

namespace Rentatool\Application\Controllers;

use Rentatool\Application\ENFramework\Helpers\Response;
use Rentatool\Application\ENFramework\Helpers\SessionManager;
use Rentatool\Application\Services\rentalObjectService;

class RentalObjectController {
   /**
    * @var \Rentatool\Application\Services\RentalObjectService
    */
   private $rentalObjectService;

   public function __construct(RentalObjectService $rentalObjectService) {
      $this->rentalObjectService = $rentalObjectService;
   }

   /**
    * @return Response
    */
   public function index() {
      $rentalObjectService    = $this->rentalObjectService;
      $response               = new Response();
      $rentalObjectCollection = $rentalObjectService->index();
      $response->setData($rentalObjectCollection->toArray());

      return $response;
   }

   public function create(array $data) {
      $rentalObjectService = $this->rentalObjectService;
      $currentUser         = SessionManager::getCurrentUser();
      $rentalObject        = $rentalObjectService->create($data, $currentUser);
      $response            = new Response();
      $response->setData($rentalObject->toArray())->setStatusCode(201);

      return $response;
   }

   public function read($id) {
      $rentalObjectService = $this->rentalObjectService;
      $rentalObject        = $rentalObjectService->read($id);
      $response            = new Response();
      $response->setData($rentalObject->toArray());

      return $response;
   }

   public function update($id, $requestData) {
      $rentalObjectService = $this->rentalObjectService;
      $rentalObject        = $rentalObjectService->update($id, $requestData);
      $response            = new Response();
      $response->setData($rentalObject->toArray());

      return $response;
   }

   public function delete($id) {
      $this->rentalObjectService->delete($id);
      $response = new Response();
      $response->setStatusCode(204);

      return $response;
   }
}