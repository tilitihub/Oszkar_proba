<!-- Connects database to PHP -->
<?php
$db = mysqli_connect("localhost","root","","users_hw2");

if (mysqli_connect_errno()) {
 echo "Failed to connect to MySQL: "
  . mysqli_connect_error();
}
?>