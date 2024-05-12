<?php
session_start();

$name = $_POST['name'];
$password = $_POST['password'];


if ((!$name) or (!$password)) {
    echo "accuracy";
    die();
}

else {
    require_once "../db/db_connect.php";

    function query_select(PDO $pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    function update_session_id($name, $session_id, PDO $pdo)
    {
        $stmt = $pdo->prepare("UPDATE user SET session_id = '', WHERE session_id = :session_id; 
        UPDATE user SET session_id = :session_id WHERE name = :name");
        $stmt->execute([
            'session_id' => $session_id,
            'name' => $name
        ]);

    }

    function add_session_id($name, $session_id, PDO $pdo)
    {
        $stmt = $pdo->prepare("UPDATE user SET session_id = :session_id WHERE name = :name");
        $stmt->execute([
           'session_id' => $session_id,
           'name' => $name
        ]);
    }

    $users = query_select($pdo);
    foreach ($users as $user) {
        if ((($name == $user['name']) and (password_verify($password, $user["password"])))) {
            if (isset($_SESSION['user']) and (in_array(session_id(), $_SESSION['user'])))
                update_session_id($name, session_id(), $pdo);
            else {
                $_SESSION['user'][] = session_id();
                add_session_id($name, session_id(), $pdo);
            }

            echo "ok";
            die();
        }
    }

    echo "person-password";
    die();

}











