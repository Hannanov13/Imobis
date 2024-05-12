<?php
session_start();
if (isset($_SESSION['user']) and (in_array(session_id(), $_SESSION['user']))) {
    header("Location: main.php");
    die();
}


?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Авторизация на сервисе</title>
    <link rel="stylesheet" href="styles/authorization.css">

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<div class="registration-form">
    <h2><span class="badge bg-dark">Авторизация на сервисе</span></h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Имя пользователя</label>
            <input type="text" class="form-control" placeholder="Ivanov Ivan" name="name">
        </div>

        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password">
        </div>


        <div class="d-grid gap-2">
            <button class="btn btn-danger" type="button" id="login">Вход</button>
        </div>

        <div ><span id="err"></span></div>


        <p><a href="index.php" class="link-dark">Регистрация</a></p>
    </form>


</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="scripts/authorization.js"></script>
</body>
</html>
