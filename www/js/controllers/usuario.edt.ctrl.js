angular.module("qrisk").controller("usuarioEdtCtrl", function ($scope, $location, $mdToast, $route, usuariosAPI, usuariosPerfisAPI, statusAPI) {
    $scope.pageTitle = "Users";

    usuariosAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.usuario = data;
    });

    $scope.edtUsuario = function(item) {
        usuariosAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/usuario.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the user.";
        });
    };

    var carregarUsuariosPerfis = function() {
        usuariosPerfisAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.usuariosPerfis = data;
            else
                $scope.error = "Unable to fetch the user profiles.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the user profiles.";
        });
    };

    var carregarUsuariosStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.usuariosStatus = data;
            else
                $scope.error = "Unable to fetch the status.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the status.";
        });
    };

	  carregarUsuariosPerfis();
    carregarUsuariosStatus();
});
