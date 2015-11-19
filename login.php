<?php
	  session_start();

    if (isset($_POST['tlogin'])) {

        require_once ("crypto/token.php");
        include_once ("config.php");

        $login = $_POST['tlogin'];
      	$rand_num = hash('sha256', $_POST['rnd'] . ":" . $_SESSION[$login]);

      	$ses_r = $_SESSION[$login];
    	  $_SESSION[$login] = "";

      	$r_ecp = substr($_POST['user_sign'], 0, 64);
        $s_ecp = substr($_POST['user_sign'], 64);

        $query = mysql_query("SELECT user_id, user_xkey, user_ykey
                                FROM sample_users
                               WHERE user_login='".mysql_real_escape_string($login)."'
                               LIMIT 1");

        $my_count = mysql_num_rows($query);

        if ( !$my_count ) {

            $message = "Пользователь <strong>" . $login . "</strong> не зарегистрирован!";
            $status = "poor";

        } else {

            $data = mysql_fetch_assoc($query);

            $x_pkey = $data['user_xkey'];
            $y_pkey = $data['user_ykey'];

            $client_get = "<p>Получено клиентом: <br> <span class='logs'>" . $ses_r . "</span></p>";
            $client_out = "<p>Отправлено клиентом: <br><span class='logs'>" . print_r($_POST, true) . "</span></p>";

            $verify = token_verify($rand_num, $x_pkey, $y_pkey, $r_ecp, $s_ecp);

            if ( $verify ) {

              $message = "Пользователь <strong>" . $login . "</strong> авторизован с использованием устройства Рутокен";
              $status = "good";

            } else {

              $message = "Доступ запрещен!";
              $status = "poor";

            }

        }

    }

?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Демо-площадка Рутокен: Рутокен Web и PHP</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/styles.css" />
    <script src="/script/jquery.js"></script>
    <script src="/script/jquery_custom.js"></script>
  	<script src="/script/sha256.js"></script>
    <script src="/script/utf8.js"></script>
  	<script src="/script/base64.js"></script>
      <script type="text/javascript" src="/script/es6promise.js"></script>
      <script type="text/javascript" src="/script/rutokenweb.js"></script>
    <!--[if lt IE 9]>
      <script src="/script/spike_html5.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
      <script src="/script/spike_iefix.js"></script>
      <link rel="stylesheet" href="/css/styles_for_IE7.css" />
    <![endif]-->
  </head>
  <body>
    <header>
      <dl>
        <dt><a href="index.php"><img src="/images/logo.png" width="225" height="71" alt="" /></a></dt>
        <dd>Демонстрационная площадка: <span>Рутокен Web + PHP</span></dd>
      </dl>
    </header>
    <section class="jump">
      <nav>
        <ul>
          <li class="current"><a href="index.php">Демонстрация</a></li>
          <li><a href="api_methods.php">API плагина Рутокен Web</a> </li>
          <li><a href="http://www.rutoken.ru/support/download/rutoken-web/">Загрузить</a></li>
        </ul>
      </nav>
    </section>

    <section class="content">
      <div class="wrap">
        <article>
          <hgroup>
            <h1>Авторизация</h1>
          </hgroup>
          <!-- Content -->

          <div class="text">
            <p>Воспользуйтесь кнопкой «Обновить» для вывода актуального списка учетных записей, сохраненных на USB-токене. Для аутентификации выберите логин в выпадающем списке и нажмите кнопку «Войти». Далее потребуется ввести правильный PIN-код.</p>
              <div id="inf" class="inf"></div>
          </div>

          <div class="form thin" id="loadingdiv">
              Инициализация приложения...
          </div>

          <div class="form thin" id="waitforload" style="display:none;">
            <form method="post" id="logform">
              <input type="hidden" name="user_sign"  id="user_sign" value="" />
              <input type="hidden" name="tlogin" id="token_log" value="" />
              <input type="hidden" name="rnd" id="rnd_client" value="" />
              <table>
                <tbody>
                  <tr>
                    <th><label>Логин пользователя</label></th>
                    <td>
                      <select  tabindex="1" name="list_log" id="token_login">
                    	  <option selected="selected" value="none"> — </option>
                      </select>
                    </td>
                  </tr>
                  <?php if ( $message ) { $res  = "
                  <tr>
                    <th>&nbsp;</th>
                    <td class='" . $status . "'>" . $message . "</td>
                </tr> "; } echo $res; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>&nbsp;</th>
                    <td>
                      <button class='refresh' tabindex="3" type="button" onclick="token_refresh()">Обновить</button>
                      <button tabindex="2" type="button" onclick="rndGet()">Войти</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </form>
          </div>
          <?php
            if ( $client_get || $client_out ) {
            echo "
              <div class='slider detail'>
                <dl>
                  <dt><h2><span>Журнал обмена данными</span></h2></dt>
                  <dd>" . $client_get . $client_out . "</dd>
                </dl>
              </div>";
            }
          ?>
          <div class='slider detail'>
            <dl>
              <dt><h2><span>Справочная информация</span></h2></dt>
              <dd>
                <p>Для аутентификации при помощи USB-токенa Рутокен Web пользователю необходимо предварительно пройти процедуру регистрации.</p>
                <p>Напомним, что при успешной регистрации, в памяти USB-токена сохраняется ключевая пара <br> <strong>(e_(Login, SiteName),d_(Login, SiteName))</strong>, предназначенная для защищенной аутентификации пользователя c логином <strong>Login</strong> на Web-сайте <strong>SiteName</strong>. Установка соответствия между открытым ключом <strong>e_(Login, SiteName)</strong> и логином <strong>Login</strong> осуществляется на стороне Web-сервера, под управлением которого работает Web-сайт <strong>SiteName</strong>.</p>
              </dd>
            </dl>
          </div>

<script>
var plugin,
     http = new XMLHttpRequest(),
     random_text = "",
     current_user = "",
    inf = document.getElementById('inf'),
    loadingdiv = document.getElementById('loadingdiv'),
    waitforload = document.getElementById('waitforload');

var err = [];
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




window.onload = function () {
    rutokenweb.ready.then(function () {
        if (window.chrome) {
            return rutokenweb.isExtensionInstalled();
        } else {
            return Promise.resolve(true);
        }
    }).then(function (result) {
        if (result) {
            return rutokenweb.isPluginInstalled();
        } else {
            throw "Rutoken Web Extension wasn't found";
        }
    }).then(function (result) {
        if (result) {
            return rutokenweb.loadPlugin();
        } else {
            throw "Rutoken Web Plugin wasn't found";
        }
    }).then(function (pluginPromised) {
        //Можно начинать работать с плагином
        plugin = pluginPromised;

        waitforload.style.display = 'block';
        loadingdiv.style.display = 'none';

        token_refresh();
        //Только для работы через старый интерфейс плагина
        //  return plugin.wrapWithOldInterface();
    }).then(function (wrappedPlugin) {
        //Можно начинать работать через старый интерфейс плагина
    }).then(undefined, function (reason) {
        console.log(reason);
        inf.innerHTML = reason;
    });
}




function rndReply() {
	if (http.readyState == 4) {
		if (http.readyState == 4) {
			random_text = http.responseText;
			token_sign();
		}
	}
}

function rndGet() {
  random_text = '';
	ltlog = document.getElementById('token_login');
	logstr = ltlog.value;
	if (logstr == "none") {
		alert("Выберите учетную запись на USB-токене.");
	} else {
		tlog = document.getElementById('token_log');
		tlog.value = logstr.substr(0, logstr.indexOf("#%#"));
		if ((current_user == tlog.value) && (random_text != "")) {
			token_sign();
		} else {
			current_user = tlog.value;
			nocache = Math.random();
			http.open('get', 'random.php?tlogin='+encodeURI(tlog.value)+'&nocache='+nocache);
			http.onreadystatechange = rndReply;
			http.send(null);
		}
	}
}



function token_sign() {

	clrnd = document.getElementById('rnd_client');
	rd = Math.random().toString(16);
	clrnd.value = Sha256.hash(rd);
	random_text = Sha256.hash(clrnd.value + ':'+ random_text);
	tsign = document.getElementById('user_sign');
	ltlog = document.getElementById('token_login');



	plugin.rtwSign(ltlog.value, random_text, undefined).then(function (res) {
          tsign.value = res;
          tform = document.getElementById('logform');
          tform.submit();
  }).then(undefined, function (reason) {
        // все ошибки пробрасываются в последнее звено промисов.
        console.log(reason);
        inf.innerHTML = err[reason.message || reason] || reason;
    });

}

function token_refresh() {
	log_list = document.getElementById("token_login");
	for (var i = log_list.options.length - 1; i >= 0; i--) {
    log_list.remove(i);
	}

    plugin.rtwIsTokenPresentAndOK().then(function (isTokenPresent) {
        if(isTokenPresent === true){
            return plugin.rtwGetNumberOfContainers();
        } else{
            throw "Подключите USB-токен!";
        }
    }).then(function (containers_count) {
        var promises = [];
        for (var i = 0; i < containers_count; i++ ){
            promises.push(plugin.rtwGetContainerName(i));
        }
        return Promise.all(promises);
    }).then(function (containers_names) {
        containers_names.forEach(function(cont_name){
          addOption(log_list, cont_name.replace("#%#", " - "), cont_name, 0, 0);
        });
    }).then(undefined, function (reason) {
        // все ошибки пробрасываются в последнее звено промисов.
        console.log(reason);
        inf.innerHTML = err[reason.message || reason] || reason;
    });



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

          <!-- /Content -->
        </article>
      </div>
      <nav>
        <ul>
          <li><a href="register.php"><span>Регистрация</span></a></li>
          <li class="current"><a href="login.php"><span>Авторизация</span></a></li>
          <li><a href="recovery.php"><span>Восстановление доступа</span></a></li>
          <li><a href="signform.php"><span>Web-формы</span></a></li>
        </ul>
      </nav>
    </section>

    <footer class="footer">
      <dl>
        <dt>1994 — <? echo  date("Y"); ?> © <a href="http://www.aktiv-company.ru/" target="_blank"><span>Компания «Актив»</span></a></dt>
        <dd><a href="http://www.rutoken.ru/" target="_blank"><span>www.rutoken.ru</span></a></dd>
      </dl>
    </footer>
  </body>
</html>