<body>
<h1>Update Booking</h1>


<form action="updateBooking.php" method="post">
    
<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();
    
    $sql = "SELECT no_adults, no_child "
    . "FROM booking "
    . "WHERE ID = ?";
    
    // Prepared statement, stage 1: prepare
    $stmt = $mysqli->prepare($sql);
    // Prepared statement, stage 2: bind and execute 
    $bID = $_POST['bID']; 
    
    $stmt->bind_param('s', $bID);
    $stmt->execute();
    $stmt->bind_result($nadult,$nchild);
    
       /* fetch values */ 
    if ($stmt->fetch()) { 
        echo '<input type="hidden" name="bid" value="' . $bID . '"/>'; 
        echo '<label for="nadult">Number of Adult(s): </label>';  
        echo '<input type="number" name="nadult" value="'.$nadult.'"/><br>'; 
        echo '<label for="nchild">Number of Child(ren): </label>';  
        echo '<input type="number" name="nchild" value="'.$nchild.'"/><br>'; 
        echo '<input type="submit" name="submit" value="Continue"/>';
    } 
    else{
        echo 'Record not found'; 
    }
  
/* close statement and connection*/ 
$stmt->close(); 
$mysqli->close();
?>
      
</form>
</body>