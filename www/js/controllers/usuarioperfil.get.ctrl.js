angular.module("qrisk").controller("usuarioPerfilGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, usuariosPerfisAPI) {
	$scope.pageTitle = "User profiles";
    $scope.list = [];

    var getUsuariosPerfis = function() {
        usuariosPerfisAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to fetch the user profiles.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm().textContent('Are you sure to delete this user profile?')
            .ok('Sim').clickOutsideToClose(true).cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            usuariosPerfisAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getUsuariosPerfis();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this user profile.";
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

    getUsuariosPerfis();
});
