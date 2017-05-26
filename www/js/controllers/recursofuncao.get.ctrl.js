angular.module("qrisk").controller("recursofuncaoGetCtrl", function ($scope, $mdDialog, $mdToast, $timeout, $rootScope, $http, recursosFuncaoAPI) {
	$scope.pageTitle = "Resources functions";
    $scope.list = [];

    var getRecursosFuncao = function() {
        recursosFuncaoAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to fetch the resources functions.";
            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm().textContent('Are you sure to delete this this function?')
            .ok('Sim').clickOutsideToClose(true).cancel('Cancel');

        $mdDialog.show(confirm).then(function() {
            recursosFuncaoAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getRecursosFuncao();
            }).error(function (data, status) {
                $scope.error = "Unable to delete this function.";
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

    getRecursosFuncao();
});
