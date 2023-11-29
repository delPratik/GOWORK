<?php

session_destroy();
unset($_SESSION['client_name']);
// Redirect the user to the login page
header("Location: login.php");
exit();
?>
