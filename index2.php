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

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_register = "SELECT * FROM selectoption1";
$register = mysql_query($query_register, $MyConnection2) or die(mysql_error());
$row_register = mysql_fetch_assoc($register);
$totalRows_register = mysql_num_rows($register);

mysql_select_db($database_MyConnection2, $MyConnection2);
$query_r2 = "SELECT * FROM submitted";
$r2 = mysql_query($query_r2, $MyConnection2) or die(mysql_error());
$row_r2 = mysql_fetch_assoc($r2);
$totalRows_r2 = mysql_num_rows($r2);


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
  $a=$_SESSION['MM_Username'];
 $query_meg = "SELECT selectoption1.Roll FROM selectoption1 WHERE email = '" . $_SESSION['MM_Username'] . "'";
$result = mysql_query($query_meg);
$row = mysql_fetch_array($result);
$query_meg2="SELECT submitted.totalgrade FROM submitted WHERE submitted.Roll='".$row['Roll']."'";
$result1 = mysql_query($query_meg2)or die($query_meg2."<br/><br/>".mysql_error());
$row2 = mysql_fetch_array($result1);
//$query_meg3="SELECT selectoption1.assignment1,selectoption1.assignment2,selectoption1.assignment3,selectoption1.assignment4,selectoption1.assignment5,selectoption1.assignment6 FROM selectoption1 WHERE email = '" . $_SESSION['MM_Username'] . "'";
//$result2 = mysql_query($query_meg3)or die($query_meg3."<br/><br/>".mysql_error());;
//$row3 = mysql_fetch_array($result2);
 
 ?>
 
 
 
 
 
 
 
 
 </span><div class="dropdown-content">
  <li><a href="lecturer.php">Lecturer</li><br>  
  <li><a href="index3.php">Admin</a></li><br>
  <li><a href="<?php echo $logoutAction ?>">Logout</a></li><br>
  </div></div>
 
 
 
 
 
</div>

</ul>
</nav>
</div>
</header>

<section id="showcase">
<div class="container">
<br/>
My Roll No : <?php echo $row['Roll']; ?><br>
My Grade : <?php echo $row2['totalgrade']; ?>/100<br>
<!--My Submitted ass : <?php echo $row3['assignment1']; ?>&nbsp;&nbsp;<?php echo $row3['assignment2']; ?>&nbsp;&nbsp;<?php echo $row3['assignment3']; ?>&nbsp;&nbsp;<?php echo $row3['assignment4']; ?>&nbsp;&nbsp;<?php echo $row3['assignment5']; ?>&nbsp;&nbsp;<?php echo $row3['assignment6']; ?>-->
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

<section id="boxes">
<div class="container">
<div class="box">
<img src="./img/logoPending.gif">
<h3><a href="lagja.php">Pending Assingments</a></h3>
<p> Submit your Pending Assignments Here</p>
</div>
<div class="box">
<img src="./img/submit.gif">
<h3><a href="sub.php">Submitted Assignments</a></h3>
<p> You can take a look to the Assignments that you have submitted</p>
</div>
<div class="box">
<img src="./img/loading.gif">
<h3><a href="aic.php">All India Comparision</a></h3>
<p>Brush your skilsl &amp; get motivated</p>
</div>
</div>
</section>
<br/>

<footer>
<p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>

</body>
</html>
<?php
mysql_free_result($register);

mysql_free_result($r2);
?>

