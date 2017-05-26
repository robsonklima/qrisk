angular.module("qrisk").controller("usuarioPerfilAddCtrl", function ($scope, $mdToast, usuariosPerfisAPI, $location, statusAPI, menusAPI) {
    $scope.pageTitle = "User profiles";

    $scope.addItem = function(item) {
        usuariosPerfisAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/usuarioperfil.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the user profile!";
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

    var carregarMenus = function() {
        menusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.menus = data;
            else
                $scope.error = "Unable to fetch the menus.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the menus.";
        });
    };

    carregarStatus();
    carregarMenus();
});
