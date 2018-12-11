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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE assignment SET initialdate=%s, finaldate=%s, grade=%s WHERE assignmentname=%s",
                       GetSQLValueString($_POST['initialdate'], "text"),
                       GetSQLValueString($_POST['finaldate'], "text"),
                       GetSQLValueString($_POST['grade'], "int"),
                       GetSQLValueString($_POST['assignmentname'], "text"));

  mysql_select_db($database_MyConnection2, $MyConnection2);
  $Result1 = mysql_query($updateSQL, $MyConnection2) or die(mysql_error());

  $updateGoTo = "delta.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_dsf = "-1";
if (isset($_GET['assignmentname'])) {
  $colname_dsf = $_GET['assignmentname'];
}
mysql_select_db($database_MyConnection2, $MyConnection2);
$query_dsf = sprintf("SELECT * FROM assignment WHERE assignmentname = %s", GetSQLValueString($colname_dsf, "text"));
$dsf = mysql_query($query_dsf, $MyConnection2) or die(mysql_error());
$row_dsf = mysql_fetch_assoc($dsf);
$totalRows_dsf = mysql_num_rows($dsf);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link rel="stylesheet" href="./css/style2.css">
<link href="./css/Level3_3.css" rel="stylesheet" type="text/css" />

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
  <li>Admin</li><br>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li><br>
  </div></div>
</ul>
</nav>
</div>
</header>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Assignmentname:</td>
      <td><?php echo $row_dsf['assignmentname']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Initialdate:</td>
      <td><input type="text" name="initialdate" value="<?php echo htmlentities($row_dsf['initialdate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Finaldate:</td>
      <td><input type="text" name="finaldate" value="<?php echo htmlentities($row_dsf['finaldate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Grade:</td>
      <td><input type="text" name="grade" value="<?php echo htmlentities($row_dsf['grade'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
 <div class="container">
<div class="login-main wthree">     <td><input type="submit" value="Update record" /></td></div></div>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="assignmentname" value="<?php echo $row_dsf['assignmentname']; ?>" />
</form>
<p>&nbsp;</p>
<table border="1">
  <tr>
    <td>assignmentname</td>
    <td>initialdate</td>
    <td>finaldate</td>
    <td>grade</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_dsf['assignmentname']; ?></td>
      <td><?php echo $row_dsf['initialdate']; ?></td>
      <td><?php echo $row_dsf['finaldate']; ?></td>
      <td><?php echo $row_dsf['grade']; ?></td>
      <td>update</td>
    </tr>
    <?php } while ($row_dsf = mysql_fetch_assoc($dsf)); ?>
</table>
<center><strong><a href="lecturer.php">back</a></strong></center>

<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<footer>
  <p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>
</body>
</html>
<?php
mysql_free_result($dsf);
?>
