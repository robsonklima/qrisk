angular.module("qrisk").directive("uiPhone", function($filter) {
   return {
       require: "ngModel",
       link: function (scope, element, attrs, ctrl) {
           
           var _formatPhone = function (phone) {
                if (phone != undefined)
				phone = phone.replace(/[^0-9]+/g, "");
               
                var aux = phone.substring(0,1);
				if(phone.length > 0) {
					phone =  "(" + aux + phone.substring(1);
				}
                if(phone.length > 3) {
					phone = phone.substring(0,3) + ")" + phone.substring(3,12);
				}
				return phone;
			};

			element.bind("keyup", function () {
				ctrl.$setViewValue(_formatPhone(ctrl.$viewValue));
				ctrl.$render();
			});
           
       }
   };
});