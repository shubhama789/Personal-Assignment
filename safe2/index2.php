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
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="widthdevice-width">
<meta name="description" content="affordable and professional web design">
<meta name="keywords" content="web design, affordable web design">
<meta name="author" content="Sumita">
<title>webpage design - welcome </title>
<link rel="stylesheet" href="./css/style.css">
</head>
<body>
<header>
<div class="container">

 <div id="branding">
 
  
    <h1><img src="./img/open.png" alt="logo" width="46" height="44">
    <span class="highlight">MY</span> Assignments </h1>
  
  
</div>
<nav>
<ul>
<li class="current"><a href="index.php">Home</a></li>
<li><a href="about.php">About Us</a></li>

<li><a href="<?php echo $logoutAction ?>">LogOut</a></li>
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

<section id="boxes">
<div class="container">
<div class="box">
<img src="./img/logoPending.gif">
<h3><a href="pending.php">Pending Assingments</a></h3>
<p> Submit your Pending Assignments Here</p>
</div>
<div class="box">
<img src="./img/submit.gif">
<h3><a href="submitted.php">Submitted Assignments</a></h3>
<p> You can take a look to the Assignments that you have submitted</p>
</div>
<div class="box">
<img src="./img/loading.gif">
<h3><a href="coming.php">Coming Assignments</a></h3>
<p> Here you can see the Assignments that require submission in future</p>
</div>
</div>
</section>

<footer>
<p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>



</body>
</html>