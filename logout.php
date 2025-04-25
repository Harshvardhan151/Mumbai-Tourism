<?php
session_start();
session_unset(); // clear session vars
session_destroy(); // kill session

// redirect to login
header("Location: index.html");
exit();
?>
