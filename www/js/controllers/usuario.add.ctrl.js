angular.module("qrisk").controller("usuarioAddCtrl", function ($scope, $location, $mdToast, usuariosAPI, usuariosPerfisAPI, statusAPI) {
    $scope.pageTitle = "Users";

    $scope.addItem = function(item) {
        usuariosAPI.adicionar(item).success(function (data) {
            $mdToast.show(
              $mdToast.simple()
                .textContent(data)
                .hideDelay(1000)
            );
            $location.path("/usuario.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the user!";
        });
    };

    var carregarUsuariosPerfis = function() {
        usuariosPerfisAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.usuariosPerfis = data;
            else
                $scope.error = "Unable to find the user profiles.";
        }).error(function (data, status) {
            $scope.error = "Unable to find the user profiles.";
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
