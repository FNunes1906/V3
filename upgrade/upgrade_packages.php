<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0">
<style>
body {
    color: #526066;
	background: #f7f7f7;
	font-size: 1em;
	font-family: sans-serif;
}
html {
    font-size:100%;
}
.pure-u-md-1-3{
    display: inline-block;
    vertical-align: top;
    width: 33%;
}
h2, h3 {
    letter-spacing: 0.25em;
    text-transform: uppercase;
    font-weight: 600;
}

p {
    line-height: 1.6em;
	padding: 0 5px;
}

/*
 * -- PRICING TABLE WRAPPER --
 * This element wraps up all the pricing table elements
 */
 .pricing-tables,.information {
    max-width: 980px;
    margin: 0 auto;
 }
.pricing-tables {
    margin-bottom: 3.125em;
    text-align: center;
}

/*
 * -- PRICING TABLE  --
 * Every pricing table has the .pricing-table class
 */
.pricing-table {
    border: 1px solid #ddd;
    margin: 0 0.5em 2em;
    padding: 0 0 3em;
}

/*
 * -- PRICING TABLE HEADER COLORS --
 * Choose a different color based on the type of pricing table.
 */
.pricing-table-free .pricing-table-header {
    background: #ff0000;
}

.pricing-table-biz .pricing-table-header {
    background: #ff0000;
}

/*
 * -- PRICING TABLE HEADER --
 * By default, a header is black/white, and has some styles for its <h2> name.
 */
.pricing-table-header {
    background: #ff0000;
    color: #fff;
}
.pricing-table-header h2 {
    margin: 0;
    padding-top: 2em;
    font-size: 1em;
    font-weight: normal;
}


/*
 * -- PRICING TABLE PRICE --
 * Styles for the price and the corresponding <span>per month</span>
 */
.pricing-table-price {
    font-size: 6em;
    margin: 0.2em 0 0;
    font-weight: 100;
}
.pricing-table-price span {
    display: block;
    text-transform: uppercase;
    font-size: 0.2em;
    padding-bottom: 2em;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.5);
    *color: #fff;
}



/*
 * -- PRICING TABLE LIST --
 * Each pricing table has a <ul> which is denoted by the .pricing-table-list class
 */
.pricing-table-list {
    list-style-type: none;
    margin: 0;
    padding: 0;
    text-align: center;
}

/*
 * -- PRICING TABLE LIST ELEMENTS --
 * Styles for the individual list elements within each pricing table
 */
.pricing-table-list li {
    padding: 0.8em 0;
    background: #f7f7f7;
    border-bottom: 1px solid #e7e7e7;
}

/*
 * -- PHONE MEDIA QUERIES --
 * On phones, we want to reduce the height and font-size of the banner further
 */
@media only screen and ( max-width: 974px )
{
	html
	{
		font-size: 75%; /* 12 */
	}
}
@media only screen and ( max-width: 699px )
{
  .pure-u-md-1-3{
    	width:100%;
	} 
}
</style>

</head>
<body> 

<div style="text-align: center;">
	<img width="296" height="75" title="ttown" alt="TW LOGO" src="tw_logo_icon.png"><br><br>
</div>

<!--<div class="title">Choose a plan to suit your needs and budget</div><br/><br/>-->

<div class="pricing-tables pure-g">
        <div class="pure-u-1 pure-u-md-1-3">
            <div class="pricing-table pricing-table-free">
                <div class="pricing-table-header">
                    <h2>SUPPORT</h2>

                    <span class="pricing-table-price">
                        $25 <span>per month</span>
                    </span>
                </div>
				<p>The TownWizard team is made up of highly qualified engineers with support expertise in key TownWizard technologies. Whether you need direct one-on-one support troubleshooting issues, hands-on assistance to accelerate a project, or helpful guidance to the right documentation and sample code, TownWizard support staff are ready to help you.
				<br/><br/>
				2-Pack US$25</p>
              	 <!--<form style="text-align: center;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="D3KYYUDN2ASC2">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>-->
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="GLNGLYKLU9GRG">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="support">
<input type="hidden" name="item_number" value="25">
<input type="hidden" name="amount" value="0.01">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
<input TYPE="hidden" name="return" value="http://<?php echo $_SERVER["SERVER_NAME"]?>/upgrade/thanks.php?item_name=support&payment_gross=0.01">
<input type="hidden" value="Click here to go back to site" name="cbt"> 
<!--<input type="hidden" name="notify_url" value="http://<?php echo $_SERVER["SERVER_NAME"]?>/upgrade/thanks.php" />-->
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">

</form>

            </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
            <div class="pricing-table pricing-table-biz pricing-table-selected">
                <div class="pricing-table-header">
                    <h2>Advanced</h2>

                    <span class="pricing-table-price">
                        $99 <span>per month</span>
                    </span>
                </div>

                <ul class="pricing-table-list">
					<li>Website Ad Inventory</li>
					<li>Customizable Menus</li>
					<li>Unlimited Support</li>
                </ul>
<br><br>
                <!--<form style="text-align: center;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="CNNKUQ2KVM48A">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>-->
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="GLNGLYKLU9GRG">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="advanced">
<input type="hidden" name="item_number" value="26">
<input type="hidden" name="amount" value="1.00">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
<input TYPE="hidden" name="return" value="http://<?php echo $_SERVER["SERVER_NAME"]?>/upgrade/thanks.php?item_name=advanced&payment_gross=$1">
<input type="hidden" value="Click here to go back to site" name="cbt"> 
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

            </div>
        </div>

        <div class="pure-u-1 pure-u-md-1-3">
            <div class="pricing-table pricing-table-enterprise">
                <div class="pricing-table-header">
                    <h2>Unlimited</h2>

                    <span class="pricing-table-price">
                        $249 <span>per month</span>
                    </span>
                </div>

                <ul class="pricing-table-list">
					<li>iPad App</li>
					<li>iPhone App</li>
					<li>Customizable Menus</li>
					<li>Unlimited Support</li>
					<li>Website and Apps Ad Inventory</li>
					<li>Membership to Facebook group of TW professional partners</li>
					<li>Join monthly calls where tips for managing your guide are shared</li>
					<li>Free use of the TownWizard Professional logo for marketing purposes</li>
                </ul>
				<br><br>
				<!--<form style="text-align: center;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="VXPZ7LGX5UDN4">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>-->
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="GLNGLYKLU9GRG">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="unlimited">
<input type="hidden" name="item_number" value="27">
<input type="hidden" name="amount" value="1.50">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHosted">
<input TYPE="hidden" name="return" value="http://<?php echo $_SERVER["SERVER_NAME"]?>/upgrade/thanks.php?item_name=unlimited&payment_gross=$1.50">
<input type="hidden" value="Click here to go back to site" name="cbt"> 
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
            </div>
        </div>
    </div>
</body>

</html>