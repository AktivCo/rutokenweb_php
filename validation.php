<?php

include_once ("config.php");

function chk() {

    $err = array();

    $login = $_GET['tlogin'];

    /* Пустой логин */


    if ( !$login ) {
        echo "Пожалуйста, введите логин пользователя.";
        return;
    }


    /* Символы логина */

    if ( (!preg_match("/^[a-zA-Z0-9]+$/", $login )) || (preg_match("/^[0-9]+$/", $login )) ) {
        echo "Используйте символы латинского алфавита или их сочетание с цифрами. Использование логинов, содержащих только цифры или специальные символы, ограничено на данной демонстрационной площадке .";
        return;
    }

    /* Длина логина */

    if ( strlen($login) < 3 || strlen($login) > 30) {
        echo "Логин должен быть не меньше 3-х символов и не больше 30.";
        return;
    }

    /* Проверка на уникальность */

    $query = mysql_query("SELECT COUNT('user_id') FROM sample_users WHERE user_login='".mysql_real_escape_string($login)."'");

    if(mysql_result($query, 0) > 0) {
        echo "Пользователь с таким логином уже зарегистрирован.";
        return;
    }

    echo "login valid";
    return;
}


if (isset($_GET['tlogin'])) {
    chk();
} else {
    echo "Нет данных";
}

?>
