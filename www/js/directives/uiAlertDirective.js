angular.module("qrisk").directive("uiAlert", function () {
    return {
        templateUrl: "view/alert.html",
        //replace: true,
        restrict: "AE",
        scope: {
            title: "@title",
            type: "@type",
            message: "=message"
        },
        //transclude: true
    };
});