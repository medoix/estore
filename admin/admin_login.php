<?php 
session_start();
if (isset($_SESSION["manager"])) {
    header("location: index.php"); 
    exit();
}
?>
<?php 
// Parse the log in form if the user has filled it out and pressed "Log In"
if (isset($_POST["username"]) && isset($_POST["password"])) {

	$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); // filter everything but numbers and letters
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]); // filter everything but numbers and letters
    // Connect to the MySQL database  
    include "../include/mysql.php"; 
    $sql = mysql_query("SELECT id FROM admin WHERE username='$manager' AND password='$password' LIMIT 1"); // query the person
    // ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
    $existCount = mysql_num_rows($sql); // count the row nums
    if ($existCount == 1) { // evaluate the count
	     while($row = mysql_fetch_array($sql)){ 
             $id = $row["id"];
		 }
		 $_SESSION["id"] = $id;
		 $_SESSION["manager"] = $manager;
		 $_SESSION["password"] = $password;
		 header("location: index.php");
         exit();
    } else {
		echo 'That information is incorrect, try again <a href="/">Click Here</a>';
		exit();
	}
}
?>
<?php include_once("../tpl/admin_header.tpl");?>
<?php include_once("../tpl/admin_menu.tpl");?>
<div id="content">
  <h2>Please Log In To Manage the Store</h2>
  <table border="0" cellspacing="0" cellpadding="0" width="100%">  
    <form id="form1" name="form1" method="post" action="admin_login.php">
      User Name:<br />
      <input name="username" type="text" id="username" size="40" />
      <br /><br />
      Password:<br />
      <input name="password" type="password" id="password" size="40" />
      <br />
      <br />
      <br />
      <input type="submit" name="button" id="button" value="Log In" /> 
    </form>
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