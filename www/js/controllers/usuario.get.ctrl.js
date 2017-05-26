angular.module("qrisk").controller("usuarioGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, usuariosAPI) {
	$scope.pageTitle = "Users";
    $scope.list = [];

    var getUsuarios = function() {
        usuariosAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Não foi possível carregar the users.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete this user?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            usuariosAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));;
                getUsuarios();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this user.";
            });
        });
    };

    $scope.setPage = function(pageNo) {
        $scope.currentPage = pageNo;
    };
    $scope.filter = function() {
        $timeout(function() {
            $scope.filteredItems = $scope.filtered.length;
        }, 10);
    };
    $scope.sort_by = function(predicate) {
        $scope.predicate = predicate;
        $scope.reverse = !$scope.reverse;
    };

    getUsuarios();
});
