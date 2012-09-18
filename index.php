<?php 
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
// Run a select query to get my letest 6 items
// Connect to the MySQL database  
include "include/mysql.php"; 
$dynamicList = "";
$sql = mysql_query("SELECT * FROM products ORDER BY date_added DESC LIMIT 6");
$productCount = mysql_num_rows($sql) or die($myQuery."<br/><br/>".mysql_error()); // count the output amount
if ($productCount > 0) {
  $i=0;
	while($row = mysql_fetch_array($sql)){ 
      $id = $row["id"];
			$product_name = $row["product_name"];
			$price = $row["price"];
			$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
      if ($i%3==0) {
          $dynamicList .= '</tr><tr>';
      }

      $dynamicList .= '<td valign="top">
                      <a href="product.php?id=' . $id . '" class="productTeaserLink">
                      <div class="productTeaser">
                        <div class="productTeaserImage">
                          
                          <img src="media/uploads/' . $id . '.jpg" width="220" height="180">
                          
                        </div>
                        <div class="productTeaserName">
                          ' . $product_name . '
                        </div>
                        <div class="productTeaserPrice">
                          $' . $price . '
                    
                          
                            <span class="productTeaserShipping">in stock, free shipping</span>
                          
                        </div>
                      </div>
                      </a>
                    </td>';
      $i++;
  }
} else {
	$dynamicList = "We have no products listed in our store yet";
}

mysql_close();
?>
<?php include_once("tpl/store_header.tpl");?>
<?php include_once("tpl/store_menu.tpl");?>
<div id="content">
  <h2>Featured Products</h2>
  <table border="0" cellspacing="0" cellpadding="0" width="100%">  
    <?php echo $dynamicList; ?>
</tr>
  <tr>
    <td width="33%"></td>
    <td width="33%"></td>
    <td width="33%"></td>
  <tr>
</table>

    </div>
  </div>
  <?php include_once("tpl/store_footer.tpl");?>
</body>
</html>