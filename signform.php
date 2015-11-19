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

    <div id="block" class="shadow"></div>

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
            <h1>Web-формы</h1>
          </hgroup>
          <!-- Content -->

          <div class="text">
            <p>Возможности электронной цифровой подписи документов с использованием USB-токена Рутокен Web продемонстрирован на примере тестового платежного поручения.</p>
              <div id="inf" class="inf"></div>
          </div>

          <div class="form thin" id="loadingdiv">
              Инициализация приложения...
          </div>

          <div class="form wide" style='padding-bottom: 100px; display:none;' id="waitforload" >
            <form method="post" id="i_form">
	        		<input name="xtext" id="i_xtext" value="" type="hidden" />
  				    <input name="xhash" id="i_xhash" value="" type="hidden" />
        			<input name="xsign" id="i_xsign" value="" type="hidden" />
              <table>
                <tbody>
                  <tr>
                    <th><label>Плательщик</label></th>
                    <td><input type="text" name="fio" id="i_fio" value="Иванов Иван Иванович" /></td>
                  </tr><tr>
                    <th><label>Номер счета плательщика</label></th>
                    <td><input type="text" name="schet" id="i_schet" value="42301810001000075212" /></td>
                  </tr><tr>
                    <th><label>Сумма перевода</label></th>
                    <td>
                      <input name="summa" id="i_summa" value="150000" type="text" style="width:251px;" />
                      <select name="valuta" id="i_valuta" style="width:95px;">
                        <option value="RUR" selected="selected">RUR</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                      </select>
                    </td>
                  </tr><tr>
                    <th>Получатель</th>
                    <td><input name="poluch" id="i_poluch" value="Петров Петр Петрович" type="text" /></td>
                  </tr><tr>
                    <th>Номер счета получателя</th>
                    <td><input name="targschet" id="i_targschet" value="40817810338295201618" type="text" /></td>
                  </tr><tr>
                    <th>Назначение платежа</th>
                    <td><input name="naznach" id="i_naznach" value="Перевод личных средств" type="text" /></td>
                  </tr><tr>
                    <th>Ключ ЭП</th>
                    <td>
                      <select name="list_log" id="token_login">
		    			          <option selected="selected" value=""> —	</option>
              				</select>
                    </td>
                  </tr><tr>
                    <th><label></label></th>
                    <td id="mess"></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th>&nbsp;</th>
                    <td>
                      <button id="no" type="button" class="refresh">Отмена</button>
                      <button id="go" type="submit" class="button">Подписать</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </form>
          </div>

          <div id="sign" class="popup">
            <h2>Безопасная система интернет-банкинга</h2>
            <p>Демонстрационное платежное поручение подписано плательщиком с помощью USB-токена Рутокен Web и отправлено в банк.</p>
            <table>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <td>
                    <button id="ok" class="button">Завершить процесс оплаты</button>
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>

  
<script>
var plugin,
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




function signorder() {
    $('#i_xtext').val(
      '<!PINPADFILE RU><!>Тестовое платежное поручение<N>Плательщик:<V>'+$('#i_fio').val()+
    	'<N>Номер счета плательщика:<V>'+$('#i_schet').val()+
		  '<N>Сумма перевода:<V>'+$('#i_summa').val()+
    	'<N>Валюта:<V>'+$('#i_valuta').val()+
		  '<N>Получатель:<V>'+$('#i_poluch').val()+
      '<N>Номер счета получателя<V>'+$('#i_targschet').val()+
      '<N>Назначение платежа:<V>'+$('#i_naznach').val()
    );
    $('#i_xhash').val(Sha256.hash($('#i_xtext').val()));

    ltlog = document.getElementById('token_login');
    plugin.rtwSign(ltlog.value, Sha256.hash($('#i_xtext').val()), undefined).then(function (res) {
       hexres = '';
            for (i = 0; i < 64; i++) {
                hexres = hexres + ' ' + res.slice(i*2,i*2+2);
            }
            $('.popup table tbody').html(
              '<tr><th>Плательщик</th><td>'+$('#i_fio').val()+'</td></tr>'+
              '<tr><th>Номер счета плательщика</th><td>'+$('#i_schet').val()+'</td></tr>'+
              '<tr><th>Сумма перевода</th><td>'+$('#i_summa').val()+''+$('#i_valuta').val()+'</td></tr>'+
              '<tr><th>Получатель</th><td>'+$('#i_poluch').val()+'</td></tr>'+
              '<tr><th>Номер счета получателя</th><td>'+$('#i_targschet').val()+'</td></tr>'+
              '<tr><th>Назначение платежа</th><td>'+$('#i_naznach').val()+'</td></tr>'+
              '<tr><th>Электронная подпись</th><td>'+hexres+'</td></tr>'
            );
            $('.popup').css('display','block');
            $('.block').addClass('show');
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
          <li><a href="login.php"><span>Авторизация</span></a></li>
          <li><a href="recovery.php"><span>Восстановление доступа</span></a></li>
          <li class="current"><a href="signform.php"><span>Web-формы</span></a></li>
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