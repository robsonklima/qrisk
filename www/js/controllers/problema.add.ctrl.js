angular.module("qrisk").controller("problemaAddCtrl", function ($scope, $routeParams, $rootScope, $route, $mdDialog, $mdToast, riscosAPI, projetosAPI, demandasAPI, riscosProjetoAPI, riscosDemandaAPI) {
    $scope.pageTitle = "Report a problem";
    $scope.nomeUsuario = $rootScope.globals.currentUser.nome;

    var buscarProjetosPorIdUsuario = function() {
        projetosAPI.buscarTodosPorIdUsuario($rootScope.globals.currentUser.id).success(function (data) {
            if (data) $scope.projetos = data;
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the projects.";
        });
    };

    var buscarDemandasPorIdUsuario = function() {
        demandasAPI.buscarPorIdUsuario($rootScope.globals.currentUser.id).success(function (data) {
            if (data) $scope.demandas = data;

            console.log(data);
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the activities.";
        });
    };

    $scope.marcarRiscoProjetoProblema = function(id_risco, id_projeto, valor) {
        riscosProjetoAPI.marcarRiscoProjetoProblema(id_risco, id_projeto, valor).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            buscarProjetosPorIdUsuario();
        }).error(function (data, status) {
            $scope.error = "Unable to process your request!";
        });
    };

    $scope.marcarRiscoDemandaProblema = function(id_risco, id_demanda, valor) {
        riscosDemandaAPI.marcarRiscoDemandaProblema(id_risco, id_demanda, valor).success(function (data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            buscarDemandasPorIdUsuario();
        }).error(function (data, status) {
            $scope.error = "Unable to process your request!";
        });
    };

    buscarProjetosPorIdUsuario();
    buscarDemandasPorIdUsuario();

});
