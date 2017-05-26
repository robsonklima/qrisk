angular.module("qrisk").controller("statusAddCtrl", function ($scope, $mdToast, $location, statusAPI) {
    $scope.pageTitle = "Status";

    $scope.addItem = function(item) {
        statusAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/status.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the status!";
        });
    };
});
