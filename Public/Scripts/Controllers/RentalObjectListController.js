/**
 * Created by Elin on 2014-06-12.
 */
(function () {
   angular.module('Rentatool').controller('RentalObjectListController', ['$scope', '$location', 'RentalObject', 'InactivateRentalObject', 'User', 'NavigationService', function ($scope, $location, RentalObject, InactivateRentalObject, User, NavigationService) {
      $scope.rentalObjectCollection = RentalObject.query();
      $scope.rentalObjectFilter = {};
      $scope.currentUser = $scope.userIsLoggedIn && User.get({'id': 'currentUser'});

      $scope.searchRentalObject = function (rentalObjectFilter) {
         var GETParams = {};

         for (var i in rentalObjectFilter) {
            if (rentalObjectFilter.hasOwnProperty(i) && rentalObjectFilter[i]) {
               GETParams[i] = rentalObjectFilter[i];
            }
         }

         $scope.rentalObjectCollection = RentalObject.query(
            GETParams);
      };

      $scope.inactivateRentalObject = function (rentalObject) {
         var indexOfRentalObject;
         var inactivateRentalObjectResource = new InactivateRentalObject(rentalObject);

         inactivateRentalObjectResource.$update({id: rentalObject.id},
            function () {
               indexOfRentalObject = $scope.rentalObjectCollection.indexOf(rentalObject);
               $scope.rentalObjectCollection.splice(indexOfRentalObject, 1);
            });
      };

      $scope.getThumbNailURL = function (rentalObject) {
         var url = '', id;

         if (rentalObject.fileCollection.length > 0) {
            id = rentalObject.fileCollection[0].id;
            url = 'Public/RentalObjectPhotos/' + id + '.JPG';
         }

         return url;
      };

       $scope.navigateToRentalObject = NavigationService.navigateToRentalObject;
   }]);
})();