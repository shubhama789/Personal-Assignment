<?php require_once('../Connections/MyConnection.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index2.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

<title>webpage design - welcome </title>
<link rel="stylesheet" href="./css/style2.css">
</head>
<body>
<header>
<div class="container">

 <div id="branding">
 
  
    <h1><img src="./img/open.png" alt="logo" width="46" height="44">
    <span class="highlight">MY</span>  Assignments </h1>
  
  
</div>
<nav>
<ul>
<li class="current"><a href="index2.php">Home</a></li>
<li><a href="about2.php">About Us</a></li>


<!--<li><a href="<?php echo $logoutAction ?>">LogOut</a></li>-->


<div class="dropdown"><span>Welcome&nbsp;<?php 
 print_r ($_SESSION['MM_Username']);
 ?></span><div class="dropdown-content">
  <li><a href="lecturer.php">Lecturer</li><br>  
  <li>Admin</li><br>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li><br>
  </div></div>
 
 
 
 
 
</div>

</ul>
</nav>
</div>
</header>

<section id="showcase">
<div class="container">
<h1>Online Assignment Submission System </h1>
<p> It is an Online portal where we can Upload , Download & Submit Our Assignments </p>
</div>

</section>

<section id="newsletter">
<div class="container">
<h1>Subscribe For Assignment Updation </h1>
<form> 
<input type="email" placeholder="Enter Email...">
<button type="submit" class="button_1">Subscribe</button> 
</form>
</div>
</section>

<center><section id="boxes">
<div class="container">
<div class="box">
<img src="./img/logoPending.gif">
<h3><a href="admi.php">Student Performance</a></h3>
<p> Submit your Pending Assignments Here</p>
</div>

</div>
</section></center>
<center><strong><a href="lecturer.php">back</a></strong></center>


<footer>
<p>Online Assignment Submission System, Copyright &copy; 2017 </p>


</footer>

</body>
</html>
<?php
mysql_free_result($register);
?>

