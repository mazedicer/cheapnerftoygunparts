angular.module( 'cheapNerfToyGunPartsApp', [ ] );
( function(){
	angular.module( 'cheapNerfToyGunPartsApp' ).filter( 'gunCategory', gunCategoryFunction );
	angular.module( 'cheapNerfToyGunPartsApp' ).controller( 'mainController', mainControllerFunction );
	function mainControllerFunction( $scope, Guns, RandomOrderNumber ){
		$scope.categories = categories; //categories.js array of categories
		$scope.instock_categories = [ ]; //array to be filled with in-stock categories
		$scope.guns = false;//will become array with gun objects {name, id, price, stock, ...}
		$scope.view_menu = true; //for show/hide buttons menu
		$scope.view_cart = false; //for show/hide shopping cart
		$scope._category; //filters results when user clicks a menu button
		$scope.order = [ ]; //keeps track of user order
		$scope.order_number = ""; //stores generated number from process_cart.php
		$scope.sub_total = 0; //cart sub total
		$scope.weight = 0; //cart total shipping weight
		if( $scope.guns === false ){
			Guns.getGuns().then( setGuns );
		}
		$scope.getCategoryItems = function( category ){
			//cb menu button sets the filter to a specific category
			$scope._category = category;
			$scope.showHideMenu();
		};
		$scope.addToCart = function( gun ){
			//cb "add to cart" item button
			RandomOrderNumber.getRandomOrderNumber().then( setOrderNumber );
			addToCart( gun );
		};
		$scope.removeFromCart = function( id ){
			removeFromCart( id );
		};
		$scope.getTotal = getTotal;
		$scope.orderSubmit = orderSubmit;
		function addToCart( id ){
			$scope.view_cart = true;
			var incart = checkCart( id );
			if( incart == false ){
				addGun( id );
			}else{
				addQty( id );
			}
			updateCart();
			function checkCart( id ){
				/*  called by addToCart()
				 *  checks order array if object with given id exsists
				 *  returns true/false */
				if( $scope.order.length < 1 ){
					return false;
				}else{
					for( var i = 0; i < $scope.order.length; i++ ){
						if( id == $scope.order[ i ].id ){
							return true;
						}//if
					}//for
				}//if
				return false;
			}
			function addGun( id ){
				/* called by addToCart()
				 * adds gun object into order array with the given id */
				var gun_obj = returnGunObj( id );
				$scope.order.push( gun_obj );
				function returnGunObj( id ){
					/* called by addGun()
					 * with the given id, returns the gun object from the guns.js library */
					for( var i = 0; i < $scope.guns.length; i++ ){
						if( id == $scope.guns[ i ].id ){
							return $scope.guns[ i ];
						}
					}
				}
			}
			function addQty( id ){
				/* called by addToCart()
				 * adds to gun object's order attribute in the order array with the given id */
				for( var i = 0; i < $scope.order.length; i++ ){
					if( id == $scope.order[ i ].id ){
						var item_index = i;
						$scope.order[ i ].order += 1;
						// alert( JSON.stringify( order[i] ) );
					}
				}
				if( $scope.order[ item_index ].order > $scope.order[ item_index ].stock ){
					$scope.order[ item_index ].order = $scope.order[ item_index ].stock;
				}
			}
		}
		function removeFromCart( id ){
			console.log( "removeFromCart" );
			var qty = checkQty( id );
			if( qty > 0 ){
				minusQty( id );
			}else{
				removeGun( id );
			}//if
			updateCart();
			function checkQty( id ){
				/* called by removeFromCart()
				 * checks the order attribute of the gun object
				 *  returns the value */
				for( var i = 0; i < $scope.order.length; i++ ){
					if( id == $scope.order[ i ].id ){
						return $scope.order[ i ].order;
					}
				}
			}
			function minusQty( id ){
				/* called by removeFromCart()
				 * substracts from the order attribute of the gun object  */
				for( var i = 0; i < $scope.order.length; i++ ){
					if( id == $scope.order[ i ].id ){
						$scope.order[ i ].order -= 1;
						console.log( JSON.stringify( $scope.order[i] ) );
					}
				}
			}
			function removeGun( id ){
				/* called by removeFromCart()
				 * removes the gun object from the order array */
				for( var i = 0; i < $scope.order.length; i++ ){
					if( id == $scope.order[ i ].id ){
						$scope.order.splice( i, 1 );
						break;
					}
				}
				if( $scope.order.length < 1 ){
					if( localStorage.getItem( "myorder" ) !== null ){
						localStorage.removeItem( "myorder" );
					}
				}
			}
		}
		function updateCart(){
			/* update localstorage, 
			 * if order is empty and localstorage is not empty, fill order with localstorage */
			clearShipAndTotal();
			setWeightAndSubTotal();
			updateLocalStorage();
			if( $scope.order.length < 1 && localStorage.getItem( "myorder" ) !== null ){
				$scope.order = JSON.parse( localStorage.getItem( "myorder" ) );
			}
			var cart = JSON.stringify( $scope.order );
			function updateLocalStorage(){
				/* called by updateCart()
				 * if  order is not empty, fill localstorage with order */
				if( $scope.order.length > 0 ){
					if( localStorage.getItem( "myorder" ) !== null ){
						localStorage.removeItem( "myorder" );
					}
					localStorage.setItem( "myorder", cart );
				}
			}
			function setWeightAndSubTotal(){
				var weight = 0;
				var sub_total = 0;
				angular.forEach( $scope.order, function( value, key ){
					weight = weight + ( value.weight * value.order );
					sub_total = sub_total + ( value.price * value.order );
				} );
				$scope.weight = weight;
				$scope.sub_total = sub_total;
			}
		}
		function getTotal(){
			$( "#first_name" ).val( $( "#first_name_input" ).val() );
			$( "#last_name" ).val( $( "#last_name_input" ).val() );
			$( "#address1" ).val( $( "#address1_input" ).val() );
			$( "#city" ).val( $( "#city_input" ).val() );
			$( "#state" ).val( $( "#state_input" ).val() );
			$( "#zip" ).val( $( "#zip_input" ).val() );
			var cart = JSON.stringify( $scope.order );
			$.ajax(
					{
						type: 'POST',
						cache: false,
						data: { cart: cart, zip: $( "#zip_input" ).val() },
						url: 'process/process_cart.php',
						success: function( data, status, xml ){
							//console.log( data );
							displayTotal( data );
						}
					}
			);
			function displayTotal( data ){
				if( data.indexOf( "|" ) === 0 ){
					alert( "Error Connecting to Shipping Service!\nMake sure you entered valid information." );
				}else{
					var ship_and_total = data.split( "|" );
					$( "#shipping" ).val( ship_and_total[ 0 ] );
					$( "#shipping_cost_span" ).html( "Shipping: $" + ship_and_total[ 0 ] );
					$( "#total_span" ).html( "Total: $" + ship_and_total[ 1 ] );
					$( "#order_submit" ).removeClass( "hide" );
				}
			}
		}
		function clearShipAndTotal(){
			$( "#shipping_cost_span" ).html( "" );
			$( "#total_span" ).html( "" );
			$( "#order_submit" ).addClass( "hide" );
		}
		function orderSubmit(){
			var valid = true;
			var required_array = [ $( "#first_name" ), $( "#last_name" ), $( "#address1" ), $( "#city" ), $( "#state" ), $( "#zip" ) ];
			required_array.forEach( validateFields );
			if( valid === false ){
				alert( "Please enter shipping information and click\nGet Total button" );
			}else{
				document.getElementById( 'CustomToyGunsOrder' ).submit();
			}
			function validateFields( item ){
				if( item.val() === "" ){
					valid = false;
				}
			}
		}
		function setGuns( response ){
			//if $scope.guns = false
			$scope.guns = response.data;
			$scope._category = $scope.guns[0];
			returnOutOfStock();
		}
		function setOrderNumber( response ){
			$scope.order_number = response.data;
		}
		function returnOutOfStock(){
			//cb setGuns(), sets the array with in-stock categories
			for( var i = 0; i < $scope.guns.length; i++ ){
				var current_category = $scope.guns[ i ].category;
				if( $scope.instock_categories.indexOf( current_category ) >= 0 ){
					continue;
				}
				$scope.instock_categories.push( current_category );
			}
		}
		$scope.showHideMenu = function(){
			//shows/hide menu buttons
			$scope.view_menu = $scope.view_menu ? false : true;
		};
		$scope.toggleCartView = function(){
			$scope.view_cart = $scope.view_cart ? false : true;
		};
		$scope.menuButtonClass = function( category ){
			//defines the active/inactive menu buttons class
			if( $scope.instock_categories.indexOf( category ) < 0 ){
				return "btn btn-default disabled";
				;
			}
			return "btn btn-default";
			;
		};
	}
	function gunCategoryFunction(){
		//cb the gunCategory filter (guns-template.html), returns array of gun objects
		return function( array_of_guns, filter_query ){
			if( !array_of_guns )
				return array_of_guns;
			if( !filter_query )
				return array_of_guns;
			var expected = ( '' + filter_query ).toLowerCase();
			var result = [ ];
			angular.forEach( array_of_guns, function( value, key ){
				var actual = ( '' + value.category ).toLowerCase();
				if( actual === expected ){
					result.push( array_of_guns[key] );
				}
			} );
			return result;
		};
	}
} )();


