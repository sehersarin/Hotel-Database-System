<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();
$mysqli2 = get_mysqli_conn();

// SQL statement
//Checks if guest is in table as phpmyadmin will approve deletions even if ID not in table.
$sql = "SELECT ID "
. "FROM guest "
. "WHERE ID = ? ";

//Deletes the guest if the guest is in the table.
$sql2 = "DELETE FROM guest "
. "WHERE ID = ? ";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$guest_ID = $_POST['guest_ID']; 

// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('i', $guest_ID);
//no binding of result as the result does not matter -- only if fetch() is true matters to ensure guest in database.

$stmt->execute();
$stmt->bind_result($guest_ID2);

if($stmt->fetch()){
    $stmt2 = $mysqli2->prepare($sql2);
    $stmt2->bind_param('i', $guest_ID2); 
    if ($stmt2->execute()) { 
        echo '<p>Guest ' . $guest_ID2 . ' deleted successfully!</p>';
     } 
    else {
        echo '<p>Guest not deleted. Please try again.</p>'; 
    }
}
else {
    echo '<p>Guest does not exist. Please try a different guest ID.</p>';
}

/* close statement and connection*/ 
$stmt->close(); 
$stmt2->close(); 
$mysqli->close();
$mysqli2->close();

?>
<br><center><a href="index.html" class="button">Back to Home</a></br></center>