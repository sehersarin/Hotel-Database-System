<h1>Update Booking</h1>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined 
include('./my_connect.php');
$mysqli = get_mysqli_conn();
// SQL statement

// SQL statement 2: updates booking based on number of adults
$sql2 = "UPDATE booking "
. "set no_adults = ? "
. "WHERE ID = ?";

//SQL statement 3
$sql3 = "UPDATE booking "
. "set no_child = ? "
. "WHERE ID = ?";


$bID = $_POST['bid']; 
$nadult = $_POST['nadult']; 
$nchild = $_POST['nchild']; 

// Prepared statement, stage 1: prepare
$stmt2 = $mysqli->prepare($sql2);
$stmt2->bind_param('is', $nadult, $bID); 

/* fetch values */ 
if ($stmt2->execute()) { 
    // Prepared statement, stage 1: prepare
    $stmt3 = $mysqli->prepare($sql3);
    $stmt3->bind_param('is', $nchild, $bID);  
    
	if ($stmt3->execute()) { 
        echo 'Booking ID # ' . $bID . ' successfully updated.';
    }
    else {
        echo 'Update not successful, please try again'; 
    }
    
} 
else {
    echo 'Update not successful, please try again'; 
}

/* close statement and connection*/  
$stmt2->close(); 
$stmt3->close(); 
$mysqli->close();
?>

<br><center><a href="index.html" class="button">Back to Home</a></br></center>