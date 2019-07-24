<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "INSERT INTO guest "
. "VALUES (null, ?, ?, ?, ?, ?, ?) ";

//SQL statement 2: finds the guest ID for that guest.
$sql2 = "SELECT ID "
. "FROM guest "
. "WHERE first_name = ? and last_name = ? and city = ? and street_no = ? and postal_code = ? and phone_no = ? ";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$fname = $_POST['fname']; 
$lname = $_POST['lname']; 
$city = $_POST['city']; 
$street = $_POST['street']; 
$pcode = $_POST['pcode']; 
$phone = $_POST['phone']; 

// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('ssssss', $fname, $lname, $city, $street, $pcode, $phone); 

if($stmt->execute()){
    echo '<p>' . $fname . ' ' . $lname . ' added successfully!</p>';
    //Prepare second sql statement.
    $stmt2 = $mysqli->prepare($sql2);
    $stmt2->bind_param('ssssss', $fname, $lname, $city, $street, $pcode, $phone); 
    $stmt2->execute();
    $stmt2->bind_result($guest_ID); 
    if ($stmt2->fetch()) { 
        echo '<p> Guest ID: ' . $guest_ID . '.</p>';
     } 
    else {
        echo '<p>Guest not inserted. Please try again.</p>'; 
    }
     
}
else {
    echo '<p>Guest not inserted. Please try again.</p>';
}

/* close statement and connection*/ 
$stmt->close(); 
$stmt2-> close();
$mysqli->close();

?>
<br><center><a href="index.html" class="button">Back to Home</a></br></center>