<?php require_once('../Connections/MyConnection2.php'); ?>
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

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_login = "SELECT * FROM super";
$login = mysql_query($query_login, $MyConnection2) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);
$totalRows_login = mysql_num_rows($login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['Email'])) {
  $loginUsername=$_POST['Email'];
  $password=$_POST['Password'];
  $MM_fldUserAuthorization = "ac_l";
  $MM_redirectLoginSuccess = "index2.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_MyConnection2, $MyConnection2);
  	
  $LoginRS__query=sprintf("SELECT email, password, ac_l FROM selectoption1 WHERE email=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $MyConnection2) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'ac_l');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="widthdevice-width">
<meta name="description" content="affordable and professional web design">
<meta name="keywords" content="web design, affordable web design">

<title>webpage design - login </title>
<link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
<div class="container">
 <div id="branding">
  <h1><span class="highlight">My</span> Assingments </h1>
</div>
<nav>
<ul>
<li><a href="index.php">Home</a></li>
<li><a href="about.php">About Us</a></li>
<li class="current"><a href="login.php">Login</a></li>
<li><a href="register.php">Register</a></li>

</ul>
</nav>
</div>
</header>


<section id="main">
<div class="container">
<div class="login-main wthree">
							  <form action="<?php echo $loginFormAction; ?>" name="form" method="POST">
								<p>
								  <input type="email" placeholder="Email" required name="Email">
								  <input type="password" placeholder="Password" name="Password">
								  <input type="submit" name="login" value="Login">
								</p>
								<p>NOT A MEMBER ? <a href="register.php">REGISTER</a></p>
					        </form>
							</div>



</div>
</section>



<br>  
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br><br>
<footer>
<p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>



</body>
</html>
<?php
mysql_free_result($login);
?>
