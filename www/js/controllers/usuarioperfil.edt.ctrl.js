angular.module("qrisk").controller("usuarioPerfilEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, statusAPI, usuariosPerfisAPI, menusAPI) {
    $scope.pageTitle = "User profiles";

    usuariosPerfisAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.usuarioPerfil = data;
    });

    $scope.edtUsuarioPerfil = function(item) {
        usuariosPerfisAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/usuarioperfil.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the user profile.";
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
