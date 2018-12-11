<?php // login.php
$hn = 'localhost';
$db = 'test2';
$un = 'root';
$pw = '';
?>
<?php
//require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

$query = "SELECT * FROM assignment";
$result = $conn->query($query);
if (!$result){echo 'failed'; die($conn->error);}
$rows = $result->num_rows;
$a=$rows;

for ($j = 0 ; $j < $rows ; ++$j)
{
$result->data_seek($j);
$row = $result->fetch_array(MYSQLI_ASSOC);
echo 'Assignment Name: ' . $row['assignmentname'] . '<br>';
echo 'Initial Date: ' . $row['initialdate'] . '<br>';
echo 'Final Date: ' . $row['finaldate'] . '<br>';
echo 'Grade: ' . $row['grade'] . '<br>';

    $assignmentname[]=$row['assignmentname'];
    $finaldate[]=$row['finaldate'];
    $grade[]=$row['grade'];

//    print_r($assignmentname);
//    print_r($finaldate);
//    print_r($grade);
}


$query = "SELECT * FROM selectoption1";
$result = $conn->query($query);
if (!$result) die($conn->error);
$rows = $result->num_rows;


for ($j = 0 ; $j < $rows ; ++$j)
{
$result->data_seek($j);
$row = $result->fetch_array(MYSQLI_ASSOC);
echo 'Roll: ' . $row['Roll'] . '<br>';
echo 'Assignment1: ' . $row['assignment1'] . '<br>';
echo 'Assignment2: ' . $row['assignment2'] . '<br>';
echo 'Assignment3: ' . $row['assignment3'] . '<br>';
echo 'Assignment4: ' . $row['assignment4'] . '<br>';
echo 'Assignment5: ' . $row['assignment5'] . '<br>';
echo 'Assignment6: ' . $row['assignment6'] . '<br>';

    $Roll[]=$row['Roll'];
    $assignment1[]=$row['assignment1'];
    $assignment2[]=$row['assignment2'];
    $assignment3[]=$row['assignment3'];
    $assignment4[]=$row['assignment4'];
    $assignment5[]=$row['assignment5'];
    $assignment6[]=$row['assignment6'];

    
    
//print_r($Roll);
//print_r($assignment1);
//print_r($assignment2);
print_r($row);
    $fill=0;
    
    $count=0;
    for($k=0;$k<$a;++$k)
    {
        echo  "<br>$assignment2[$j] and $assignmentname[$k]<br>";
       if($assignment1[$j]==$assignmentname[$k])
       {
           
    
           $assignmentsubmitted[$j][$count++]="$assignment1[$j]";
    
           $fill += $grade[$k];
       }
        
        if($assignment2[$j]==$assignmentname[$k])
       {
           
    
           $assignmentsubmitted[$j][$count++]="$assignment2[$j]";
    
           $fill += $grade[$k];
       }
        
        if($assignment3[$j]==$assignmentname[$k])
       {
           
    
           $assignmentsubmitted[$j][$count++]="$assignment3[$j]";
           
           $fill += $grade[$k];
       }
        
        if($assignment4[$j]==$assignmentname[$k])
       {
           
    
           $assignmentsubmitted[$j][$count++]="$assignment4[$j]";
           
           $fill += $grade[$k];
       }
        
        if($assignment5[$j]==$assignmentname[$k])
       {
           
    
           $assignmentsubmitted[$j][$count++]="$assignment5[$j]";
           
           $fill += $grade[$k];
       }
        
        if($assignment6[$j]==$assignmentname[$k])
       {
           
    
           $assignmentsubmitted[$j][$count++]="$assignment6[$j]";
           
           $fill += $grade[$k];
       }
        
        $totalgrade[$j]=$fill;;
        
    
    
    /*
// updating assignment submitted by student
// create a new column Roll
$query2 = "UPDATE assignment SET Roll='$fill' WHERE  branchname='$branchalloted' ";// && branch='$branchname[$k]' ) ";
$result2 = $conn->query($query2);
if (!$result) die ("Database access failed: " . $conn->error);
*/        
        $assignmentsubmitted1[0][0]="hi"." "."hello";
        echo "<br><br><hr>$fill<br>$totalgrade[$j]<br>".$assignmentsubmitted1[0][0]."<hr>";
    }
}

foreach($assignmentsubmitted as $s => $i)
{
    $text=" ";
   foreach($i as $k => $value)
   {
       $text= " $text "." $value ,";
       
   }
    $list[]=$text;
}
//print_r($list);
for($j=0;$j<$rows;++$j)
{
$query = "INSERT INTO submitted VALUES" ."('$Roll[$j]', '$list[$j]','$totalgrade[$j]')";
$result1 = $conn->query($query);
if (!$result1) echo "INSERT failed: $query<br>" .$conn->error . "<br><br>";
}
    

    //reset variable to reset the database filled and branch alloted
    //impliment using button    
    $reset=1;
    
    if($reset==1)
    {
        $query3 = "DELETE FROM submitted WHERE 1";// && branch='$branchname[$k]' ) ";
        $result3 = $conn->query($query3);
        if (!$result) die ("Database access failed: " . $conn->error);     

    /*
        $query4 =  "UPDATE branch SET filled=0 WHERE  filled<10 ";
        //ALTER columnname SET DEFAULT value";// && branch='$branchname[$k]' ) ";
        $result4 = $conn->query($query4);
        if (!$result) die ("Database access failed: " . $conn->error);     
    */
    }


//$result->close();
//$conn->close();
echo "<br><br><br>";
//print_r($rank);
//print_r($branch1);
//print_r($branch2);
//print_r($branchname);
//print_r($filled1);
print_r($assignmentsubmitted);
print_r($totalgrade);
?>
<?php
/*
foreach($assignmentsubmitted as $s => $i)
{
    $text=" ";
   foreach($i as $k => $value)
   {
       $text= " $text "." $value ,";
       
   }
    echo "<br>$text<br>";
}

for($j=0;$j<$a;++$j)
{
$option="";
switch ($option)
{
    case "Option1":
        if($filled<=$strength)
        {
            $alloted=$option1;
            $fill+=1;
        }
        break;
        
    case "Option2":
        if($filled<=$strength)
        {
            $alloted=$option1;
            $fill+=1;
        }
        break;
    
    default:
        
        break;
}
}
*/
?>