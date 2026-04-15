<?php
/**
 * admin/logout.php
 * Destroys admin session and redirects to login
 */
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
