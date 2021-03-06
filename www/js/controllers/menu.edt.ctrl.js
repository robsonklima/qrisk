angular.module("qrisk").controller("menuEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, menusAPI, statusAPI) {
    $scope.pageTitle = "Application menus";

    menusAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.menu = data;
    });

    $scope.edtMenu = function(item) {
        menusAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/menu.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the menu.";
        });
    };

    var carregarStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.statuss = data;
            else
                $scope.warning = "Unable to find the status.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the status.";
        });
    };

    carregarStatus();
});
