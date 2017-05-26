angular.module("qrisk").filter("capitalizer", function() {
   return function (input) {
       var listaDeString = input.split(" ");
       
       listaDeStringFormatada = listaDeString.map(function (string) {
           if(/(da|de)/.test(string)) return string;
           
           return string.charAt(0).toUpperCase() + string.substring(1).toLowerCase();
       });
       
       return listaDeStringFormatada.join(" ");
   };
});