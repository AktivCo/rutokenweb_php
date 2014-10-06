<?
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
            <li><a href="login.php">Аутентификация</a></li>
            <li class="current"><a href="recovery.php">Восстановление доступа</a></li>
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
            <h1>Восстановление доступа</h1>
            <p>Для восстановления доступа введите логин пользователя и ключ восстановления, скрытый под защитным слоем скретч-карты.</p>
            <div class="accent round_5px">
              <div class="message round_3px">
                <?
                  if(isset($_POST['login'])) {
                  	require_once('crypto/token.php');
                  	include_once "config.php";
                  	$rand_num = $_SESSION[$_POST['login']];
                  	$_SESSION[$_POST['login']]="";
                  	$r_ecp=substr($_POST['user_sign'],0,64);
                  	$s_ecp=substr($_POST['user_sign'],64);
                    $query = mysql_query("SELECT user_id, r_xkey, r_ykey FROM sample_users WHERE user_login='".mysql_real_escape_string($_POST['login'])."' LIMIT 1");
                    $my_count = mysql_num_rows($query);
                  	if ($my_count != '0' ) {
                  		$data = mysql_fetch_assoc($query);
                  		$x_pkey=$data['r_xkey'];
                  		$y_pkey=$data['r_ykey'];
                    	echo "<p style=\"margin: 0;\">Получено клиентом:</p><pre style=\"margin: 0; padding: 0; font-family: Consolas; font-style: italic; font-size: 10px; color: #888;\">";
                    	echo $r_ecp.$s_ecp;
                    	echo "</pre>";
                    	echo "<p style=\"margin: 0;\">Отправлено клиентом:</p><pre style=\"margin: 0; padding: 0; font-family: Consolas; font-style: italic; font-size: 10px; color: #888;\">";
                    	print_r($_POST);
                  	  echo "</pre>";
                   		if (token_verify($rand_num,$x_pkey,$y_pkey,$r_ecp,$s_ecp)) {
                      	echo "<p style=\"margin-top: 10px; color: green;\"><strong>Доступ получен!</strong><br />Доступ к аккаунту для пользователя <strong>".$_POST['tlogin']."</strong> восстановлен.</p>";
                    	} else {
                  			print "<p style=\"margin-top: 10px; color:red;'\">Доступ запрещен!</p>";
                  		}
                  	} else {
                  		print "<p style=\"margin-top: 10px; color:red;\">Пользователь <strong>".$_POST['login']."</strong> не зарегистрирован!</p>";
                  	}
                    echo "";
                  }
                ?>
                <form method="POST" id="logform">
                  <input type="hidden" name="user_sign"  id="user_sign" value="" />
                  <table>
                    <tr>
                      <th><label>Логин пользователя:</label></th>
                      <td><input style="width: 200px;" name="login" id="user_login" type="text" /></td>
                      <tr>
                        <th><label>Ключ восстановления:</label></th>
                        <td>
                          <input  style="width: 200px;" name="repair_key" id="user_rkey" type="text" value="EEYF-BWFE-RZES-RZZV-RDEC-ACZX-VQAX-DSDQ-YARY-FCQT-YCRY-AAYR-WDFW-EBTZ-VETT-ZESA">
                          <button type="button" onclick="rndGet()">Восстановить доступ</button>
                        </td>
                      </tr>

                    </tr>
                  </table>
                </form>
              </div>
            </div>
            <h2>Краткая справка</h2>
            <p>В случае утери USB-токена, пользователь может вновь получить доступ к персональным разделам Web-сайтов, на которых он зарегистрирован, при помощи механизма ключей восстановления. Для этого, при изготовлении USB-токена, генерируется дополнительная ключевая пара — открытый и закрытый ключи восстановления:</p>
            <ul>
              <li>Открытый ключ восстановления <strong>e_Recovery</strong> помещается в память USB-токена. При регистрации пользователя он передается на сервер вместе с открытым ключом пользователя <strong>e_(Login, SiteName)</strong>.</li>
              <li>Закрытый ключ восстановления <strong>d_Recovery</strong> печатается под защитным слоем на скретч-карте (наряду с PIN-кодом и PUK-кодом).</li>
            </ul>
            <p>При утере USB-токена Рутокен Web, пользователю необходимо стереть защитный слой со скретч-карты и ввести код восстановления в соответствующее поле формы.</p>
            <!-- / Content -->
            <object id="cryptoPlugin" type="application/x-rutoken" width="0" height="0">
              <param name="onload" value="pluginit" />
            </object>
            <script type="text/javascript">
              var plugin;
              var http = createObject();
              var random_text="";
              var current_user="";

              function rndReply() {
              	if (http.readyState == 4) {
              		if (http.readyState == 4) {
              			random_text=http.responseText;
              			text_sign();
              		}
              	}
              }
              function rndGet() {
              	ltlog = document.getElementById('user_login');
              	logstr=ltlog.value;
              	if (logstr=="none") {
              		alert("Введите логин");
              	} else {
              		if ((current_user==logstr)&&(random_text!="")) {
              			text_sign();
              		} else {
              			current_user=logstr;
              			nocache = Math.random();
              			http.open('get', 'random.php?tlogin='+encodeURI(logstr)+'&nocache='+nocache);
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
              function text_sign() {
              	if (!plugin.valid) {
              		alert('Не установлен плагин для работы с USB-токеном');
              		return;
              	}
                tsign = document.getElementById('user_sign');
              	ukey = document.getElementById('user_rkey');
              	usr_key = ukey.value.replace(/-/g, "")
              	ltlog = document.getElementById('token_login');
              	tsign.value = plugin.rtwRepair(usr_key, random_text);
              	if (tsign.value) {
                  ukey.value="key";
              		tform = document.getElementById('logform');
              		tform.submit();
              	} else {
              	  alert("Ошибка при создании подписи.");
              	}
              }
              function token_refresh() {
              	plugin=document.getElementById("cryptoPlugin");
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