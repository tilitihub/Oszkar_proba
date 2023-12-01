<?php
include 'connection.php';
//gets id from link
$id=$_GET['id'];
//and turns it into a string
$_id = strval($id);
$sql = "SELECT * FROM ratings WHERE id = $_id";
$curr_rating = mysqli_query($db, $sql);
$rows=mysqli_fetch_assoc($curr_rating);
session_start();
?>

<html>
    <head>
        <title>Update</title>
    </head>
    <body>
        <?php
            echo "You are currently logged in as: " . $_SESSION["username"] . ".<br>";
        ?>
        <a href="logout.php">Log Out</a>
        <h1>Update your rating</h1>
        <form name="form" method="POST">
            <p>
                <label for="artist">Artist</label>
                <input type="text" value="<?php echo $rows['artist'];?>" name='ar_tist' id='artist'>
            </p>
            <p>
                <label for="song">Song</label>
                <input type="text" value="<?php echo $rows['song'];?>" name='so_ng' id='song'>
            </p>
            <p>
                <label for="rating">Rating</label>
                <input type="text" value="<?php echo $rows['rating'];?>" name='ra_ting' id='rating'>
            </p>
                <input type="submit" value="Submit" name="submit">
                <input type="submit" value="Cancel" name="cancel">

        </form>
        <?php
        //if click submit check everythng is good to go
        if ($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST["submit"])){
            // have they forgotten to put something in?
            if (empty($_POST['ar_tist'])) {
                echo "You need to enter an artist!<br>";
              }
              else {
                $artist =$_POST['ar_tist'];
              }
              
              if(empty($_POST['so_ng'])) {
                echo "You need to enter a song!<br>";
              }
              else {
                //otherwise trim spaces
                $song = trim($_POST['so_ng']);
              }
            
              if (empty($_POST['ra_ting'])){
                echo "You need to enter a rating!<br>";
              }
              else{
                //otherwise trim spaces
                $rating = trim($_POST['ra_ting']);
              }
              //preparing sql database
            $sql = "SELECT id FROM ratings WHERE username = ? AND artist = ? AND song = ?";
            $stmt = $db->prepare($sql);
            
            //checking connection to SQL
            if ($stmt) {
                $stmt->bind_param("sss", $_SESSION['username'],$artist,$song);
                $stmt->execute();
                $result=$stmt->get_result();
                // if song is already in, warn user!
                if($result->num_rows > 0){
                    echo "This artist and song are already in the system. Insert another song!";
                }
            else{
            $sql1 = "UPDATE ratings SET artist='" . $_POST['ar_tist'] . "', song='" . $_POST['so_ng'] . "', rating='" . $_POST['ra_ting'] . "' WHERE id=" . $_id;
            if($_POST['ra_ting']>5){
                echo "Please chose a rating from 1 to 5!";
            }
            else if(mysqli_query($db, $sql1)){
                header("Location: musicratings.php");
            }
            else{
                echo "ERROR: Could not execute $sql";
            }
        }}}
        else if ($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["cancel"])){
            header("Location: musicratings.php");
            exit();
        }
        mysqli_close($db);
        ?>
    </body>
</html>