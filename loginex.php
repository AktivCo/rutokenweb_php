<?php
// Страница проверки существования логина

include_once "config.php";
function chk(){
    $err = array();

    # проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_GET['tlogin']))
    {
        echo "Логин может состоять только из букв английского алфавита и цифр";
		return;
    }
    
    if(strlen($_GET['tlogin']) < 3 or strlen($_GET['tlogin']) > 30)
    {
        echo "Логин должен быть не меньше 3-х символов и не больше 30";
		return;
    }
    
    # проверяем, не сущестует ли пользователя с таким именем
    $query = mysql_query("SELECT COUNT(user_id) FROM sample_users WHERE user_login='".mysql_real_escape_string($_GET['tlogin'])."'");
    if(mysql_result($query, 0) > 0)
    {
        echo "Пользователь с таким логином уже существует в базе данных";
		return;
    }
    echo "login valid";
		return;
	}
if(isset($_GET['tlogin'])){
	chk();
} else {
	echo "Нет данных";
}
?>
