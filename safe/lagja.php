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
$MM_authorizedUsers = "";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE selectoption1 SET assignment1=%s, assignment2=%s, assignment3=%s, assignment4=%s, assignment5=%s, assignment6=%s WHERE email=%s",
                       GetSQLValueString($_POST['radio'], "text"),
                       GetSQLValueString($_POST['radio2'], "text"),
                       GetSQLValueString($_POST['radio3'], "text"),
                       GetSQLValueString($_POST['radio4'], "text"),
                       GetSQLValueString($_POST['radio5'], "text"),
                       GetSQLValueString($_POST['radio6'], "text"),
                       GetSQLValueString($_POST['hidden'], "text"));

  mysql_select_db($database_MyConnection2, $MyConnection2);
  $Result1 = mysql_query($updateSQL, $MyConnection2) or die(mysql_error());

  $updateGoTo = "lagja.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE selectoption1 SET assignment1=%s, assignment2=%s WHERE email=%s",
                       GetSQLValueString($_POST['radio'], "text"),
                       GetSQLValueString($_POST['radio2'], "text"),
                       GetSQLValueString($_POST['hidden'], "text"));

  mysql_select_db($database_MyConnection2, $MyConnection2);
  $Result1 = mysql_query($updateSQL, $MyConnection2) or die(mysql_error());

  $updateGoTo = "lagja.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r1 = "SELECT * FROM assignment ORDER BY assignmentname ASC";
$r1 = mysql_query($query_r1, $MyConnection2) or die(mysql_error());
$row_r1 = mysql_fetch_assoc($r1);
$totalRows_r1 = mysql_num_rows($r1);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r2 = "SELECT * FROM assignment";
$r2 = mysql_query($query_r2, $MyConnection2) or die(mysql_error());
$row_r2 = mysql_fetch_assoc($r2);
$totalRows_r2 = mysql_num_rows($r2);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r3 = "SELECT * FROM assignment";
$r3 = mysql_query($query_r3, $MyConnection2) or die(mysql_error());
$row_r3 = mysql_fetch_assoc($r3);
$totalRows_r3 = mysql_num_rows($r3);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r4 = "SELECT * FROM assignment";
$r4 = mysql_query($query_r4, $MyConnection2) or die(mysql_error());
$row_r4 = mysql_fetch_assoc($r4);
$totalRows_r4 = mysql_num_rows($r4);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r5 = "SELECT * FROM assignment";
$r5 = mysql_query($query_r5, $MyConnection2) or die(mysql_error());
$row_r5 = mysql_fetch_assoc($r5);
$totalRows_r5 = mysql_num_rows($r5);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r6 = "SELECT * FROM assignment";
$r6 = mysql_query($query_r6, $MyConnection2) or die(mysql_error());
$row_r6 = mysql_fetch_assoc($r6);
$totalRows_r6 = mysql_num_rows($r6);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="./css/style.css">
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
<li><a href="<?php echo $logoutAction ?>">LogOut</a></li>
<p>Welcome <?php 
 print_r ($_SESSION['MM_Username']);


 ?></p>
</ul>
</nav>
</div>
</header>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
<input name="hidden" type="hidden" value="<?php echo ($_SESSION['MM_Username']); ?>" />
<table width="600" border="1">
  <tr>
    <td>assign1</td>
    <td>
      <?php do { ?>
        <input type="radio" name="radio" id="i1" value="<?php echo $row_r1['assignmentname']; ?>" tabindex="1" />
        <?php echo $row_r1['assignmentname']; ?>
        <?php } while ($row_r1 = mysql_fetch_assoc($r1)); ?></td>
  
  <tr>
    <td>assign2</td>
    <td><?php do { ?>
        <input type="radio" name="radio2" id="i2" value="<?php echo $row_r2['assignmentname']; ?>" tabindex="2" />
        <?php echo $row_r2['assignmentname']; ?></label>
        <?php } while ($row_r2 = mysql_fetch_assoc($r2)); ?></td>
  <tr>
    <td>assign3</td>
    <td><?php do { ?>
        <input name="radio3" type="radio" id="i3 "value="<?php echo $row_r3['assignmentname']; ?>" tabindex="3"/>
        <?php echo $row_r3['assignmentname']; ?>
        <?php } while ($row_r3 = mysql_fetch_assoc($r3)); ?></td>
  <tr>
    <td>assign4</td>
    <td><?php do { ?>
        <input type="radio" name="radio4" id="i4" value="<?php echo $row_r4['assignmentname']; ?>" tabindex="4" />
        <?php echo $row_r4['assignmentname']; ?>
        <?php } while ($row_r4 = mysql_fetch_assoc($r4)); ?></td>
  <tr>
    <td>assign5</td>
    <td><?php do { ?>
        <input type="radio" name="radio5" id="i5" value="<?php echo $row_r5['assignmentname']; ?>" tabindex="5" />
        <?php echo $row_r5['assignmentname']; ?>
        <?php } while ($row_r5 = mysql_fetch_assoc($r5)); ?></td>
  <tr>
    <td>assign6</td>
    <td><?php do { ?>
        <input type="radio" name="radio6" id="i6" value="<?php echo $row_r6['assignmentname']; ?>" tabindex="6" />
        <label for="i6"><?php echo $row_r6['assignmentname']; ?></label>
        <?php } while ($row_r6 = mysql_fetch_assoc($r6)); ?></td>
  </table>
<br />

        
        
  </tr>
</table>
<br />
<div class="container">
<div class="login-main wthree">
<input type="submit" name="sumbit" id="sumbit" value="Submit" /></div></div>
<input type="hidden" name="MM_update" value="form1" />

</form>
</body>

<footer>
  <p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer> 


</html>
<?php
mysql_free_result($r1);

mysql_free_result($r2);

mysql_free_result($r3);

mysql_free_result($r4);

mysql_free_result($r5);

mysql_free_result($r6);
?>
