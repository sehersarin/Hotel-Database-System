<h1>Update Guest Information</h1>

<form action="update_Guest.php" method="post"/>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT first_name, last_name, city, street_no, postal_code, phone_no "
. "FROM guest "
. "WHERE ID = ? ";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$guest_ID = $_POST['guest_ID']; 
// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('i', $guest_ID); 
$stmt->execute();

// Bind result variables 
$stmt->bind_result($first_name, $last_name, $city, $street_no, $postal_code, $phone_no); 

/* fetch values */ 
if ($stmt->fetch()) { 
    echo '<input type="hidden" name="guest_ID" value="' . $guest_ID . '"/>'; 
    echo '<label for="fname">First Name: </label>'; 
    echo '<input type="text" name="fname" value="'.$first_name.'"/><br>'; 
    echo '<label for="lname">Last Name: </label>'; 
    echo '<input type="text" name="lname" value="'.$last_name.'"/><br>'; 
    echo '<label for="city">City: </label>'; 
    echo '<input type="text" name="city" value="'.$city.'"/><br>'; 
    echo '<label for="street_no">Street: </label>'; 
    echo '<input type="text" name="street_no" value="'.$street_no.'"/><br>'; 
    echo '<label for="pcode">Postal Code: </label>'; 
    echo '<input type="text" name="pcode" value="'.$postal_code.'"/><br>'; 
    echo '<label for="phone_no">Phone Number: </label>'; 
    echo '<input type="text" name="phone_no" value="'.$phone_no.'"/><br>'; 
} 
else {
    echo '<label for="guest_ID">Guest does not exist.</label>'; 
}
/* close statement and connection*/ 
$stmt->close(); 
$mysqli->close();
?>
<br>
<input type="submit" value="Update"/>
</br>
</form>
