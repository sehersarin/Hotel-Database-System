<h1>Update Booking</h1>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined 

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT DISTINCT no_adults, no_child "
. "FROM booking "
. "WHERE booking.ID = ?";

// SQL statement 2: updates booking based on number of adults
$sql2 = "UPDATE booking "
. "set no_adults = ? "
. "WHERE ID = ?";

//SQL statement 3
$sql3 = "UPDATE booking "
. "set no_children = ? "
. "WHERE ID = ?";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$bID = $_POST['bID']; 
$nadult = $_POST['nadult']; 
$nchild = $_POST['nchild']; 

// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('s', $bID);
$stmt->bind_param('i', $nadult); 
$stmt->bind_param('i', $nchild);  

$stmt->execute();

$stmt->bind_result($no_adults,$no_children);

echo '<ul>';

/* fetch values */ 
if ($stmt->fetch()) { 
    do {
        printf('<li>%s</li>', $hotel_name);
    } while($stmt->fetch());
} 
else {
    echo 'Record not found'; 
}
echo '</ul>';

/* close statement and connection*/ 
$stmt->close(); 
$stmt2->close(); 
$stmt3->close(); 
$mysqli->close();

?>
