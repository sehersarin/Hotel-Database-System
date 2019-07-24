<body>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT count(*) "
    . "FROM room "
    . "WHERE suite_no not in (SELECT suite_no "
        . "FROM books "
        . "WHERE hotel_name = ? and booking_ID in (SELECT ID "
            . "FROM booking " 
            . "WHERE start_date >= ? and end_date <= ?)) "
    . "and hotel_name = ? "
    . "and classification = ? ";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// (2) Handle GET parameters; aid is the name of the hidden textbox in the previous page
$hotel_name = $_POST['hotel']; 
$sDate = $_POST['sDate'];
$eDate = $_POST['eDate'];
    
$type=array();

$mysqli2 = get_mysqli_conn();

// SQL statement to get all different types of rooms.
$sqlTypes = "SELECT DISTINCT classification "
	. "FROM type ";

// Prepared statement, stage 1: prepare
$stmtTypes = $mysqli2->prepare($sqlTypes);
$stmtTypes->execute();

// Bind result variables 
$stmtTypes->bind_result($classification); 
    
//Initialize the type array with the different room types.
while ($stmtTypes->fetch()) {
    $type[] = $classification;
}
    
//Loop through the type arrays and print the available rooms under each type.
for ($index = 0; $index < count($type); $index++){
     // (3) "i" for integer, "d" for double, "s" for string, "b" for blob 
    $stmt->bind_param('sssss', $hotel_name, $sDate, $eDate, $hotel_name, $type[$index]); 
    $stmt->execute();
    // Bind result variables 
    $stmt->bind_result($no_rooms); 

    /* fetch values */ 
    if ($stmt->fetch()) { 
        echo 'Number of available ' . $type[$index].' rooms at ' . $hotel_name . ' for '.$sDate . ' to ' . $eDate . ' is: ' . $no_rooms . '<br>'; 
    } 
    else {
        echo 'No available rooms at this hotel of type '. $type .'. Please try again.'; 
    }
}   
    
$stmt->close(); 
$mysqli->close();
?>

<p>
<a href="index.php">Return to Home page</a>
</p>
</body>
