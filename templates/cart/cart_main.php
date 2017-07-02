<form id="CustomToyGunsOrder" target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="pcdoctormario@gmail.com">
    <input type="hidden" id="item_name_1" name="item_name_1" value="Order Number: {order_num}">
    <input type="hidden" name="amount_1" value="0">
    <input type="hidden" id="shipping" name="shipping_1" value="">
    <input value="0" name="weight" id="weight" type="hidden">
    <input type="hidden" name="address_override" value="1">
    <input type="hidden" name="first_name" id="first_name" value="">
    <input type="hidden" name="last_name" id="last_name" value="">
    <input type="hidden" name="address1" id="address1" value="">
    <input type="hidden" name="city" id="city" value="">
    <input type="hidden" name="state" id="state" value="">
    <input type="hidden" name="zip" id="zip" value="">
    <input type="hidden" name="country" value="US">
    <table class="order_table">
        {content}
    </table>
    <h2 class="center-content">Enter shipping address &amp; click the "Get Total" button below</h2>
    <div class="order_table">
        <div class="input-group">
            <label>First name </label><br>
            <input id="first_name_input" type="text" placeholder="John" required>
        </div>
        <div class="input-group">
            <label>Last name </label><br>
            <input id="last_name_input" type="text" placeholder="Goodman" required>
        </div>
        <div class="input-group">
            <label>Street </label><br>
            <input id="address1_input" type="text" placeholder="1240 Earl Drive" required>
        </div>
        <div class="input-group">
            <label>City </label><br>
            <input id="city_input" type="text" placeholder="San Diego" required>
        </div>
        <div class="input-group">
            <label>State </label><br>
			<select class="form-control" name="shipping_state_select" size="1" id="state_input" required>
				<option value=""></option>
				<option value="AL">AL Alabama</option>
				<option value="AK">AK Alaska</option>
				<option value="AZ">AZ Arizona</option>
				<option value="AR">AR Arkansas</option>
				<option value="CA">CA California</option>
				<option value="CO">CO Colorado</option>
				<option value="CT">CT Connecticut</option>
				<option value="DE">DE Delaware</option>
				<option value="DC">DC District Of Columbia</option>
				<option value="FL">FL Florida</option>
				<option value="GA">GA Georgia</option>
				<option value="HI">HI Hawaii</option>
				<option value="ID">ID Idaho</option>
				<option value="IL">IL Illinois</option>
				<option value="IN">IN Indiana</option>
				<option value="IA">IA Iowa</option>
				<option value="KS">KS Kansas</option>
				<option value="KY">KY Kentucky</option>
				<option value="LA">LA Louisiana</option>
				<option value="ME">ME Maine</option>
				<option value="MD">MD Maryland</option>
				<option value="MA">MA Massachusetts</option>
				<option value="MI">MI Michigan</option>
				<option value="MN">MN Minnesota</option>
				<option value="MS">MS Mississippi</option>
				<option value="MO">MO Missouri</option>
				<option value="MT">MT Montana</option>
				<option value="NE">NE Nebraska</option>
				<option value="NV">NV Nevada</option>
				<option value="NH">NH New Hampshire</option>
				<option value="NJ">NJ New Jersey</option>
				<option value="NM">NM New Mexico</option>
				<option value="NY">NY New York</option>
				<option value="NC">NC North Carolina</option>
				<option value="ND">ND North Dakota</option>
				<option value="OH">OH Ohio</option>
				<option value="OK">OK Oklahoma</option>
				<option value="OR">OR Oregon</option>
				<option value="PA">PA Pennsylvania</option>
				<option value="RI">RI Rhode Island</option>
				<option value="SC">SC South Carolina</option>
				<option value="SD">SD South Dakota</option>
				<option value="TN">TN Tennessee</option>
				<option value="TX">TX Texas</option>
				<option value="UT">UT Utah</option>
				<option value="VT">VT Vermont</option>
				<option value="VA">VA Virginia</option>
				<option value="WA">WA Washington</option>
				<option value="WV">WV West Virginia</option>
				<option value="WI">WI Wisconsin</option>
				<option value="WY">WY Wyoming</option>
			</select>
        </div>
        <div class="input-group">
            <label>Zipcode </label><br>
            <input id="zip_input" type="text" size="9" placeholder="92154" required>
        </div>
		<br>
        <div class="center-content">
            <button type="button" class="btn btn-default" onclick="Cart.getTotal();
					return false;">Get Total</button>
        </div>
    </div>
    <div class="order_table center-content">
	<div>Sub Total: ${sub_total}</div>
        <div id="shipping_cost_span" ></div>
        <div id="total_span"></div>
	</div>
	<div class="center-content">
        <button type="button" class="btn btn-default btn_order" onclick="Cart.orderSubmit();">
			<i class="material-icons large-40">security</i><br>Secure<br>Checkout
		</button>
	</div>
    <p>&nbsp;</p>
</form>

