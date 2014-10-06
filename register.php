<?
  if(isset($_POST['login'])) {
    include_once "config.php";
    $login = $_POST['login'];
    $user_xkey = $_POST['user_xkey'];
    $user_ykey = $_POST['user_ykey'];
    $r_xkey = $_POST['repair_xkey'];
    $r_ykey = $_POST['repair_ykey'];
    mysql_query("INSERT INTO sample_users SET  user_login='".$login."', user_xkey='".$user_xkey."', user_ykey='".$user_ykey."', r_xkey='".$r_xkey."', r_ykey='".$r_ykey."'");
    header("Location: login.php");
    exit();
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Rutoken Web</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/styles.css" />
    <!--[if lt IE 6]>
      <link rel="stylesheet" type="text/css" href="/css/styles_fix_06.css" />
    <![endif]--><!--[if lt IE 7]>
      <link rel="stylesheet" type="text/css" href="/css/styles_fix_07.css" />
    <![endif]-->
    <script type="text/javascript" src="/script/jquery.min.js"></script>
  	<script type="text/javascript" src="/script/sha256.js"></script>
    <script type="text/javascript" src="/script/utf8.js"></script>
  	<script type="text/javascript" src="/script/base64.js"></script>
  </head>
  <body>
    <div class="layout">
      <div class="global">
        <div class="head">
          <a class="logo" href="/"><img src="/images/logo.png" border="0" width="220" height="120" alt="" /></a>
          <div class="slogan">Строгая аутентификация Рутокен Web — примеры использования в Web-приложениях, написанных на PHP</div>
        </div>
        <div class="menu">
          <ul class="base">
            <li><a href="index.php">Главная</a></li>
            <li class="current"><a href="register.php">Регистрация</a></li>
            <li><a href="login.php">Аутентификация</a></li>
            <li><a href="recovery.php">Восстановление доступа</a></li>
            <li><a href="signform.php">WEB-формы</a></li>
            <li><a href="api.php">API</a></li>
          </ul>
          <ul class="info">
            <li><a href="http://www.rutokenweb.ru/" target="_blank">Вернуться на RutokenWeb.ru</a></li>
          </ul>
        </div>
        <div class="data nake">
          <div class="text">
            <!-- Content -->
            <h1>Регистрация нового пользователя</h1>
            <p>Для регистрации выберите логин и нажмите кнопку «Зарегистрироваться». Логин пользователя должен состоять из цифр и букв латинского алфавита (любого регистра), а также иметь длину не менее трех и не более тридцати символов.</p>
            <div class="accent round_5px">
              <div class="message round_3px">
                <form method="post" id="regform">
                  <input type="hidden" name="user_xkey"  id="usr_xkey" value="" />
                  <input type="hidden" name="user_ykey"  id="usr_ykey" value="" />
                  <input type="hidden" name="repair_xkey"  id="r_xkey" value="" />
                  <input type="hidden" name="repair_ykey"  id="r_ykey" value="" />
                  <table>
                    <tr>
                      <th><label>Логин пользователя:</label></th>
                      <td><input style="width: 200px;" name="login" id="user_login" type="text" />
                          <button type="button" onclick="chklogin()">Зарегистрироваться</button></td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
            <h2>Краткая справка</h2>
            <p>В случае успешной регистрации, будет сгенерирована ключевая пара <strong>(e_(Login, SiteName),d_(Login, SiteName))</strong>, предназначенная для защищенной аутентификации пользователя c логином <strong>Login</strong> на Web-сайте <strong>SiteName</strong>:</p>
            <ul>
              <li><strong>e_(Login, SiteName)</strong> — открытый ключ — хранится на Рутокен Web, передается на Web-сайт и привязывается к логину пользователя;</li>
              <li><strong>d_(Login, SiteName)</strong> — закрытый ключ — хранится на Рутокен Web и не может быть извлечен из памяти USB-токена.</li>
            </ul>
            <p>Таким образом, на сервере сохраняется пара <strong>(Login, e_(Login, SiteName))</strong>. Пользователь может повторно пройти процедуру регистрации на Web-сайте, но уже с другим логином. Количество повторных регистраций на одном и том же Web-сайте ограничено только объемом доступной памяти USB-токена, предназначенной для хранения контейнеров.</p>
            <!-- / Content -->
            <object id="cryptoPlugin" type="application/x-rutoken" width="0" height="0">
              <param name="onload" value="pluginit" />
            </object>
            <script type="text/javascript">
              var plugin;
              var http = createObject();
              var error_text="";
              var err =[];
                err[-1]  = 'USB-токен не найден';
                err[-2]  = 'USB-токен не залогинен пользователем';
                err[-3]  = 'PIN-код не верен';
                err[-4]  = 'PIN-код не корректен';
                err[-5]  = 'PIN-код заблокирован';
                err[-6]  = 'Неправильная длина PIN-кода';
                err[-7]  = 'Отказ от ввода PIN-кода';
                err[-10] = 'Неправильные аргументы функции';
                err[-11] = 'Неправильная длина аргументов функции';
                err[-12] = 'Открыто другое окно ввода PIN-кода';
                err[-20] = 'Контейнер не найден';
                err[-21] = 'Контейнер уже существует';
                err[-22] = 'Контейнер поврежден';
                err[-30] = 'ЭЦП не верна';
                err[-40] = 'Не хватает свободной памяти чтобы завершить операцию';
                err[-50] = 'Библиотека не загружена';
                err[-51] = 'Библиотека находится в неинициализированном состоянии';
                err[-52] = 'Библиотека не поддерживает расширенный интерфейс';
                err[-53] = 'Ошибка в библиотеке rtpkcs11ecp';
              function createObject() {
              	var request_type;
              	var browser = navigator.appName;
              	if(browser == "Microsoft Internet Explorer") {
              		request_type = new ActiveXObject("Microsoft.XMLHTTP");
              	} else {
            	  	request_type = new XMLHttpRequest();
              	}
              	return request_type;
              }
              function errorReply() {
              	if (http.readyState == 4) {
              		if (http.responseText.indexOf("valid")>0) {
              			link_token();
            	  	} else {
            		  	alert(http.responseText);
              		}
              	}
              }
              function chklogin() {
              	ulogin = document.getElementById('user_login');
              	nocache = Math.random();
              	http.open('get', 'loginex.php?tlogin='+encodeURI(ulogin.value)+'&nocache='+nocache); 
              	http.onreadystatechange = errorReply;
              	http.send(null);
              }
              function link_token() {
              	plugin=document.getElementById("cryptoPlugin");
              	xkey = document.getElementById('usr_xkey');
              	ykey = document.getElementById('usr_ykey');
              	rxkey = document.getElementById('r_xkey');
              	rykey = document.getElementById('r_ykey');
              	ulogin = document.getElementById('user_login');
            	  if (ulogin.value=='') {
            		  inf.innerHTML="Введите логин";
              		return;
              	}
              	if (!plugin.valid) {
              		inf.innerHTML="<a href='https://www.rutokenweb.ru/samples/'>Установите плагин</a>";
              		return;
              	}
              	if (!plugin.rtwIsTokenPresentAndOK()) {
            	  	inf.innerHTML="Подключите USB-токен";
            		  return;
              	}
              	if (!plugin.rtwIsUserLoggedIn()) {
              		plugin.rtwUserLoginDlg();
              	}
              	if (plugin.rtwIsUserLoggedIn()) {
					key=plugin.rtwGenKeyPair(ulogin.value + '#%#<?php echo getenv("HTTP_HOST"); ?>');
              		rkey=plugin.rtwGetPublicKey('repair key');
            	  	plugin.rtwLogout();
            		  if (key) {
            			xkey.value = key.substring(0,64);
              			ykey.value = key.substring(64);
              			if (rkey) {
		  				        rxkey.value = rkey.substring(0,64);
          						rykey.value = rkey.substring(64);
				  	        }
        	  				tform = document.getElementById('regform');
				          	tform.submit();
        			  	} else {
        				  	alert("Ошибка при создании ключевой пары.");
          				}
          			} else {
          				alert("Введен ошибочный PIN-код.");
	          		}
              }
              function pluginit(){}
            </script>
          </div>
        </div>
        <div class="null"></div>
        <!-- dl class="foot">
          <dt><a href="http://www.rutoken.ru/contacts/" target="_blank">+7 (495) 925-77-90</a></dt>
          <dd class="jump">1994 — 2011 &copy; <a href="http://aktiv-company.ru/" target="_blank">Компания «Актив»</a>. Все права защищены.</dd>
        </dl -->
      </div>
    </div>
  </body>
</html>