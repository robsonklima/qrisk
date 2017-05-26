angular.module("qrisk").controller("earCatEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, earCatsAPI, statusAPI) {
    $scope.pageTitle = "EAR categories";

    earCatsAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.earCategoria = data;
    });

    $scope.edtEarCategoria = function(item) {
        earCatsAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/earcat.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update EAR category.";
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
