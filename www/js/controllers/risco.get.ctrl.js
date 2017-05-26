angular.module("qrisk").controller("riscoGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, riscosAPI) {
	$scope.pageTitle = "Risks";
    $scope.list = [];

    var getRiscos = function() {
        riscosAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to fetch the risks.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete this this risk?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            riscosAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getRiscos();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this the risk.";
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

    getRiscos();
});
