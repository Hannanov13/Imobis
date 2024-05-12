<?php
session_start();

if (isset($_SESSION['user']) and (!in_array(session_id(), $_SESSION['user']))) {
    header("Location: index.php");
    die();
}

require "../db/db_connect.php";

$stmt = $pdo->prepare("UPDATE user SET session_id = '' WHERE session_id = :session_id");
$stmt->execute([
    'session_id' => session_id()
]);

$_SESSION['user'] = array_diff($_SESSION['user'], array(session_id()));
header("Location: ../login.php");

