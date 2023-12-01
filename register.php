<!-- The Backend component of registration.-->
<?php
include 'connection.php';
$user_name = $_POST['user_name'];
$pass_word = $_POST['pass_word'];
$pass_word1 = $_POST['pass_word1'];
$select= mysqli_query($db, "SELECT * FROM users WHERE username = '".$_POST['user_name']."'");
?>


<html>
<body>
    <div id="form">
      <h1>New User</h1>
      <form name="form" action="register.php" method="POST">
        <p>
          <label for="username"> NEW USER NAME: </label>
          <input type="text" name="user_name" id="username">
        </p>
        <p>
          <label for="password"> NEW PASSWORD: </label>
          <input type="text" id="password" name="pass_word" >
        </p>
        <p>
          <label for="password">RE ENTER PASSWORD:</label>
          <input type="text" id="password1" name="pass_word1">
        </p>
        <p>
          <input type="submit" id="button" value="register" >
        </p>
      </form>
    </div>
    <?php
    // If already within db, don't let them have the same username
    if (mysqli_num_rows($select)) {
        echo "This username is taken";
    }
    else{
        if($pass_word != $pass_word1) {
            echo "Passwords do not match!";
        }
        else if(strlen($pass_word)<10){
          echo "Your password must contain at least 10 characters";
        }
        else {
          // Otherwise insert to DB
            $hashed_password = password_hash($pass_word, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES('$user_name', '$hashed_password')";
            if(mysqli_query($db, $sql)) {
            header("Location: form.html");
            }
            else {// Output error if there is no connection!
            echo "Error: " . $sql . "<br>" . $db->error; 
            }
        }
    }
    ?>
  </body>
</html>

