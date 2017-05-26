angular.module("qrisk").controller("riscoTipoEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, riscosTipoAPI, statusAPI) {
    $scope.pageTitle = "Risk types";

    riscosTipoAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.riscotipo = data;
    });

    $scope.edtItem = function(item) {
        riscosTipoAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/riscotipo.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the type.";
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
