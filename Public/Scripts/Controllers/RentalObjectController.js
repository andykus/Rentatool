/**
 * Created by Elin on 2014-04-18.
 */

rentaTool.controller('RentalObjectController', ['$scope', '$routeParams', 'RentalObject', '$location', 'TimeUnit', 'PricePlan', 'RentalObjectService', function ($scope, $routeParams, RentalObject, $location, TimeUnit, PricePlan, RentalObjectService) {

   if ($routeParams.id) {
      $scope.rentalObject = RentalObject.get({id: $routeParams.id});
   } else {
      $scope.rentalObject = new RentalObject({});
   }

   $scope.newPricePlan = new PricePlan();

   $scope.timeUnitCollection = TimeUnit.query();
   $scope.rentalObject.pricePlanCollection = [];

   $scope.deletePricePlan = function (pricePlan) {
      var indexOfPricePlan;

      if ($scope.rentalObject.id) {
         $scope.newPricePlan.$delete({id: pricePlan.id}, function () {
            indexOfPricePlan = $scope.rentalObject.pricePlanCollection.indexOf(pricePlan);
            $scope.rentalObject.pricePlanCollection.splice(indexOfPricePlan, 1);
         });
      } else {
         indexOfPricePlan = $scope.rentalObject.pricePlanCollection.indexOf(pricePlan);
         $scope.rentalObject.pricePlanCollection.splice(indexOfPricePlan, 1);
      }
   };

   $scope.addPricePlan = function (pricePlan) {
      pricePlan.price = parseFloat(pricePlan.price);
      pricePlan.timeUnitId = parseInt(pricePlan.timeUnitId, 10);

      if ($scope.rentalObject.id) {
         $scope.newPricePlan.rentalObjectId = $scope.rentalObject.id;
         $scope.newPricePlan.$save({}, function () {
            $scope.rentalObject.pricePlanCollection.push(pricePlan);
         });
      } else {
         $scope.rentalObject.pricePlanCollection.push(pricePlan);
      }

      $scope.newPricePlan = new PricePlan();
   };

   $scope.filterUsedPricePlan = function (pricePlanCollection) {

      return function (timeUnit) {
         var alreadyExists = pricePlanCollection.some(function (pricePlan) {
               return timeUnit.id === pricePlan.timeUnitId;
            }
         );

         return alreadyExists === false;

      };
   };

   $scope.createRentalObject = function () {
      $scope.rentalObject.$save({});
   };

   $scope.updateRentalObject = function () {
      $scope.rentalObject.$update({});
   };

   $scope.returnToRentalObjectList = function () {
      $location.path('/rentalobjects');
   };

   $scope.$watch(RentalObjectService.getPhoto, function(photo){
      $scope.rentalObject.fileCollection = [photo];
   });
}]);