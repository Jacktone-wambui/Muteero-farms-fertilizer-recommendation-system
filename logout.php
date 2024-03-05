<?php
session_start();

session_destroy();

// Redirect the user to the login page or any other desired page
header("Location: login.php");
exit;
?>
