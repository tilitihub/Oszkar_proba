<?php
include 'connection.php';
// get current id from when the link is clicked
$id=$_GET['id'];
//and turn it into text
$_id = strval($id);
$sql = "SELECT * FROM ratings WHERE id = $_id";
$curr_rating = mysqli_query($db, $sql);
mysqli_close($db);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Music Rating Page</title>
</head>
    <body>
    <?php echo "You are currently logged in as: " . $_SESSION["username"] . ".<br>"; ?>
    <a href="logout.php">Log Out</a>
    <h1>View</h1>
        <?php
        //if the row aligns with the id, print!
            if (mysqli_num_rows($curr_rating) > 0) {
              while($row = mysqli_fetch_assoc($curr_rating)) {
                ?>
                <h3> Username:</h3>
                <?php echo $row['username'];?>
                <h3> Artist:</h3>
                <?php echo $row['artist'];?>
                <h3> Song:</h3>
                <?php echo $row['song'];?>
                <h3> Rating:</h3>
                <?php echo $row['rating'];
                }
            } else {
              echo "0 results";
            }
        ?>
        <!-- Back button -->
        <a href="musicratings.php"></br></br>Back</a>
    </body>
</html>