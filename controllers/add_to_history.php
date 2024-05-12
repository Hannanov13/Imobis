<?php
session_start();
if (!isset($_SESSION['user']) or (!in_array(session_id(), $_SESSION['user']))) {
    header("Location: index.php");
    die();
}

require_once '../db/db_connect.php';

date_default_timezone_set('Europe/Moscow');

$string = $_POST['string'];
$user_id = $_POST['user_id'];
$language = $_POST['language'];
$date = date("H:i d-m-Y");

$stmt = $pdo->prepare("INSERT INTO history (content, language, date, user) VALUES (:content, :language, :date, :user)");
$stmt->execute([
    'content' => $string,
    'language' => $language,
    'date' => $date,
    'user' => $user_id
]);

echo json_encode(['string' => $string, 'language' => $language, 'date' => $date]);