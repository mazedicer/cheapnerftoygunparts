( function(){
	angular.module( 'cheapNerfToyGunPartsApp' ).factory( 'Guns', gunsFunction );
	angular.module( 'cheapNerfToyGunPartsApp' ).factory( 'RandomOrderNumber', randomOrderNumberFunction );
	function gunsFunction( $http ){
		//console.log( "factory" );
		function getGuns(){
			return $http.get( 'process/guns.json' );
		}
		return {
			getGuns: getGuns
		};
	}
	function randomOrderNumberFunction( $http ){
		$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
		function getRandomOrderNumber(){
			var req = {
				method: 'POST',
				url: 'process/process_cart.php',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded',
					'Accept': 'application/x-www-form-urlencoded'
				},
				data: { cart: true }
			};
			return $http( req );
		}
		return {
			getRandomOrderNumber: getRandomOrderNumber
		};
	}
} )();


