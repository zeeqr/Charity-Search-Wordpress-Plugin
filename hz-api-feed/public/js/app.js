var hz_app = angular.module("hzCharities", []);

hz_app.controller("hzCharitiesController", function($scope,searchCharity) {
	
	$scope.charities = [];
	$scope.charity = false;
	$scope.charityRegistered = false;
	$scope.inprocess = false;
	$scope.errorMessage = false;
	$scope.selectedSearchType = 'Keyword';
	
	$scope.isArray = angular.isArray;
	
	$scope.init = function () {
		
		$scope.inprocess = true;
		searchCharity.search("search?k=happy").then(function(response){
			$scope.charities = response.data;
			$scope.inprocess = false;
		});
		
	};
	
	$scope.closeCharity = function(){
		
		$scope.charity = false;
	};
	
	$scope.search = function(){

		if($scope.keyword.length > 2)
		switch ($scope.selectedSearchType){
			case 'RegID':
			$scope.viewCharity($scope.keyword);
			break;
		
			case 'Name':
			
		$scope.inprocess = true;
		$scope.errorMessage = false;
		$scope.charity = false;
        searchCharity.search('search?n='+$scope.keyword).then(function(response){
           if (typeof response !== 'undefined'){
			   if(response.data.error){
				   $scope.errorMessage = response.data.error;
			   }else{
				   $scope.charities = response.data;
			   }
			   $scope.inprocess = false;
		   }
        });
				
			break;
			
			default:
		
		$scope.inprocess = true;
		$scope.errorMessage = false;
		$scope.charity = false;
        searchCharity.search('search?k='+$scope.keyword).then(function(response){
           if (typeof response !== 'undefined'){
			   if(response.data.error){
				   $scope.errorMessage = response.data.error;
			   }else{
				   $scope.charities = response.data;
			   }
			   $scope.inprocess = false;
		   }
        });
			
		} //switch selectedSearchType
    };
	
	
	$scope.viewCharity = function(regId){

		$scope.inprocess = true;
		$scope.errorMessage = false;
        searchCharity.search('view?id='+regId).then(function(response){
           if (typeof response !== 'undefined'){
			   if(response.data.error){
				   $scope.errorMessage = response.data.error;
			   }else{
				   $scope.charity = response.data;
				   if($scope.charity.RegistrationHistory.RegistrationRemovalDate){ $scope.charityRegistered = false;
							$scope.charity.RegistrationHistory.RegistrationRemovalDate = new Date($scope.charity.RegistrationHistory.RegistrationRemovalDate).toISOString();

																				 }
				   else $scope.charityRegistered = true;
				   
				   $scope.charity.RegistrationHistory.RegistrationDate = new Date($scope.charity.RegistrationHistory.RegistrationDate).toISOString();
			   }
			   $scope.inprocess = false;
		   }
        });
    };
	
});

hz_app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if (event.which === 13) {
                scope.$apply(function () {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});

hz_app.service('pendingRequests', function() {
  var pending = [];
  this.get = function() {
    return pending;
  };
  this.add = function(request) {
    pending.push(request);
  };
  this.remove = function(request) {

	for(var i = pending.length - 1; i >= 0; i--){
        if(pending[i].url == request){
            pending.splice(i,1);
        }
    }
  };
  this.cancelAll = function() {
    angular.forEach(pending, function(p) {
      p.canceller.resolve();
    });
    pending.length = 0;
  };
});

hz_app.service('searchCharity', ['$http','$q', 'pendingRequests', function($http, $q, pendingRequests){
    return {

		view: function(query){
			
		},
        search: function(query){ pendingRequests.cancelAll();
			var url =  hz_feed.ajax_url+query; 
			
			var canceller = $q.defer();
			pendingRequests.add({ url: url, canceller: canceller });
			
			var requestPromise = $http.get(url,{timeout: canceller.promise}).catch(function (err) { console.log('Terminated...') });;
			
			requestPromise.finally(function() { 
				pendingRequests.remove(url); });
			
            return requestPromise;
        	}
    }
}]);