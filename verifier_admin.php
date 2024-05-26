<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo json_encode(['is_admin' => false]);
    exit();
}

$is_admin = $_SESSION['utilisateur']['Admin'];
echo json_encode(['is_admin' => $is_admin]);
?>
