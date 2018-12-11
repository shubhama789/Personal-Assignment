<?php require_once('../Connections/MyConnection.php'); ?>
<?php require_once('../Connections/MyConnection2.php'); ?>
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
$MM_authorizedUsers = "2,0,1";
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

$MM_restrictGoTo = "login.php";
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

mysql_select_db($database_MyConnection, $MyConnection);
$query_submit = "SELECT * FROM uitki";
$submit = mysql_query($query_submit, $MyConnection) or die(mysql_error());
$row_submit = mysql_fetch_assoc($submit);
$totalRows_submit = mysql_num_rows($submit);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_Recordset1 = "SELECT * FROM submitted";
$Recordset1 = mysql_query($query_Recordset1, $MyConnection2) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="widthdevice-width">
<meta name="description" content="affordable and professional web design">
<meta name="keywords" content="web design, affordable web design">

<title>webpage design - welcome </title>
<link rel="stylesheet" href="./css/style.css">
<link href="./css/Level3_3.css" rel="stylesheet" type="text/css" />
</head>  
<body>
<header>
<div class="container">

 <div id="branding">
 
  
    <h1><img src="./img/open.png" alt="logo" width="50" height="44">
    <span class="highlight">MY</span> Assignments </h1>
  </div>
<nav>
<ul>
<li class="current"><a href="index2.php">Home</a></li>
<li><a href="about2.php">About Us</a></li>
<li></li>
<div class="dropdown"><span>Welcome <?php 
 print_r ($_SESSION['MM_Username']);
 $a=$_SESSION['MM_Username'];
 $sql = "SELECT Name, Submitted FROM uitki WHERE Email = '" . $_SESSION['MM_Username'] . "'";
 $result = mysql_query($sql);
 $row = mysql_fetch_array($result);
 $query_meg3="SELECT selectoption1.assignment1,selectoption1.assignment2,selectoption1.assignment3,selectoption1.assignment4,selectoption1.assignment5,selectoption1.assignment6 FROM selectoption1 WHERE email = '" . $_SESSION['MM_Username'] . "'";
$result2 = mysql_query($query_meg3);
$row3 = mysql_fetch_array($result2);
 ?>
 </span><div class="dropdown-content">
  <li><a href="lecturer.php">Lecturer</li><br>  
  <li><a href="index3.php">Admin</a></li><br>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li><br>
  </div></div>
</ul>
</nav>
</div>
</header>
<?php echo $row3['assignment1']; ?>&nbsp;&nbsp;<?php echo $row3['assignment2']; ?>&nbsp;&nbsp;<?php echo $row3['assignment3']; ?>&nbsp;&nbsp;<?php echo $row3['assignment4']; ?>&nbsp;&nbsp;<?php echo $row3['assignment5']; ?>&nbsp;&nbsp;<?php echo $row3['assignment6']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="marks.php">MarksVSAssignmentname</a>
<center><a href="index2.php">Back</a></center>


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<footer>
  <p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>  
</body>  
</html>
<?php
mysql_free_result($register);

mysql_free_result($submit);

mysql_free_result($Recordset1);
?>
