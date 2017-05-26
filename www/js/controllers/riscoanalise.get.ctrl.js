angular.module("qrisk").controller("riscoAnaliseGetCtrl", function ($scope, $timeout, $rootScope, $http, riscosAnaliseAPI) {
	$scope.pageTitle = "Risks reviews";
    $scope.list = [];

    var id_usuario = $rootScope.globals.currentUser.id;

    var getRiscosDispAnalise = function() {
        riscosAnaliseAPI.buscarRiscosDispAnalise(id_usuario).success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            if ($scope.filteredItems == 0) {
                $scope.warning = "No risk available for evaluation.";
            }

            }).error(function (data, status) {
                $scope.error = "Unable to load ratings.";
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

    getRiscosDispAnalise();
});
