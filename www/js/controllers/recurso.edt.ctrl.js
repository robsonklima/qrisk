angular.module("qrisk").controller("recursoEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, recursosAPI, recursosFuncaoAPI, usuariosAPI, statusAPI) {
    $scope.pageTitle = "Resources";

    recursosAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.recurso = data;
    });

    $scope.edtItem = function(item) {
        recursosAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/recurso.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the resource.";
        });
    };

    var carregarFuncoes = function() {
        recursosFuncaoAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.recursosFuncoes = data;
            else
                $scope.warning = "Unable to fetch the functions.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the functions.";
        });
    };

    var carregarUsuarios = function() {
        usuariosAPI.buscarTodos().success(function (data) {
            $scope.usuarios = data;
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the users.";
        });
    };

    var carregarStatus = function() {
        statusAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.statuss = data;
            else
                $scope.warning = "Unable to fetch the status.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the status.";
        });
    };

    carregarFuncoes();
    carregarUsuarios();
    carregarStatus();

});
