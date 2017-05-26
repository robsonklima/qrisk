angular.module("qrisk").controller("earCatAddCtrl", function ($scope, $mdToast, $location, earCatsAPI, statusAPI) {
    $scope.pageTitle = "EAR categories";

    $scope.addItem = function(item) {
        earCatsAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/earcat.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add EAR category!";
        });
    };

    var carregarStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.statuss = data;
            else
                $scope.error = "Unable to fetch the status.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the status.";
        });
    };

    carregarStatus();
});
