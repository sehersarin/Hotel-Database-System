<h1>Update Aircraft's Name</h1>

<form action="update_aircraft.php" method="get"/>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT a.aid, a.aname "
. "FROM aircraft a "
. "WHERE a.aid = ?";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$aid = $_GET['aid']; 
// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('i', $aid); 
$stmt->execute();

// Bind result variables 
$stmt->bind_result($aircraft_id, $aircraft_name); 

/* fetch values */ 
if ($stmt->fetch()) 
{ 
echo '<input type="hidden" name="aid" value="' . $aircraft_id . '"/>'; 
echo '<label for="aname">Update Name for Aircraft #' . $aircraft_id . ', currently named '.$aircraft_name.' to: </label>'; 
echo '<input type="text" name="aname" value="'.$aircraft_name.'"/><br>'; 
} 
else
{
echo '<label for="aname">Record not found</label>'; 
}
/* close statement and connection*/ 
$stmt->close(); 
$mysqli->close();
?>
<br>
<input type="submit" value="Update"/>
</br>
</form>
