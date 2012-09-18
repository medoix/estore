<?php 
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: admin_login.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database  
include "../include/mysql.php"; 
$sql = mysql_query("SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>
<?php include_once("../tpl/admin_header.tpl");?>
<?php include_once("../tpl/admin_menu.tpl");?>
<div id="content">
  <h2>Hello store manager, what would you like to do today?</h2>
  <table border="0" cellspacing="0" cellpadding="0" width="100%">  
    <p>
      <a href="inventory_list.php">Manage Inventory</a><br />
      <a href="#">Manage Blah Blah </a>
    </p>
</tr>
  <tr>
    <td width="33%"></td>
    <td width="33%"></td>
    <td width="33%"></td>
  <tr>
</table>

    </div>
  </div>
  <?php include_once("../tpl/admin_footer.tpl");?>
</body>
</html>