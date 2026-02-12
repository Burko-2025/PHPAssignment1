<?php
    session_start();

    require 'database.php';

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Registration Confirmation</title>
        <link rel="stylesheet" type="text/css" href="css/add_contact.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>User Confirmation</h2>
          <p1>Thank you <?php echo $_SESSION['userName']; ?>, for registering your user 
          information. </p1> <br> <br>
          <p1>You are logged in and may proceed to the contact list by clicking below.</p1><br><br>
 

          


          <p1><a href="index.php">View Contact List</a></p1>


        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>