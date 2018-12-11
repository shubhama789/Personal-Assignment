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
$MM_authorizedUsers = "2,1";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "fo2")) {
  $insertSQL = sprintf("INSERT INTO assignment (assignmentname, initialdate, finaldate, grade) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['t1'], "text"),
                       GetSQLValueString($_POST['t2'], "text"),
                       GetSQLValueString($_POST['t3'], "text"),
                       GetSQLValueString($_POST['t4'], "int"));

  mysql_select_db($database_MyConnection2, $MyConnection2);
  $Result1 = mysql_query($insertSQL, $MyConnection2) or die(mysql_error());

  $insertGoTo = "forl.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_tt = "SELECT * FROM assignment";
$tt = mysql_query($query_tt, $MyConnection2) or die(mysql_error());
$row_tt = mysql_fetch_assoc($tt);
$totalRows_tt = mysql_num_rows($tt);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="./css/style2.css">
<link href="./css/Level3_3.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<li><a href="about.php">About Us</a></li>
<!--<li><a href="<?php echo $logoutAction ?>">LogOut</a></li>-->
<div class="dropdown"><span>Welcome&nbsp;<?php 
 print_r ($_SESSION['MM_Username']);
 ?></span><div class="dropdown-content">
  <li>Lecturer</li><br>  
  <li>Admin</li><br>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li><br>
  </div></div>
</ul>
</nav>
</div>
</header>
<form action="<?php echo $editFormAction; ?>" method="POST" name="fo2">
Enter Assignment Name :
  <input name="t1" id="t1" type="text" placeholder="Enter assingnment" maxlength="20" />

<br />
Enter Intial Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type="date" name="t2" placeholder="Enter ID" id="t2" />
<br />
Final Date :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="date" name="t3" id="t3" placeholder="Enter FD" />

<br />
Grade :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type="number" name="t4" id="t4" placeholder="Enter GD"/>
<br />
<div class="container">
<div class="login-main wthree">
<input type="submit" name="button" id="button" value="Submit" /></div></div>
<br />
<input type="hidden" name="MM_insert" value="fo2" />
</form>
<center><strong><a href="lecturer.php">back</a></strong></center>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<footer>
  <p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>
</body>
</html>
<?php
mysql_free_result($tt);
?>
