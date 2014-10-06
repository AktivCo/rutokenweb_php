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
  <body  onload='plug_init();'>
    <div class="layout">
      <div class="global">
        <div class="head">
          <a class="logo" href="/"><img src="images/logo.png" border="0" width="220" height="120" alt="" /></a>
          <div class="slogan">Строгая аутентификация Рутокен Web — примеры использования в Web-приложениях, написанных на PHP</div>
        </div>
        <div class="menu">
          <ul class="base">
            <li><a href="index.php">Главная</a></li>
            <li><a href="register.php">Регистрация</a></li>
            <li><a href="login.php">Аутентификация</a></li>
            <li><a href="recovery.php">Восстановление доступа</a></li>
            <li><a href="signform.php">WEB-формы</a></li>
            <li class="current"><a href="api.php">API</a></li>
          </ul>
          <ul class="info">
            <li><a href="http://www.rutokenweb.ru/" target="_blank">Вернуться на RutokenWeb.ru</a></li>
          </ul>
        </div>
        <div class="data nake">
          <div class="text">
            <!-- Content -->
            <h1>API плагина Рутокен Web</h1>
          	<p>Плагин Рутокен Web работает в контексте браузера и предназначен для использования возможностей USB-токена функциональными элементами Web-приложений. Плагин использует следующие функции с префиксом <strong>rtw</strong>:
            <div id="pluginContainer">
              <object height="0" width="0" type="application/x-rutoken" id="testPlugin"></object>
            </div>
            <script type="text/javascript">
              var http = createObject();
              var plugin;
              var err =[];
              err[true] = "TRUE";
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
              function delete_cont() {
                if (!plugin.valid) {
                  alert('Не установлен плагин для работы с USB-токеном');
                  return;
                }
                ltlog = document.getElementById('token_login');
              	res = plugin.rtwDestroyContainer(ltlog.value);
              	if ( res!=-7 && res!=-12 ) {
                  if	(res<0) {
                    alert(err[res]);
                  } else {
                    alert('Container ' + ltlog.value + ' destroy = ' + res);
                    token_refresh();
                  }
                }
              }
              function create_cont() {
                if (!plugin.valid) {
              	  alert('Не установлен плагин для работы с USB-токеном');
              		return;
                }
                ltlog = document.getElementById('cont_name');
                res = plugin.rtwGenKeyPair(ltlog.value);
                if ( res!=-7 && res!=-12 ) {
                  if	(res<0) {
                    alert(err[res]);
                  } else {
                    alert('Create new container ' + ltlog.value + ' = ' + res);
                    token_refresh();
                  }
                }
              }
              function text_sign() {
                if (!plugin.valid) {
                  alert('Не установлен плагин для работы с USB-токеном');
                  return;
                }
                lhash = document.getElementById('hash');
                ukey = document.getElementById('priv_key');
                usr_key = ukey.value.replace(/-/g, "")
                res = plugin.rtwRepair(usr_key, lhash.value);
                if ( res!=-7 && res!=-12 ) {
                  if	(res<0) {
                    alert(err[res]);
                  } else {
                    alert('Sign by priv_key = ' + res);
                  }
                }
              }
              function sign_cont() {
                if (!plugin.valid) {
                  alert('Не установлен плагин для работы с USB-токеном');
                  return;
                }
                ltlog = document.getElementById('token_login');
                lhash = document.getElementById('hash');
                res = plugin.rtwSign(ltlog.value,lhash.value);
                if ( res!=-7 && res!=-12 ) {
                  if	(res<0) {
                    alert(err[res]);
                  } else {
                    alert('Sign by token = ' + res);
                    token_refresh();
                  }
                }
              }
              function plug_init() {
                plugin=document.getElementById("testPlugin");
                token_refresh();
                return;
              }
              function isObject(obj) {
                if (typeof obj != "object" || obj === null)
                return false;
                else
                return true;
              }
              function token_refresh() {
                log_list = document.getElementById("token_login");
                for (var i=log_list.options.length-1; i >= 0; i--) {
                  log_list.remove(i);
                }
                if (plugin.rtwIsTokenPresentAndOK()) {
                  count_cont=plugin.rtwGetNumberOfContainers();
                  for(i=0;i<count_cont;i++) {
                    c_name = plugin.rtwGetContainerName(i);
                    addOption(log_list, c_name.replace("#%#", " - "), c_name, 0,0);
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
            <form>
              <h3>variant rtwIsTokenPresentAndOK();</h3>
              <p style="margin-bottom: 7px;">Функция проверяет наличие и работоспособность USB-токена Рутокен Web. Если USB-токен подключен к USB-порту компьютера, исправен и работает, то функция возвращает TRUE. В противном случае функция вернет код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  <button type="button" onclick="alert('Token is inserted = ' + err[plugin.rtwIsTokenPresentAndOK()]);">rtwIsTokenPresentAndOK()</button>
                </div>
              </div>
              <h3>variant rtwGetNumberOfContainers();</h3>
              <p style="margin-bottom: 7px;">Функция позволяет получить количество контейнеров на USB-токене Рутокен Web. Возвращает количество контейнеров или код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  <button type="button" onclick="alert('Number of container = ' + plugin.rtwGetNumberOfContainers());">rtwGetNumberOfContainers()</button>
                </div>
              </div>
              <h3>variant rtwUserLoginDlg();</h3>
              <p style="margin-bottom: 7px;">Функция вызывает окно для ввода PIN-кода USB-токена Рутокен Web. При верном вводе PIN-кода возвращает TRUE, иначе – код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  <button type="button" onclick="plugin.rtwUserLoginDlg();">rtwUserLoginDlg()</button>
                </div>
              </div>
              <h3>variant rtwLogout();</h3>
              <p style="margin-bottom: 7px;">Функция выполняет сброс прав пользователя USB-токена Рутокен Web. Возвращает TRUE или код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  <button type="button" onclick="alert('Logout is '+ plugin.rtwLogout());">rtwLogout()</button>
                </div>
              </div>
              <h3>variant rtwGenKeyPair(const variant& contName);</h3>
              <p style="margin-bottom: 7px;">Функция позволяет сгенерировать ключевую пару — открытый и закрытый ключи для контейнера с именем <strong>contName</strong>. Возвращает открытый ключ или код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  Сreate_contname: <input type="text" name="cont_name" size="20" id="cont_name" value="" />
                  <button type="button" onclick="create_cont();">rtwGenKeyPair(create_contname)</button>
                </div>
              </div>
              <h3>variant rtwSign(const variant& contName, const variant& msg2Sign);</h3>
              <p style="margin-bottom: 7px;">Функция позволяет подписать хэш <strong>msg2Sign</strong> при помощи алгоритма ЭЦП ГОСТ Р 34.10-2001 с использованием закрытого ключа контейнера <strong>contName</strong>. Возвращает ЭЦП или код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  Hash: <input type="text" name="hash" id="hash" size="80" value="2BE1AFE68F9FE586F36C626FABF9DFC316491742EC793388EFADDE81FE34F3DC" />
                  <button type="button" onclick="sign_cont();">rtwSign(contname, hash)</button>
                </div>
              </div>
              <h3>variant rtwRepair(const variant& privKey, const variant& msg2Sign);</h3>
              <p style="margin-bottom: 7px;">Функция позволяет подписать хэш <strong>msg2Sign</strong> при помощи алгоритма ЭЦП ГОСТ Р 34.10-2001 с использованием внешнего закрытого ключа <strong>privKey</strong>. Возвращает ЭЦП или код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  Priv_key: <input type="text" name="pkey" id="priv_key" size="80" value="2BE1AFE68F9FE586F36C626FABF9DFC316491742EC793388EFADDE81FE34F3DC" />
                  <button type="button" onclick="text_sign();">rtwRepair(priv_key, hash)</button>
                </div>
              </div>
              <h3>variant rtwIsUserLoggedIn();</h3>
              <p style="margin-bottom: 7px;">Функция проверяет, осуществлен ли вход на USB-токен Рутокен Web с правами пользователя. В случае положительного ответа, возвращает TRUE, иначе — код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  <button type="button" onclick="alert(err[plugin.rtwIsUserLoggedIn()]);">rtwIsUserLoggedIn()</button>
                </div>
              </div>
              <h3>FB::variant get_version();</h3>
              <p style="margin-bottom: 7px;">Узнать версию плагина Рутокен Web к браузеру.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
                  <button type="button" onclick="alert(plugin.get_version());">get_version()</button>
                </div>
              </div>
              <h2>Функции для работы с контейнерами</h2>
              <p>Для демонстрации следующих функций необходимо выбрать на USB-токене Рутокен Web контейнер из списка доступных.</p>
              <h3>variant rtwGetContainerName(const variant& contIndex);</h3>
              <p>Получить имя контейнера по заданному индексу контейнера <strong>contIndex</strong>. Функция может использоваться для построения списка записей. Возвращает имя контейнера или код ошибки.</p>
              <h3>variant rtwGetPublicKey(const variant& contName);</h3>
              <p>Получить открытый ключ по заданному имени контейнера <strong>contName</strong>. Возвращает открытый ключ или код ошибки.</p>
              <h3>variant rtwDestroyContainer(const variant& contName);</h3>
              <p>Удалить контейнер с именем <strong>contName</strong>. Возвращает TRUE или код ошибки.</p>
              <div class="accent api round_5px">
                <div class="message round_3px">
              		<select id="token_login" name="list_log">
                    <option selected="selected" value="none"> - </option>
              		</select>
                  <button type="button" onclick="token_refresh()" title="Обновить">&darr;&uarr;</button>
            	  	<button type="button" onclick="alert('Public key '+ document.getElementById('token_login').value + ' = ' + plugin.rtwGetPublicKey(document.getElementById('token_login').value));">rtwGetPublicKey(contname)</button>
            		  <button type="button" onclick="alert('Repair public key = ' + plugin.rtwGetPublicKey('repair key'));">rtwGetPublicKey('repair key')</button>
                  <button type="button" onclick="delete_cont()">rtwDestroyContainer(contname)</button>
                </div>
              </div>
              <h2>Коды ошибок</h2>
              <p>
                <script type="text/javascript">
              	  for (i=0;i>-100;i--) {
            	  	  if(err[i] != undefined)
           			    document.write(' <b style="display: inline-block; width: 25px; text-align: right;"> '+i+ '</b> &rarr; '+err[i]+ '<br />');
                	}
                </script>
              </p>
            </form>
            <!-- / Content -->
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