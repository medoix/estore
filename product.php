<?php 
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
	// Connect to the MySQL database  
    include "include/mysql.php"; 
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the product 
	// details, if no then exit this script and give message why
	$sql = mysql_query("SELECT * FROM products WHERE id='$id' LIMIT 1");
	$productCount = mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysql_fetch_array($sql)){ 
			 $product_name = $row["product_name"];
			 $price = $row["price"];
			 $details = $row["details"];
			 $category = $row["category"];
			 $subcategory = $row["subcategory"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
         }
		 
	} else {
		echo "That item does not exist.";
	    exit();
	}
		
} else {
	echo "Data to render this page is missing.";
	exit();
}
mysql_close();
?>
<?php include_once("tpl/store_header.tpl");?>
<?php include_once("tpl/store_menu.tpl");?>
<div id="content">
  <h2><?php echo $product_name; ?></h2>

<!--
  <table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <td width="19%" valign="top"><img src="inventory_images/<?php echo $id; ?>.jpg" width="142" height="188" alt="<?php echo $product_name; ?>" /><br />
      <a href="inventory_images/<?php echo $id; ?>.jpg">View Full Size Image</a></td>
    <td width="81%" valign="top"><h3><?php echo $product_name; ?></h3>
      <p><?php echo "$".$price; ?><br />
        <br />
        <?php echo "$subcategory $category"; ?> <br />
<br />
        <?php echo $details; ?>
<br />
        </p>
      <form id="form1" name="form1" method="post" action="cart.php">
        <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
        <input type="submit" name="button" id="button" value="Add to Shopping Cart" />
      </form>
      </td>
    </tr>
</table>
  </div>
-->
<div class="productInfo">
  <div class="productImage">
    
    <a href="media/uploads/<?php echo $id; ?>.jpg" class="lightbox" rel="productImages"><img src="media/uploads/<?php echo $id; ?>.jpg" width="320" border="0"></a>
    
  </div>
  <div class="productImages">
    <a href="media/uploads/<?php echo $id; ?>.jpg" class="lightbox" rel="productImages"><img src="media/uploads/<?php echo $id; ?>.jpg" height="55" border="0"></a>
    <a href="media/uploads/<?php echo $id; ?>.jpg" class="lightbox" rel="productImages"><img src="media/uploads/<?php echo $id; ?>.jpg" height="55" border="0"></a>
  </div>
  <br />
  <div class="productPrice">
    <?php echo "$".$price; ?>
  </div>
  <div class="productBuyNow">
    <form action="cart.php" method="post" accept-charset="utf-8" OnSubmit="return doAddCart( this );">
      <input type="hidden" name="pid" value="<?php echo $id; ?>" id="pid">
      
      <!--
      ### IF VARIATIONS ###
      <div class="productVariations">
        <select name="variation" class="subtleDropdown">
          
          <option value="LED10D-25-MIX">Mixed colours $10.00 (LED10D-25-MIX)</option>
          
          <option value="LED10D-25-RED">Red only $7.00 (LED10D-25-RED)</option>
          
          <option value="LED10D-25-YEL">Yellow only $7.00 (LED10D-25-YEL)</option>
          
          <option value="LED10D-25-BLU">Blue only $7.20 (LED10D-25-BLU)</option>
          
          <option value="LED10D-25-WHT">White only $10.00 (LED10D-25-WHT)</option>
          
          <option value="LED10D-25-GRN">Green only $11.00 (LED10D-25-GRN)</option>
          
        </select>
      </div>
      -->
      
      <!--
      ### NEED TO ADD QTY TYPE PACK OR PIECE etc ###
      -->
      <input type="text" name="quantity" value="1" id="quantity" size="1" style="text-align: center;"> piece
      &nbsp;
      <span style="position: relative;">
      <input type="submit" value="Buy Now" class="buyButton">
      </span>
    </form>
  </div>
  <div class="productShipping">
    <!--
    ### NEED TO ADD SHIPPING COSTS ###
    -->
    <img src="/media/images/icons/package_go.png" align="absmiddle"> <b class="green">Free Shipping</b> to Australia
  </div>
  <div class="productStock">
    
    <img src="/media/images/icons/au.png" align="absmiddle"> 
      <!--
      ### NEED TO ADD STOCK COUNT ###
      -->
      more than 10 in stock, ready to ship
    
  </div>
</div>

<div class="productDescription">
  <?php echo $details; ?>
</div>


    </div>
  </div>
  <?php include_once("tpl/store_footer.tpl");?>
</div>
</body>
</html>