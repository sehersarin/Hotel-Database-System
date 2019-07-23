<body>

<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "UPDATE aircraft a "
. "SET a.aname = ? "
. "WHERE a.aid = ?";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// (2) Handle GET parameters; aid is the name of the hidden textbox in the previous page
$aid = $_GET['aid']; 
$aname = $_GET['aname'];


// (3) "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('si', $aname, $aid); 


// $stmt->execute() function returns boolean indicating success 

if ($stmt->execute()) 
{ 
echo '<h1>Success!</h1>'; 
echo '<p>Aircraft #' . $aid . ' name updated to ' . $aname . '.</p>'; 
} 
else 
{
echo '<h1>You Failed</h1>'; 
echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error; 
} 
$stmt->close(); 
$mysqli->close();
?>

<p>
<a href="index.php">Return to list</a>
</p>
</body>
