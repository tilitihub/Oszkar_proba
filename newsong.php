<?php
include 'connection.php';

session_start();
?>

<html>
    <head>
        <title>Add new Song</title>
    </head>
    <body>
        <?php
            echo "You are currently logged in as: " . $_SESSION["username"] . ".<br>";
        ?>
        <a href="logout.php">Log Out</a>
        <h1>Add a New Song</h1>
        <!-- Another form to Insert new row into the ratings table in the db. Inputs below: -->
        <form name="form" method="POST">
            <p>
                <label for="artist">Artist</label>
                <input type="text" name='artist' id='artist'>
            </p>
            <p>
                <label for="song">Song</label>
                <input type="text" name='song' id='song'>
            </p>
            <p>
                <label for="rating">Rating</label>
                <input type="text" name='rating' id='ra
                ting'>
            </p>
                <input type="submit" value="Submit" name="submit">
                <input type="submit" value="Cancel" name="cancel">

        </form>
        <?php
        // if clicked confirm:
        if ($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST["submit"])){
            // no artist input
            if (empty($_POST['artist'])) {
                echo "You need to enter an artist!<br>";
              }
              else {
                $artist =$_POST['artist'];
              }
              // no song input
              if(empty($_POST['song'])) {
                echo "You need to enter a song!<br>";
              }
              else {
                $song = trim($_POST['song']);
              }
            // no rating input
              if (empty($_POST['rating'])){
                echo "You need to enter a rating!<br>";
              }
              else{
                // trim takes away any spaces (only allows strictly numerical value)
                $rating = trim($_POST['rating']);
              }
            //preparing SQL statement
            $sql = "SELECT id FROM ratings WHERE username = ? AND artist = ? AND song = ?";
            $stmt = $db->prepare($sql);
            
            //if the statement is true
            if ($stmt) {
                $stmt->bind_param("sss", $_SESSION['username'],$artist,$song);
                $stmt->execute();
                $result=$stmt->get_result();
                if($result->num_rows > 0){
                    echo "This artist and song are already in the system. Insert another song!";
                }
                else if($_POST['rating']>5 OR $_POST['rating']<1){
                    echo "Please chose a rating from 1 to 5!";
                }
                else{//if successful 
                    $add = "INSERT INTO ratings (username, artist, song, rating)
                    VALUES ('".$_SESSION['username']."','$artist','$song','$rating')";
                    mysqli_query($db, $add);
                    header("Location:musicratings.php");
                }}}
            //if they click cancel
        else if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["cancel"])){
            header("Location: musicratings.php");
            exit();
        }
        
        mysqli_close($db);
        ?>
    </body>
</html>