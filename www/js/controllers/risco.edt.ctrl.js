angular.module("qrisk").controller("riscoEdtCtrl", function ($scope, $mdToast, $route, $location, riscosAPI, riscosTipoAPI, earCatsAPI, earSubCatsAPI, statusAPI) {
    $scope.pageTitle = "Risks";

    riscosAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.risco = data;
    });

    $scope.edtItem = function(item) {
        riscosAPI.atualizar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/risco.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the risk!";
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
