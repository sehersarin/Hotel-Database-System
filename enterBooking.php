<head>
  <title>Update Booking</title>
</head>

<body>
    
    <h1>Update Booking</h1>
    
    <!-- Directs to the handlePeople.php when the user presses the Continue button.
     Uses post as it is more secure than get. -->
    <form action="handlePeople.php" method="post">

        Enter Booking ID:<br>   
        <!-- Stores the user input of booking ID into a variable named bID. -->
        <input type="text" name="bID"/><br>
        <input type="submit" name="submit" value="Continue"/>

    </form>
    
    <!-- Provides a link back to the Home page. -->
    <br><center><a href="index.html" class="button">Back to Home</a></br></center>
</body>