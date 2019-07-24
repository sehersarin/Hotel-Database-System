<body>
    <h1>Choose Desired Hotel Chain</h1>

    <form action="handleHotelPref.php" method="post">

        <?php
        // Enable error logging: 
        error_reporting(E_ALL ^ E_NOTICE);
        // mysqli connection via user-defined function
        include ('./my_connect.php');
        $mysqli = get_mysqli_conn();
        
        // SQL statement
        $sql = "SELECT name "
            . "FROM chain";

        // Prepared statement, stage 1: prepare
        $stmt = $mysqli->prepare($sql);

        // Prepared statement, stage 2: execute
        $stmt->execute();

        // Bind result variables 
        $stmt->bind_result($chain_name); 

        /* fetch values */ 
        echo '<label for="chain">chain: </label>'; 
        echo '<select name="chain">'; 

        while ($stmt->fetch()) {
            printf ('<option>%s</option>', $chain_name); 
        }

        echo '</select><br>'; 

        /* close statement and connection*/ 
        $stmt->close(); 
        $mysqli->close();
        ?>

        <br>
        <input type="submit" value="Continue"/>

    </form>
</body>