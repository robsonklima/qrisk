angular.module("qrisk").controller("menuAddCtrl", function ($scope, $mdToast, $location, menusAPI, statusAPI) {
    $scope.pageTitle = "Application menus";

    $scope.addItem = function(item) {
        menusAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/menu.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the menu!";
        });
    };

    var carregarStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.statuss = data;
            else
                $scope.warning = "Unable to find the status.";
        }).error(function (data, status) {
            $scope.error = "Unable to find the status.";
        });
    };

    carregarStatus();
});
