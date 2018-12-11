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
<li class="current"><a href="index.php">Home</a></li>
<li><a href="about.php">About Us</a></li>
<li><a href="register.php">Register</a></li>

<div class="dropdown">
  <span>LOGIN</span>
  <div class="dropdown-content">
  <li><a href="login.php">Student</a></li><br>
  <li><a href="login.php">Lecturer</a></li><br>  
  <li><a href="login.php">Admin</a></li><br>    
   </div></div>
</ul>
</nav>
</div>
</header>  
   <form action="" method="post" enctype="multipart/form-data">  
   <div style="width:200px;border-radius:6px;margin:0px auto">  
<table border="2"> <br>
 
   <tr>  
      <td colspan="2">Select Technolgy:</td>    
      <td>PHP</td>  
      <td><input type="checkbox" name="techno[]" value="PHP"></td>  
      <td>.Net</td>  
      <td><input type="checkbox" name="techno[]" value=".Net"></td>  
      <td>Java</td>  
      <td><input type="checkbox" name="techno[]" value="Java"></td>  
      <td>Javascript</td>  
      <td><input type="checkbox" name="techno[]" value="javascript"></td>  
   </tr>    
      <td colspan="2" align="center"><input type="submit" value="submit" name="sub"></td>  
   </tr>  
</table>  
</div>  
</form>  
<?php  
if(isset($_POST['sub']))  
{  
$host="localhost";//host name  
$username="root"; //database username  
$word="";//database word  
$db_name="test1";//database name  
$tbl_name="kanpur"; //table name  
$con=mysqli_connect("$host", "$username", "$word","$db_name")or die("cannot connect");//connection string  
$checkbox1=$_POST['techno'];  
$chk="";  
foreach($checkbox1 as $chk1)  
   {  
      $chk .= $chk1.",";  
   }  
$in_ch=mysqli_query($con,"insert into kanpur(option1) values ('$chk')");  
if($in_ch==1)  
   {  
      echo'<script>alert("Inserted Successfully")</script>';  
   }  
else  
   {  
      echo'<script>alert("Failed To Insert")</script>';  
   }  
}  
?>
<footer>
<p>Online Assignment Submission System, Copyright &copy; 2017 </p>
</footer>  
</body>  
</html>  