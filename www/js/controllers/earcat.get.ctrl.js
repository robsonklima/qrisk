angular.module("qrisk").controller("earCatGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, earCatsAPI) {
	$scope.pageTitle = "EAR categories";
    $scope.list = [];

    var getEarCategorias = function() {
        earCatsAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to fetch EAR categories.";
            });
    };

    $scope.delItem = function (item) {
	        var confirm = $mdDialog.confirm().textContent('Are you sure to delete this EAR category?')
            .ok('Sim').clickOutsideToClose(true).cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            earCatsAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getEarCategorias();
            }).error(function (data, status) {
                $scope.error = "Unable to delete EAR category.";
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

    getEarCategorias();
});
