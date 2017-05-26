angular.module("qrisk").factory("errorInterceptor", function($q, $location) {
   return {
       resposeError: function(rejection) {
           if (rejection.status === 404) {
               $location.path("/error");
           }
           
           return $q.reject(rejection);  
       }
   };
});