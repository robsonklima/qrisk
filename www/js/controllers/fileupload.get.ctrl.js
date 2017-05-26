angular.module("qrisk").controller("fileUploadGetCtrl", function ($scope, $mdDialog, $mdToast, fileUploadAPI) {
    $scope.pageTitle = "XML Import";
    $scope.list = [];

    var getFiles = function() {

        fileUploadAPI.buscarTodos().success(function (data) {
            $scope.list = data;
            $scope.currentPage = 1;
            $scope.entryLimit = 5;
            $scope.filteredItems = $scope.list.length;
            $scope.totalItems = $scope.list.length;

            }).error(function (data, status) {
                $scope.error = "Unable to add the file!";

            });
    };

    $scope.delItem = function (item) {
        var confirm = $mdDialog.confirm()
            .textContent('Are you sure to delete this file?')
            .ok('Sim')
            .clickOutsideToClose(true)
            .cancel('Cancelar');

        $mdDialog.show(confirm).then(function() {
            fileUploadAPI.apagar(item.id).success(function (data) {
                $mdToast.show($mdToast.simple().textContent(data).hideDelay(2000).position('top right'));
                getFiles();
            }).error(function (data, status) {
                $scope.error = "Unable to delete the file.";
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

    getFiles();
});
