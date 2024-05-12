<?php
session_start();


$name = $_POST['name'];
$password = $_POST['password'];
$double_password = $_POST['double_password'];


if ((!$name) or (!$password) or (!$double_password)) {
    echo "accuracy";
    die();
}
else if (mb_strlen($name) > 25)
{
    echo 'name';
    die();
}


else {
    require_once "../db/db_connect.php";
    function select(PDO $pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function add($name, $password, PDO $pdo)
    {
        $stmt = $pdo->prepare("INSERT INTO user SET name = :name, password = :password");
        $stmt->execute([
            'name' => $name,
            'password' => $password
        ]);
    }


    $users = select($pdo);
    if (in_array($name, array_column($users, 'name'))) {
        echo "person";
        die();
    }

    if ($password != $double_password) {
        echo "double_password";
        die();
    }



    $str_low = "qwertyuiopasdfghjklzxcvbnm";
    $str_high = "QWERTYUIOPASDFGHJKLZXCVBNM";
    $str_sybmols = "!#$%&\'()*+,-./:;<=>?@[\]^_`{|}~";
    $flag_low = false;
    $flag_high = false;
    $flag_symbols = false;


    for ($i = 0; $i < strlen($password); $i++) {
        if (($flag_low) and ($flag_high) and ($flag_symbols)) {
            break;
        }
        else if (strpos($str_low, $password[$i]) !== false)
            $flag_low = true;
        else if (strpos($str_high, $password[$i]) !== false)
            $flag_high = true;
        else if (strpos($str_sybmols, $password[$i]) !== false)
            $flag_symbols = true;
    }



    if (($flag_low) and ($flag_high) and ($flag_symbols)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        add($name, $password, $pdo);

        echo "ok";
        die();
    }

    echo "password";
    die();

}











