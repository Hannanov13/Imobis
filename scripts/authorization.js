// регистрация
$("#reg").on("click", function () {
    var data = {};
    $("form").find('input').each(function() {
        data[this.name] = $(this).val();
    });

    $.ajax({
        url: "/imobis/controllers/create_user.php",
        type: "POST",
        data: data,
        success: function (response) {
            if (response === "accuracy")
                $("#err").html("Заполните все поля");
            else if (response === "name")
                $("#err").html("Имя пользователя не может быть больше 25 символов");
            else if (response === "person")
                $("#err").html("Такой пользователь уже существует");
            else if (response === "double_password")
                $("#err").html("Пароли не совпадают");
            else if (response === "password")
                $("#err").html("Пароль должен содержать латинские буквы в верхнем и нижнем регистре, хотя бы один специальный символ");
            else if (response === "ok")
                window.location.href = "/imobis/login.php";

        }
    });
});

// вход
$("#login").on("click", function () {
    var data = {};
    $("form").find('input').each(function() {
        data[this.name] = $(this).val();
    });

    $.ajax({
        url: "/imobis/controllers/check_user.php",
        type: "POST",
        data: data,
        success: function (response) {
            if (response === "accuracy")
                $("#err").html("Заполните все поля");
            else if (response === "person-password")
                $("#err").html("Неправильное имя пользователя или пароль");
            else if (response === "ok")
                window.location.href = "/imobis/main.php";
        }
    });
});