<?php
include 'connection.php';
if (empty($_POST['userid'])) {
  echo "You need to enter your username<br>";
}
else {
  $userid =$_POST['userid'];
}

if(empty($_POST['password'])) {
  echo "You need to input your password<br>";
}
else {
  // taking spaces away from password
  $password = trim($_POST['password']);
}
// Using placeholders ? for username and password values for the time being.
$sql = "SELECT username, password FROM users WHERE username = ?";
// Constructing a prepared statement.
$stmt = mysqli_prepare($db, $sql);

// Binding the values for username and password that the user entered to the
// statement AS STRINGS (that is what "ss" means). In other words, the
// user input is strictly interpreted by the server as data and not as
// porgram code part of the SQL statement.
mysqli_stmt_bind_param($stmt, "s", $userid);
// Running the prepared statement.
?>
<html>
  <head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
  </head>

  <body>
    <div id="form">
      <h1>Welcome to RevMixer</h1>
      <form name="form" action="verifyLogin.php" method="POST">
        <p>
          <label> USER NAME: </label>
          <input type="text" id="userid" name="userid" />
        </p>
        <p>
          <label> PASSWORD: </label>
          <input type="text" id="password" name="password" />
        </p>

        <p>
          <input type="submit" id="button" value="Login" />
        </p>
      </form>
      <a href="register.html">Not Registered? Click here!</a>
    </div>
    <?php
      
      if (mysqli_stmt_execute($stmt) === TRUE) {
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        //if it matches a username that is in the table
        if ($row) {
          //hashing password
          $hashed_password = $row['password'];
          //if they match, successful log in!
          if (password_verify($password, $hashed_password)) {
            session_start();
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $userid;
            header("Location: musicratings.php");
          }
          else {//username is in the table but didn't put correct password
            echo "Invalid Credentials";
          }
        }
      } else {//username does not match current db.
        echo "Username not found.";
      }
     ?>
  </body>
</html>

