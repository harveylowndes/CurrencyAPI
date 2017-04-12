(function() {
	var app = angular.module('seacurrentApp', []);
    app.controller('seacurrentController', function($scope, $http) {

    	backup_form = angular.copy($scope.form);

    	/**
    	*	Field visibilities.
    	*/
        $scope.nameFieldVisibility = function() {
        	if($scope.request == 'put') {
        		return true;
        	} else {
        		return false;
        	}
        }

        $scope.rateFieldVisibility = function() {
        	if($scope.request != 'delete') {
        		return true;
        	} else {
        		return false;
        	}
        }

        $scope.locationsFieldVisibility = function() {
        	if($scope.request == 'put') {
        		return true;
        	} else {
        		return false;
        	}
        }

        /*
        *   Reset model upon every method radio button change so 
        *   that the field values of the previously select method
        *   are not sent.
        */
        $scope.reset = function() {
        	var temp_format = angular.copy($scope.form.format);
        	$scope.form = { format: temp_format };
        }

        /**
        *	3rd Party Code from: http://stackoverflow.com/questions/6566456/how-to-serialize-a-object-into-a-list-of-parameters
        *   JSON to encoded URI.
        */
        serialize = function(obj) {
  			var str = [];
  			for(var p in obj) {
    			if (obj.hasOwnProperty(p)) {
      				str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    			}
            }
  			return str.join("&");
		}


        $scope.submit = function() {
	        $http({
	  			url: 'http://127.0.0.1:8888/web/university/atwd2/conv.php',
	  			method: angular.copy($scope.request), //request method name
	  			data: serialize($scope.form), //serialised JSON model as encoded URI
	  			headers: {
	    			'Content-Type': 'application/x-www-form-urlencoded'
	  			}
			}).success(function(response) {
				if($scope.form.format == "json") { //determine by what header is send back, not the format
					$scope.response = JSON.stringify(response, undefined, 4);
				} else {
					$scope.response = response;
				}
			});
		}

    });
        
})();