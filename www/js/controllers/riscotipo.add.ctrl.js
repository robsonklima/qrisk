angular.module("qrisk").controller("riscoTipoAddCtrl", function ($scope, $mdToast, $location, riscosTipoAPI, statusAPI) {
    $scope.pageTitle = "Risk types";

    $scope.addItem = function(item) {
        riscosTipoAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/riscotipo.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the risk type!";
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
