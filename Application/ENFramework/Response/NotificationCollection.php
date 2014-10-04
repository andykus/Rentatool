<?php
/**
 * Created by PhpStorm.
 * User: elinnilsson
 * Date: 10/08/14
 * Time: 10:15
 */

namespace Application\ENFramework\Response;

use Application\ENFramework\Collections\GeneralCollection;
use Application\ENFramework\Response\Models\Notifier;

class NotificationCollection extends GeneralCollection implements INotificationCollection{
   protected $data = array();
   protected $model = 'Application\ENFramework\Models\Notification';

   /**
    * @param Notifier $notifier
    * @return $this
    */
   public function addNotifier(Notifier $notifier){
      $this->data[] = $notifier;

      return $this;
   }
} 