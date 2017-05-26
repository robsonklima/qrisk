angular.module("qrisk").controller("recursofuncaoEdtCtrl", function ($scope, $mdToast, $routeParams, $route, $location, recursosFuncaoAPI, statusAPI) {
     $scope.pageTitle = "Resources functions";

    recursosFuncaoAPI.buscarPorId($route.current.params.id).success(function(data, status) {
        $scope.recursofuncao = data;
    });

    $scope.edtItem = function(item) {
        recursosFuncaoAPI.atualizar(item).success(function(data) {
            $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
            $location.path("/recursofuncao.get");
        }).error(function (data, status) {
            $scope.error = "Unable to update the function.";
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

    carregarStatus();

});
