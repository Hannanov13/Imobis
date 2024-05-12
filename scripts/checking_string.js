

$('#btn_check').click(function () {
    let string_for_checking = $('#myInput').text().trim();
    if (!string_for_checking) {
        $('#text').css('color', 'red').html('Сначала введите текст');
    } else {

        function add_index_of_symbol_to_array(array, string_for_checking) {
            array.forEach(function (i) {
                string_for_checking[i] = "<span class='incorrect'>" + string_for_checking[i] + "</span>";
            });
            $('#myInput').html(string_for_checking.join(''));
        }

        function to_start() {
            $('#btn_cancel').hide();
            $('#btn_check').show();
            $('#btn_clear').show();
            $('font[color="#ff0000"]').removeAttr('color').css('color', '#11b642');
            $('#myInput').off('input');
        }

        let language = '';

        // определение языка строки
        $.ajax({
            url: '/imobis/controllers/language_definition.php',
            type: 'POST',
            data: {'string': string_for_checking},
            success: function (response) {
                response = JSON.parse(response);
                let newString = string_for_checking;
                string_for_checking = string_for_checking.split('');
                if (!response['ru'].length) {
                    $('#text').css('color', 'green').html('Все буквы в тексте английские');
                    language = 'en';
                }
                else if (!response['en'].length)
                {
                    $('#text').css('color', 'green').html('Все буквы в тексте русские');
                    language = 'ru';
                } else {
                    // если больше русских букв
                    if (response['ru'].length >= response['en'].length) {
                        $('#text').css('color', 'green').html('Основной язык - русский, пожалуйста исправьте выделенные символы на кириллицу');
                        add_index_of_symbol_to_array(response['en'], string_for_checking);
                        language = 'ru';

                        // если больше английских букв
                    } else {
                        $('#text').css('color', 'green').html('Основной язык - английский, , пожалуйста исправьте выделенные символы на латиницу');
                        add_index_of_symbol_to_array(response['ru'], string_for_checking);
                        language = 'en';
                    }

                    $('#btn_check').hide();
                    $('#btn_clear').hide();
                    $('#btn_cancel').show();

                    // добавление запроса в историю
                    $.ajax({
                        url: '/imobis/controllers/add_to_history.php',
                        type: 'POST',
                        data: {'language': language, 'string': string_for_checking.join(''), 'user_id': $('#user_id').val()},
                        success: function (response) {
                            response = JSON.parse(response);
                            console.log(response);

                            let newRow = `<tr>
                            <td>${response['string']}</td>
                            <td>${response['language']}</td>
                            <td>${response['date']}</td>
                            </tr>`;
                            $(".table tbody").prepend(newRow);

                        }

                    });

                    // если не все буквы одинаковые то создаем обработчик события изменения поля ввода текста
                    let showTimer;
                    $('#myInput').on('input', function() {
                        $.ajax({
                            url: '/imobis/controllers/language_definition.php',
                            type: 'POST',
                            data: {'string': $(this).text()},
                            success: function (response) {
                                response = JSON.parse(response);
                                clearTimeout(showTimer);
                                $('#loading').show();
                                showTimer = setTimeout(function() {
                                    $('#loading').hide();
                                }, 1000);

                                if (language === 'ru' && !response['en'].length && $('#myInput').text().trim().length === newString.length) {
                                    $('#text').html('Отлично, теперь все буквы русские');
                                    to_start();
                                }
                                else if (language === 'en' && !response['ru'].length && $('#myInput').text().trim().length === newString.length) {
                                    $('#text').html('Отлично, теперь все буквы английские');
                                    to_start();
                                }
                            }
                        });
                    });
                }
            }
        });
    }
});

$('#btn_clear').click(function () {
    $('#text').empty();
    $('#myInput').html('');
});

$('#btn_cancel').click(function () {
    $('#text').empty();
    $('#myInput').empty();
    $('#btn_cancel').hide();
    $('#btn_check').show();
    $('#btn_clear').show();
    $('#myInput').off('input');
});