angular.module("qrisk").controller("riscoAnaliseAddCtrl", function ($scope, $mdToast, $location, $route, $rootScope, $location, earCatsAPI, riscosAnaliseAPI, riscosAPI) {
    $scope.pageTitle = "Risk qualitative analysis";

    $scope.riscoanalise = {};
    $scope.riscoanalise.id_usuario = $rootScope.globals.currentUser.id;

    riscosAPI.buscarPorIdRiscoEIdProjeto($route.current.params.id_risco, $route.current.params.id_projeto).success(function(data, status) {
        $scope.risco = data;
        $scope.riscoanalise.id_risco = data.id;
        $scope.riscoanalise.id_projeto = data.id_projeto;
    });

    $scope.addItem = function(item) {
        riscosAnaliseAPI.adicionar(item).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/riscoanalise.get");
        }).error(function (data, status) {
            $scope.error = "Unable to add the analysis!";
        });
    };

    var carregarTiposCusto = function() {
        riscosAnaliseAPI.buscarTipoCusto().success(function (data) {
            if (data)
                $scope.tiposCustos = data;
            else
                $scope.error = "Unable to fetch the cost types.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the cost types.";
        });
    };

    var carregarTiposCronograma = function() {
        riscosAnaliseAPI.buscarTipoCronograma().success(function (data) {
            if (data)
                $scope.tiposCronogramas = data;
            else
                $scope.error = "Unable to fetch the schedules types.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the schedules types.";
        });
    };

    var carregarTiposEscopo = function() {
        riscosAnaliseAPI.buscarTipoEscopo().success(function (data) {
            if (data)
                $scope.tiposEscopos = data;
            else
                $scope.error = "Unable to fetch the scopes types.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the scopes types.";
        });
    };

    var carregarTiposQualidade = function() {
        riscosAnaliseAPI.buscarTipoQualidade().success(function (data) {
            if (data)
                $scope.tiposQualidades = data;
            else
                $scope.error = "Unable to fetch the quality types.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the quality types.";
        });
    };

    var carregarTiposProbabilidade = function() {
        riscosAnaliseAPI.buscarTipoProbabilidade().success(function (data) {
            if (data)
                $scope.tiposProbabilidades = data;
            else
                $scope.error = "Unable to fetch the probability types.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the probability types.";
        });
    };

    carregarTiposCusto();
    carregarTiposCronograma();
    carregarTiposEscopo();
    carregarTiposQualidade();
    carregarTiposProbabilidade();

});
