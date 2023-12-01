<!-- Simple PHP Page to end session (logout) -->
<?php
    session_destroy();
    echo 'Logout successful';
    header("Location: form.html");   
?>