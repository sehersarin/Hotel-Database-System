<h1>Select Desired Hotel</h1>

<form action="listAvailableRooms.php" method="post"/>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT DISTINCT name "
	. "FROM hotel "
    . "WHERE chain_name = ? ";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$chain = $_POST['chain']; 
// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('s', $chain); 
$stmt->execute();

// Bind result variables 
$stmt->bind_result($hotel_name); 

/* fetch values */ 
echo '<label for="hotel">Hotel: </label>'; 
echo '<select name="hotel">'; 
while ($stmt->fetch()) {
    printf ('<option>%s</option>', $hotel_name); 
}
echo '</select><br>'; 

echo '<input type="date" name="sDate" value="'.$startDate.'"/><br>'; 
echo '<input type="date" name="eDate" value="'.$endDate.'"/><br>'; 

/* close statement and connection*/ 
$stmt->close(); 
$mysqli->close();
?>
<br>
<input type="submit" value="Check Availability"/>

