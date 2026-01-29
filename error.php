<?php
    session_start();

?>
<!DOCTYPE html>
<html>

    <head>
        <title>Players Manager - Error</title>
        <link rel="stylesheet" type="text/css" href="css/app.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Error</h2>


          <p2>Error Message: <?php echo $_SESSION['error']; ?></p2>
          <h3><a href="add_contact_form.php">Add Player</a></h3>
          <h3><a href="index.php">View Player List</a></h3>

        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>