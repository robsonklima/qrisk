angular.module("qrisk").controller("statusEdtCtrl", function ($scope, $mdToast, $routeParams, statusAPI, $route, $location) {
     $scope.pageTitle = "Status";

    statusAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.status = data;
    });

    $scope.edtStatus = function(item) {
        statusAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/status.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the status.";
        });
    };

});
