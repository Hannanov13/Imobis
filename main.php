<?php
session_start();
if (!isset($_SESSION['user']) or (!in_array(session_id(), $_SESSION['user']))) {
    header("Location: index.php");
    die();
}

require_once 'db/db_connect.php';
$stmt = $pdo->prepare("SELECT id, name FROM user WHERE session_id = :session_id");
$stmt->execute([
    'session_id' => session_id()
]);
$user = $stmt->fetch(pdo::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT content, language, date FROM history WHERE user = :user_id ORDER BY id DESC");
$stmt->execute([
        'user_id' => $user['id']
]);

$history = $stmt->fetchAll(pdo::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Проверьте строку</title>
    <link rel="stylesheet" href="styles/main_page.css">

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<input id="user_id" value="<?= $user['id'] ?>" hidden>

<p id="logout"><a href="controllers/logout.php" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" >Выйти</a></p>


<div class="mb-3">
    <div id="column">
    <div id="welcome">
        <h2><span class="badge bg-warning">Добро пожаловать <br>
        <?= $user['name'] ?> !
        </span></h2>
    </div>


    <label class="form-label">Введите текст:</label>
        <div class="row">
            <div class="col-md-9">
                <div id="myInput" class="form-control form-control-sm" contenteditable="true"></div>
            </div>
            <div class="col-md-3">
                <div id="loading" class="spinner-border text-warning" role="status">
                    <span class="visually-hidden">Загрузка...</span>
                </div>
            </div>
        </div>

    <button type="button" class="btn btn-light btn-sm" id="btn_check">Проверить</button>
    <button type="button" class="btn btn-danger btn-sm" id="btn_clear" >Очистить</button>
    <button type="button" class="btn btn-danger btn-sm" id="btn_cancel" >Отмена</button>

    <div ><span id="text"></span></div>

    <div id="info">
    <h2 ><span class="badge bg-success">
        Здесь вы можете проверить что
        все символы в тексте одного языка <br>
        <span class="badge danger">посмотреть историю проверок можно снизу ↓</span>
    </span></h2>
    </div>

        <div class="scrollable-container">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Контент</th>
                    <th scope="col">Язык</th>
                    <th scope="col">Дата</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($history as $string) {
                    echo "<tr>";
                    echo "<td>". $string['content'] ."</td>";
                    echo "<td>". $string['language'] ."</td>";
                    echo "<td>". $string['date'] ."</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="scripts/checking_string.js"></script>
</body>
</html>
