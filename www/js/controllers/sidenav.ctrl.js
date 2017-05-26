angular.module('qrisk').controller('sidenavCtrl', function ($scope, $rootScope, $timeout, $mdSidenav, menusAPI) {
    $scope.toggleLeft = buildToggler('left');

    function buildToggler(componentId) {
      return function() {
          $mdSidenav(componentId).toggle();
      }
    }

    var carregarMenus = function() {
        menusAPI.buscarPorIdUsuarioPerfil($rootScope.globals.currentUser.id_usuario_perfil).success(function (data) {
            if (data)
                $scope.menus = data;
            else
                $scope.error = "Unable to fetch the menus.";
        }).error(function (data, status) {
            $scope.error = "Unable to fetch the menus.";
        });
    };

    carregarMenus();
});
