( function(){
	angular.module( 'cheapNerfToyGunPartsApp' ).directive( 'menuTemplate', menuTemplateFunction );
	angular.module( 'cheapNerfToyGunPartsApp' ).directive( 'gunsTemplate', gunsTemplateFunction );
	angular.module( 'cheapNerfToyGunPartsApp' ).directive( 'shoppingCartTemplate', shoppingCartTemplateFunction );
	function menuTemplateFunction(){
		var directive = {
			link: link,
			templateUrl: './templates/menu-template.html',
			restrict: 'EA'
		};
		return directive;
		function link( scope, element, attrs ){
			/* */
			//console.log( element.children().prevObject[0].children );
		}
	}
	function gunsTemplateFunction(){
		var directive = {
			link: link,
			templateUrl: './templates/guns-template.html',
			restrict: 'EA'
		};
		return directive;
		function link( scope, element, attrs ){
			/* */
			//console.log( element.children().prevObject[0].children );
		}
	}
	function shoppingCartTemplateFunction(){
		var directive = {
			link: link,
			templateUrl: './templates/cart/cart_main.php',
			restrict: 'EA'
		};
		return directive;
		function link( scope, element, attrs ){
			/* */
			//console.log( element.children().prevObject[0].children );
		}
	}
} )();


