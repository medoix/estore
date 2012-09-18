<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Home Page</title>
<link rel="stylesheet" href="media/css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="media/css/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
  <script type="text/javascript" charset="utf-8" src="media/js/jquery-1.5.1.min.js"></script>
  <script type="text/javascript" charset="utf-8" src="media/js/ecart.js"></script>
  <script type="text/javascript" charset="utf-8" src="media/js/jquery.fancybox-1.3.4.pack.js"></script>
</head>
<body>
	<div id="header">
		<div class="constrainWidth">
			<div id="searchContainer">
				<!--
				<form action="/search/" method="get" accept-charset="utf-8">
					<input type="text" name="q" value="" id="search" placeholder="Search our products...">
				</form>
				<br />
				-->
				<form action="cart.php" method="get" accept-charset="utf-8">
					<input type="submit" value="Trolley (0 items)" id="trolleyButton" class="trolleyButton">
				</form>
			</div>
			<a href="/"><img src="media/images/logo.png" alt="Logo" border="0" id="logo"></a>
		</div>
	</div>