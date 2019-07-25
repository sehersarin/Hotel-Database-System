<head>
  <title>Employee Salary Statistics</title>
</head>

<body>

    <h1>Employee Salary Statistics</h1>
    <form>

        <?php
            // Enable error logging: 
            error_reporting(E_ALL ^ E_NOTICE);
        
            // mysqli connection via user-defined function
            include('./my_connect.php');
        
            // Fetches the required information from the previous files.
            $hotel_name = $_POST['hotel_name'];
            $type = $_POST['emp_type'];
        
            // Uses conditional statements to initialize the SQL statement based on the desired type of employee.
            if ($type == 'Manager'){
                $sql = "SELECT avg(salary), avg(hours_per_week), max(salary), min(salary) "
                . "FROM employee natural join manager "
                . "WHERE hotel_name = ? ";
            }
            if ($type == 'Maintenance'){
                $sql = "SELECT avg(salary), avg(hours_per_week), max(salary), min(salary) "
                . "FROM employee natural join maintenance "
                . "WHERE hotel_name = ? ";
            }
            if ($type == 'Front Desk'){
                $sql = "SELECT avg(salary), avg(hours_per_week), max(salary), min(salary) "
                . "FROM employee natural join front_desk "
                . "WHERE hotel_name = ? ";
            }
            if ($type == 'All'){
                $sql = "SELECT avg(salary), avg(hours_per_week), max(salary), min(salary) "
                . "FROM employee "
                . "WHERE hotel_name = ? ";
            }

            // Prepared statement, stage 1: prepare
            $mysqli = get_mysqli_conn(); 
            $stmt = $mysqli->prepare($sql);
            
            // Binds the parameters and executes the statement.
            $stmt->bind_param('s', $hotel_name);
            $stmt->execute();

            $stmt->bind_result($avg_salary, $avg_hours, $max_salary, $min_salary);
            
            // Prints the desired statistics for the selected employee type (or all). 
            if ($stmt->fetch()){
                echo 'Average salary of ' . $type . ' employees : ' . $avg_salary . '<br>';
                echo 'Average hours per week of ' . $type . ' employees: ' . $avg_hours . '<br>';
                echo 'Maximum salary of ' . $type . ' employees: ' . $max_salary . '<br>';
                echo 'Minimum salary of ' . $type . ' employees: ' . $min_salary . '<br>';
            }
            // Else statement to display an error message in the event of any errors.
            else {
                echo 'Error occurred. Please try again.';
            }
            // Close statement and connection.
            $stmt->close(); 
            $mysqli->close();
        ?>

    </form>
    
    <!-- Provides a link back to the Home page. -->
    <br><center><a href="index.html" class="button">Back to Home</a></br></center>
</body>