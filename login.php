<?php
	session_start();
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
  <body onload="token_refresh()">
    <div class="layout">
      <div class="global">
        <div class="head">
          <a class="logo" href="/"><img src="/images/logo.png" border="0" width="220" height="120" alt="" /></a>
          <div class="slogan">Строгая аутентификация Рутокен Web — примеры использования в Web-приложениях, написанных на PHP</div>
        </div>
        <div class="menu">
          <ul class="base">
            <li><a href="index.php">Главная</a></li>
            <li><a href="register.php">Регистрация</a></li>
            <li class="current"><a href="login.php">Аутентификация</a></li>
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
            <h1>Аутентификация на Web-сайте</h1>
            <p>Воспользуйтесь кнопкой «Обновить» для вывода актуального списка учетных записей, сохраненных на USB-токене. Для аутентификации выберите логин в выпадающем списке и нажмите кнопку «Войти». Далее потребуется ввести правильный PIN-код.</p>
            <div class="accent round_5px">
              <div class="message round_3px">
                <?php
                  if(isset($_POST['tlogin'])) {
                  	require_once('crypto/token.php');
                	  include_once "config.php";
                  	$rand_num = hash('sha256', $_POST['rnd'].":".$_SESSION[$_POST['tlogin']]);
                  	$ses_r = $_SESSION[$_POST['tlogin']];
                	  $_SESSION[$_POST['tlogin']] = "";
                  	$r_ecp=substr($_POST['user_sign'],0,64);
              	    $s_ecp=substr($_POST['user_sign'],64);
                    $query = mysql_query("SELECT user_id, user_xkey, user_ykey FROM sample_users WHERE user_login='".mysql_real_escape_string($_POST['tlogin'])."' LIMIT 1");
                    $my_count = mysql_num_rows($query);
                  	if ($my_count != '0' ) {
                  		$data = mysql_fetch_assoc($query);
                	  	$x_pkey=$data['user_xkey'];
                		  $y_pkey=$data['user_ykey'];
                    	echo "<p style=\"margin: 0;\">Получено клиентом:</p><pre style=\"margin: 0; padding: 0; font-family: Consolas; font-style: italic; font-size: 10px; color: #888;\">";
                    	echo $ses_r;
                    	echo "</pre>";
                    	echo "<p style=\"margin: 0;\">Отправлено клиентом:</p><pre style=\"margin: 0; padding: 0; font-family: Consolas; font-style: italic; font-size: 10px; color: #888;\">";
                  	  print_r($_POST);
                    	echo "</pre>";
                    	if (token_verify($rand_num,$x_pkey,$y_pkey,$r_ecp,$s_ecp)) {
                  			echo "<p style=\"margin-top: 10px; color: green;\"><strong>Успешная аутентификация!</strong><br />Пользователь <strong>".$_POST['tlogin']."</strong> авторизован с помощью Рутокен Web.</p>";
                	  	} else {
                  			print "<p style=\"margin-top: 10px; color:red;'\">Доступ запрещен!</p>";
                	  	}
                  	} else {
                			print "<p style=\"margin-top: 10px; color:red;\">Пользователь <strong>".$_POST['tlogin']."</strong> не зарегистрирован!</p>";
                  	}
                    echo "";
                  }
                ?>
                <form method="POST" id="logform">
                  <input type="hidden" name="user_sign"  id="user_sign" value="" />
                  <input type="hidden" name="tlogin" id="token_log" value="" />
                  <input type="hidden" name="rnd" id="rnd_client" value="" />
                  <table>
                    <tr>
                      <th><label>Логин пользователя:</label></th>
                      <td>
                        <select name="list_log" id="token_login">
                  				<option selected="selected" value="none"> - </option>
                        </select>
                        <button type="button" onclick="token_refresh()" title="Обновить">&darr;&uarr;</button>
                        <button type="button" onclick="rndGet()">Войти</button>
                      </td>
                    </tr>
                  </table>
                </form>
              </div>
            </div>
            <h2>Краткая справка</h2>
            <p>Для аутентификации при помощи USB-токенa Рутокен Web пользователю необходимо предварительно пройти процедуру <a href="register.php">регистрации</a>.</p>
            <p>Напомним, что при успешной регистрации, в памяти USB-токена сохраняется ключевая пара <strong>(e_(Login, SiteName),d_(Login, SiteName))</strong>,  предназначенная для защищенной аутентификации пользователя c логином <strong>Login</strong> на Web-сайте <strong>SiteName</strong>. Установка соответствия между открытым ключом <strong>e_(Login, SiteName)</strong> и логином <strong>Login</strong> осуществляется на стороне сервера (Web-сайта).</p>
            <!-- / Content -->
            <object id="cryptoPlugin" type="application/x-rutoken" width="0" height="0">
              <param name="onload" value="pluginit" />
            </object>
            <script type="text/javascript">
              var plugin;
              var http = createObject();
              var random_text="";
              var current_user="";
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
              function rndReply() {
              	if (http.readyState == 4) {
              		if (http.readyState == 4) {
              			random_text=http.responseText;
              			token_sign();
              		}
              	}
              }
              function rndGet() {
              	ltlog = document.getElementById('token_login');
              	logstr=ltlog.value;
              	if (logstr=="none") {
              		alert("Выберите учетную запись на USB-токене.");
              	} else {
              		tlog = document.getElementById('token_log');
              		tlog.value=logstr.substr(0,logstr.indexOf("#%#"));
              		if ((current_user==tlog.value)&&(random_text!="")) {
              			token_sign();
              		} else {
              			current_user=tlog.value;
              			nocache = Math.random();
              			http.open('get', 'random.php?tlogin='+encodeURI(tlog.value)+'&nocache='+nocache);
              			http.onreadystatechange = rndReply;
              			http.send(null);
              		}
              	}
              }
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
              function token_sign() {
              	if (!plugin.valid) {
              		alert('Не установлен плагин для работы с USB-токеном');
              		return;
              	}
              	clrnd = document.getElementById('rnd_client');
              	rd = Math.random().toString(16);
              	clrnd.value = Sha256.hash(rd);
              	random_text = Sha256.hash(clrnd.value + ':'+ random_text);
              	tsign = document.getElementById('user_sign');
              	ltlog = document.getElementById('token_login');
              	res = plugin.rtwSign(ltlog.value, random_text);
              	if ( res!=-7 && res!=-12 ) {
              		if	(res<0) {
              			alert(err[res]);
              		} else {
              			tsign.value = res;
              			tform = document.getElementById('logform');
              			tform.submit();
              		}
              	}
              }
              function token_refresh() {
              	plugin=document.getElementById("cryptoPlugin");
              	log_list = document.getElementById("token_login");
              	for (var i=log_list.options.length-1; i >= 0; i--) {
                  log_list.remove(i);
              	}
              	if (!plugin.valid) {
              		alert('Не установлен плагин для работы с USB-токеном');
              		return;
              	}
              	if (plugin.rtwIsTokenPresentAndOK()) {
              		count_cont=plugin.rtwGetNumberOfContainers();
              		for(i=0;i<count_cont;i++){
              			cont_name = plugin.rtwGetContainerName(i);
              			addOption(log_list, cont_name.replace("#%#", " - "), cont_name, 0,0);
              		}
              	} else {
              		alert('USB-токен отсутствует');
              	}
              }
              function addOption (oListbox, text, value, isDefaultSelected, isSelected) {
                var oOption = document.createElement("option");
                oOption.appendChild(document.createTextNode(text));
                oOption.setAttribute("value", value);
                if (isDefaultSelected) oOption.defaultSelected = true;
                else if (isSelected) oOption.selected = true;
                oListbox.appendChild(oOption);
              }
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