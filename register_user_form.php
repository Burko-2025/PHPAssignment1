
<!DOCTYPE html>
<html>

    <head>
        <title>Register User</title>
        <link rel="stylesheet" type="text/css" href="css/add_contact.css"/>
      </head>

    <body>
        <?php include 'header.php'; ?>

        <main>
          <h2>Register User</h2>
          <form action="register_user.php" method="post" id="register_user_form" 
          enctype="multipart/form-data">
            <div id ="data">
              <label for="userName">First Name:</label>
              <input type="text" id="userName" name="user_name" required><br>

              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required><br>

              <label for="emailAddress">Email Address:</label>
              <input type="text" id="emailAddress" name="email_address" required><br>


            </div>

            <div id="buttons">
              <input type="submit" value="Register"><br>
            </div>

          </form>

        <p><a href="login_form.php">View Login</a></p>

        </main>

        <?php include 'footer.php'; ?>


    </body>
</html>