<?php
session_start();
session_unset();
session_destroy();


if (isset($_COOKIE['rememberme'])) {
    setcookie('rememberme', '', time() - 3600, "/");
}

header("Location: pageconnexion.html");
exit();
?>
