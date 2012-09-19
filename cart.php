<?php 
// Connect to the MySQL database  
include "include/common.php"; 
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 1 (if user attempts to add something to the cart from the product page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
	$wasFound = false;
	$i = 0;
	// If the cart session variable is not set or cart array is empty
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) { 
	    // RUN IF THE CART IS EMPTY OR NOT SET
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	} else {
		// RUN IF THE CART HAS AT LEAST ONE ITEM IN IT
		foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $pid) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					  $wasFound = true;
				  } // close if condition
		      } // close while loop
	       } // close foreach loop
		   if ($wasFound == false) {
			   array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		   }
	}
	header("location: cart.php"); 
    exit();
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 2 (if user chooses to empty their shopping cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code
	$item_to_adjust = $_POST['item_to_adjust'];
	$quantity = $_POST['quantity'];
	$quantity = preg_replace('#[^0-9]#i', '', $quantity); // filter everything but numbers
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $item_to_adjust) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				  } // close if condition
		      } // close while loop
	} // close foreach loop
	header("location: cart.php");
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 4 (if user wants to remove an item from cart)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove that array index
 	$key_to_remove = $_POST['index_to_remove'];
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
	header("location: cart.php");
}
?>
<?php 
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (render the cart for the user to view on the page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn = '';
$product_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
	// Start PayPal Checkout Button
	$pp_checkout_btn .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="medoix@gmail.com">';
	// Start the For Each loop
	$i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = mysql_query("SELECT * FROM products WHERE id='$item_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$product_name = $row["product_name"];
			$price = $row["price"];
			$details = $row["details"];
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;
		setlocale(LC_MONETARY, "en_US");
        $pricetotal = money_format("%i", $pricetotal);
		// Dynamic Checkout Btn Assembly
		$x = $i + 1;
		$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
		// Create the product array variable
		$product_id_array .= "$item_id-".$each_item['quantity'].","; 
		// Dynamic table row assembly
		$cartOutput .= "<tr>";
		$cartOutput .= '<td><a href="product.php?id=' . $item_id . '">' . $product_name . '</a></td>';
		$cartOutput .= '<td><form action="cart.php" method="post">
		<input name="quantity" id="quantity' . $item_id . '" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" />
		<input name="adjustBtn" id="adjustBtn' . $item_id . '" type="submit" value="change" hidden="true" />
		<input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
		</form></td>';
		$cartOutput .= '<td><span style="color: #0a0;">in stock</span></td>';
		//$cartOutput .= '<td>' . $details . '</td>';
		//$cartOutput .= '<td align="right">$' . $price . '</td>';
		//$cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
		$cartOutput .= '<td align="right">$' . $pricetotal . '';
		if($each_item['quantity'] > 1) {
			$cartOutput .= '<div style="color: #999; font-size: 80%;">($' . $price . ' each)</div>';
		}
		$cartOutput .= '</td>';
		$cartOutput .= '<td align="center"><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" /><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
		$cartOutput .= '</tr>';
		$i++; 
    } 
	setlocale(LC_MONETARY, "en_US");
    $cartTotal = money_format("%10.2n", $cartTotal);
	$cartTotal = "<div>Cart Total: $".$cartTotal."</div>";
    // Finish the Paypal Checkout Btn
	$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
	<input type="hidden" name="notify_url" value="https://www.shivv.com/include/paypal_ipn.php">
	<input type="hidden" name="return" value="https://www.shivv.com/include/paypal_complete.php">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Return to The Store">
	<input type="hidden" name="cancel_return" value="https://www.shivv.com/include/paypal_cancel.php">
	<input type="hidden" name="lc" value="AU">
	<input type="hidden" name="currency_code" value="AUD">
	<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
	</form>';
}
$page_title = "Cart";
$current_page = "cart";
?>
<?php include_once("tpl/store_header.tpl");?>
<?php include_once("tpl/store_menu.tpl");?>
<div id="content">
			
<h2>Your Shopping Trolley</h2>

<div class="pageContent">
	<!--<form action="cart.php" method="post" accept-charset="utf-8">-->
		<table border="0" cellspacing="0" cellpadding="5" width="100%" class="trolleyTable">
			<thead>
				<tr>
					<th align="left">Product</th>
					<th align="left">Quantity</th>
					<th align="left">Stock</th>
					<!--<th align="right">Price</th>-->
					<th align="right">Subtotal</th>
					<th align="left">Remove</th>
				</tr>
			</thead>
			<tbody>
				<?php echo $cartOutput; ?>
			</tbody>
			
			<tfoot>
				<tr>
					<td></td>
					<td align="right" colspan="3"><?php echo $cartTotal; ?></td>
					<td><?php echo $pp_checkout_btn; ?></td>
				</tr>
			</tfoot>
			
		</table>
		<!--
		<a href="cart.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
		-->
	<!--</form>-->
</div>
		</div>
	</div>
  <?php include_once("tpl/store_footer.tpl");?>
</div>
</body>
</html>