<?php require_once('../Connections/MyConnection.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO uitki (Name, Email, Password, Confirm_Password, Phone_Number) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Password'], "text"),
                       GetSQLValueString($_POST['C_Password'], "text"),
                       GetSQLValueString($_POST['Number'], "int"));

  mysql_select_db($database_MyConnection, $MyConnection);
  $Result1 = mysql_query($insertSQL, $MyConnection) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_MyConnection, $MyConnection);
$query_register = "SELECT * FROM uitki";
$register = mysql_query($query_register, $MyConnection) or die(mysql_error());
$row_register = mysql_fetch_assoc($register);
$totalRows_register = mysql_num_rows($register);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="widthdevice-width">
<meta name="description" content="affordable and professional web design">
<meta name="keywords" content="web design, affordable web design">
<meta name="author" content="Sumita">
<title>webpage design - register </title>
<link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
<div class="container">
 <div id="branding">
  <h1><span class="highlight">My</span> Assignments </h1>
</div>
<nav>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about.php">About Us</a></li>
<li><a href="login.php">Login</a></li>
<li class="current"><a href="register.php">Register</a></li>
</ul>
</nav>
</div>
</header>

<section id="main">
<div class="container">
<h4>Register Now</h4>
							<!--newsletter-->
							<div class="login-main wthree">
							<form name="form" action="<?php echo $editFormAction; ?>" method="POST">
								<input type="text" placeholder="Name" name="Name">
								<input type="email" placeholder="Email" required name="Email">
								<input type="password" placeholder="Password" name="Password">
								<input type="password" placeholder="Confirm Password" name="C_Password">
								<input type="text" placeholder="Phone Number" name="Number">
								<input type="submit" value="Register Now">
								<input type="hidden" name="MM_insert" value="form">
							</form>
							</div>
</section>













<footer>
<p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>



</body>
</html>
<?php
mysql_free_result($register);
?>
