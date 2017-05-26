angular.module("qrisk").controller("recursoAddCtrl", function ($scope, $mdToast, $location, recursosAPI, recursosFuncaoAPI, usuariosAPI, statusAPI) {
    $scope.pageTitle = "Resources";

    $scope.addItem = function(item) {
        recursosAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/recurso.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the resource!";
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
        usuariosAPI.buscarUsuSemRec().success(function (data) {
            if (data)
                $scope.usuarios = data;
            else
                $scope.warning = "Unable to fetch the users.";
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
