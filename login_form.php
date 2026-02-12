<?php
    session_start();


?>

<!DOCTYPE html>
<html>

    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/add_contact.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Login </h2>
          
          <?php
          if (isset($_SESSION['login_error'])) {
              echo '<p style="color: red; font-weight: bold;">' . htmlspecialchars($_SESSION['login_error']) . '</p>';
              unset($_SESSION['login_error']);
          }
          ?>

          <form action="login.php" method="post" id="login_form" 
          enctype="multipart/form-data">
            <div id ="data">
              <label for="userName">First Name:</label>
              <input type="text" id="userName" name="user_name" required><br>

              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required><br>


            </div>

            <div id="buttons">
              <input type="submit" value="Login"><br>
            </div>

          </form>

        <p><a href="register_user_form.php">Register</a></p>

        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>