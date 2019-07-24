<h1>Possible Hotels</h1>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT DISTINCT hotel_name "
. "FROM room natural join type natural join hotel "
. "GROUP BY hotel_name "
. "HAVING SUM(capacity) > ?";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$numPeople = $_GET['numPeople']; 
// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('i', $numPeople); 
$stmt->execute();

$stmt->bind_result($hotel_name);

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
$mysqli->close();

?>
