angular.module("qrisk").controller("riscoAddCtrl", function ($scope, $mdToast, $rootScope, $location, riscosAPI, riscosTipoAPI, earCatsAPI, earSubCatsAPI, statusAPI) {
    $scope.pageTitle = "Risks";

    $scope.risco = {};
    $scope.risco.id_usuario = $rootScope.globals.currentUser.id;

    $scope.addItem = function(item) {
        riscosAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/risco.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the risk!";
        });
    };

    var carregarRiscosTipo = function() {
        riscosTipoAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.tipos = data;
            else
                $scope.error = "Unable to fetch the risk types.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the risk types.";
        });
    };

    var carregarEarCategorias = function() {
        earCatsAPI.buscarTodos().success(function (data) {
            if (data)
                $scope.earCategorias = data;
            else
                $scope.error = "Unable to fetch EAR categories.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch EAR categories.";
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

    carregarRiscosTipo();
    carregarEarCategorias();
    carregarStatus();
});
