<?php
session_start();
session_unset();
session_destroy();

// Redirection vers la page de login
header("Location: /pages/login.php");
exit;
