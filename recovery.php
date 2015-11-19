<?
    session_start();

    if(isset($_POST['login'])) {

        require_once('crypto/token.php');
        include_once "config.php";

        $rand_num = $_SESSION[$_POST['login']];
        $_SESSION[$_POST['login']] = "";

        $r_ecp = substr($_POST['user_sign'], 0, 64);
        $s_ecp = substr($_POST['user_sign'], 64);

        $query = mysql_query("SELECT user_id, r_xkey, r_ykey FROM sample_users WHERE user_login='".mysql_real_escape_string($_POST['login'])."' LIMIT 1");
        $my_count = mysql_num_rows($query);

        if ( !$my_count ) {

            $message = "Пользователь <strong>".$_POST['login']."</strong> не зарегистрирован!";
            $status = "poor";

        } else {

            $data = mysql_fetch_assoc($query);

            $x_pkey=$data['r_xkey'];
            $y_pkey=$data['r_ykey'];

            $client_get = "<p>Получено клиентом: <br> <span class='logs'>" . $r_ecp.$s_ecp . "</span></p>";
            $client_out = "<p>Отправлено клиентом: <br> <span class='logs'>" . print_r($_POST, true) . "</span></p>";

            $verify = token_verify($rand_num, $x_pkey, $y_pkey, $r_ecp, $s_ecp);

            if ( $verify ) {

              $message = "Доступ к аккаунту для пользователя <strong>".$_POST['tlogin']."</strong> восстановлен!";
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
  <body onload="token_refresh()">
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
            <h1>Восстановление доступа</h1>
          </hgroup>
          <!-- Content -->

          <div class="text">
            <p>Для восстановления доступа введите логин пользователя и ключ восстановления, скрытый под защитным слоем скретч-карты, прилагаемой к USB-токену Рутокен Web.</p>
             <div id="inf" class="inf"></div>
          </div>

<div class="form thin" id="loadingdiv">
              Инициализация приложения...
          </div>

          <div class="form thin" id="waitforload" style="display:none;">
            <form method="post" id="logform" action="recovery.php">
              <input type="hidden" name="user_sign" id="user_sign" value="" />
              <table>
                <tbody>
                  <tr>
                    <th><label>Логин пользователя</label></th>
                    <td><input name="login" id="user_login" type="text" /></td>
                  </tr>
                  <tr>
                    <th><label>Ключ восстановления</label></th>
                    <td><input type="text" name="repair_key" id="user_rkey" value="EEYF-BWFE-RZES-RZZV-RDEC-ACZX-VQAX-DSDQ-YARY-FCQT-YCRY-AAYR-WDFW-EBTZ-VETT-ZESA" /></td>
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
                    <td><button type="submit" onclick="rndGet()">Восстановить доступ</button></td>
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
                <p>В случае утери USB-токена Рутокен Web, пользователь может вновь получить доступ к персональным разделам Web-сайтов, на которых он зарегистрирован, при помощи механизма ключей восстановления. Для этого при изготовлении USB-токена генерируется дополнительная ключевая пара — открытый и закрытый ключи восстановления: </p>
                <ul>
                  <li>Открытый ключ восстановления <strong>e_Recovery</strong> помещается в память USB-токена. При регистрации пользователя он передается на сервер вместе с открытым ключом пользователя <strong>e_(Login, SiteName)</strong>.</li>
                  <li>Закрытый ключ восстановления <strong>d_Recovery</strong> печатается под защитным слоем на скретч-карте (наряду с PIN-кодом и PUK-кодом).</li>
                </ul>
                <p>При утере USB-токена Рутокен Web, пользователю необходимо стереть защитный слой со скретч-карты и ввести код восстановления в соответствующее поле формы.</p>
              </dd>
            </dl>
          </div>

<script>
var plugin,
   http = new XMLHttpRequest(),
   random_text="",
   current_user="",
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
	err[-72] = 'Некорректный код восстановления';




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
			random_text=http.responseText;
			text_sign();
		}
	}
}
function rndGet() {
	ltlog = document.getElementById('user_login');
	logstr=ltlog.value;
	if (logstr=="none") {
		inf.innerHTML = "Введите логин";
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


function text_sign() {
	if (!plugin.valid) {
		alert('Не установлен плагин для работы с USB-токеном');
		return;
	}
  tsign = document.getElementById('user_sign');
	ukey = document.getElementById('user_rkey');
	usr_key = ukey.value.replace(/-/g, "")
	ltlog = document.getElementById('token_login');

	plugin.rtwRepair(usr_key, random_text).then(function (signValue) {
    tsign.value = signValue;
     ukey.value="key";
    tform = document.getElementById('logform');
    tform.submit();
  }).then(undefined, function (reason) {
        // все ошибки пробрасываются в последнее звено промисов.
        console.log(reason);
        inf.innerHTML = err[reason.message || reason] || reason;
    });
	
}




            </script>
          <!-- /Content -->
        </article>
      </div>
      <nav>
        <ul>
          <li><a href="register.php"><span>Регистрация</span></a></li>
          <li><a href="login.php"><span>Авторизация</span></a></li>
          <li class="current"><a href="recovery.php"><span>Восстановление доступа</span></a></li>
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