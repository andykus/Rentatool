<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 16/08/14
 * Time: 20:11
 */

namespace Application\ENFramework\Helpers\Validation;


use Application\ENFramework\Helpers\ErrorHandling\Exceptions\ApplicationException;

class DateTimeValidation extends ValueValidation{
   public function objectValidation($value){
      $this->validateDate($value);

      return true;
   }

   private function validateDate($value){
      $formattedDate = new \DateTime($value);
      $isInvalidDate = $formattedDate === false || $formattedDate->format('Y-m-d H:i:s') !== $value;

      if ($isInvalidDate){
         throw new ApplicationException(sprintf('Ogiltigt datum angivet för %s.', $this->genericName));
      }

      return true;
   }
}