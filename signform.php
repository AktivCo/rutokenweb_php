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
            <li><a href="recovery.php">Восстановление доступа</a></li>
            <li class="current"><a href="signform.php">WEB-формы</a></li>
            <li><a href="api.php">API</a></li>
          </ul>
          <ul class="info">
            <li><a href="http://www.rutokenweb.ru/" target="_blank">Вернуться на RutokenWeb.ru</a></li>
          </ul>
        </div>
        <div class="data nake">
          <div class="text">
            <!-- Content -->
            <h1>Электронная подпись Web-форм</h1>
            <p>Возможности электронной цифровой подписи документов продемонстрирован на примере тестового платежного поручения.</p>
            <div class="accent order round_5px">
              <div class="message round_3px">
                <form id="i_form" method="POST" action="form.html">
	        				<input name="xtext" id="i_xtext" value="" type="hidden" />
  				      	<input name="xhash" id="i_xhash" value="" type="hidden" />
        					<input name="xsign" id="i_xsign" value="" type="hidden" />
        					<table class="order">
                    <tr>
                      <th><label>ФИО плательщика:</label></th>
                      <td><input name="fio" id="i_fio" value="СУХОВ Евгений Юрьевич, г. Москва, Пионерская ул, д. 3, кв. 72" type="text" /></td>
                    </tr><tr>
                      <th><label>Перевод со счета:</label></th>
                      <td><input name="schet" id="i_schet" value="42301810001000075212" type="text" /></td>
                    </tr><tr>
                      <th><label>Сумма перевода и валюта:</label></th>
                      <td><input name="summa" id="i_summa" value="150000" type="text" style="width:300px;" />
                          <select name="valuta" id="i_valuta" style="width:95px;">
                            <option value="RUR" selected="selected">RUR</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                          </select>
                      </td>
                    </tr><tr>
                      <th><label>Наименование получателя:</label></th>
                      <td><input name="poluch" id="i_poluch" value="Скрипкина Вероника Викторовна" type="text" /></td>
                    </tr><tr>
                      <th><label>Номер счета получателя:</label></th>
                      <td><input name="targschet" id="i_targschet" value="40817810338295201618" type="text" /></td>
                    </tr><tr>
                      <th><label>БИК банка получателя:</label></th>
                      <td><input name="bik" id="i_bik" value="044525225" type="text" /></td>
                    </tr><tr>
                      <th><label>Наименование банка получателя:</label></th>
                      <td><input name="bankpol" id="i_bankpol" value="ОАО &quot;Сбербанк России&quot; г. Москва" type="text" /></td>
                    </tr><tr>
                      <th><label>Номер счета банка получателя:</label></th>
                      <td><input name="schetbank" id="i_schetbank" value="30101810400000000225" type="text" /></td>
                    </tr><tr>
                      <th><label>Назначение платежа:</label></th>
                      <td><input name="naznach" id="i_naznach" value="Перевод личных средств" type="text" /></td>
                    </tr>
                    <tr id="sel">
                      <th><label>Ключ цифровой подписи:</label></th>
                      <td><select name="list_log" id="token_login">
		    			          	  <option selected="selected" value=""> -	</option>
              					  </select></td>
                    </tr><tr>
                      <th></th>
                      <td id="mess"></td>
                    </tr><tr>
                      <th>&nbsp;</th>
                      <td><button id="cancel" type="button">Отмена</button> <button id="ok" type="button">Подписать</button></td>
                    </tr>
                  </table>
                </form>
                <!-- Floaty Start -->
                <div id="block" class="overlay"></div>
                <div id="signed" class="round_5px">
                  <div id="headsigned">
                    <h2>Безопасная система интернет-банкинга</h2>
                    <p>Демонстрационное платежное поручение подписано плательщиком с помощью USB-токена Рутокен Web и отправлено в банк.</p>
                  </div>
                  <div id="bodysigned"></div>
                  <div id="stopsigned">
                    <form action="signform.php">
                      <button type="submit">Завершить процесс оплаты</button>
                    </form>
                  </div>
                </div>
                <!-- Floaty Stop -->
              </div>
            </div>
            <!-- / Content -->
            <object id="cryptoPlugin" type="application/x-rutoken" width="0" height="0">
              <param name="onload" value="pluginit" />
            </object>
            <script type="text/javascript">
              var plugin;
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
              $(document).ready(function() {
              	$( "#cancel" ).click(function() {
              		window.location.href='index.php';
              	});
              	$( "#ok" ).click(function() {
              		window.setTimeout("signorder()",100);
              	});
              });
              function signorder(){
              	$('#i_xtext').val('<!PINPADFILE RU><!>Тестовое платежное поручение<N>ФИО:<V>'+$('#i_fio').val()+
              	  '<N>Перевод со счета:<V>'+$('#i_schet').val()+
              		'<N>Сумма:<V>'+$('#i_summa').val()+
              		'<N>Валюта:<V>'+$('#i_valuta').val()+
              		'<N>Наименование получателя:<V>'+$('#i_poluch').val()+
        					'<N>Номер счета получателя<V>'+$('#i_targschet').val()+
        					'<N>БИК банка получателя:<V>'+$('#i_bik').val()+
        					'<N>Наименование банка получателя:<V>'+$('#i_bankpol').val()+
        					'<N>Номер счета банка получателя<V>'+$('#i_schetbank').val()+
        					'<N>Назначение платежа:<V>'+$('#i_naznach').val());
        				$('#i_xhash').val(Sha256.hash($('#i_xtext').val()));
              	if (!plugin.valid) {
			            alert('Не установлен плагин для работы с токеном');
            			return;
            		}
              	ltlog = document.getElementById('token_login');
            		res = plugin.rtwSign(ltlog.value, Sha256.hash($('#i_xtext').val()));
              	if ( res!=-7 && res!=-12 ) {
            			if	(res<0) {
          					$( "#mess" ).html(err[res]);
            			} else {
                  	hexres = '';
              			for (i=0; i<64; i++) {
              				hexres = hexres + ' ' + res.slice(i*2,i*2+2);
              			}
              			$('#bodysigned').html(
                      '<table class="order_report">'+
                      '<tr><th>Плательщик:</th><td>'+$('#i_fio').val()+'</td></tr>'+
                      '<tr><th>Перевод со счета:</th><td>'+$('#i_schet').val()+'</td></tr>'+
                      '<tr><th>Сумма перевода:</th><td>'+$('#i_summa').val()+''+$('#i_valuta').val()+'</td></tr>'+
                      '<tr><th>Получатель:</th><td>'+$('#i_poluch').val()+'</td></tr>'+
                      '<tr><th>Номер счета получателя:</th><td>'+$('#i_targschet').val()+'</td></tr>'+
                      '<tr><th>БИК банка получателя:</th><td>'+$('#i_bik').val()+'</td></tr>'+
                      '<tr><th>Наименование банка получателя:</th><td>'+$('#i_bankpol').val()+'</td></tr>'+
                      '<tr><th>Номер счета банка получателя:</th><td>'+$('#i_schetbank').val()+'</td></tr>'+
                      '<tr><th>Назначение платежа:</th><td>'+$('#i_naznach').val()+'</td></tr>'+
                      '<tr><th>Электронная цифровая подпись:</th><td>'+hexres+'</td></tr>'+
                      '</table>');
              	  		$('#signed').css('display','block');
              		  	$('#block').css('display','block');
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
              		for(i=0;i<count_cont;i++) {
              			cont_name = plugin.rtwGetContainerName(i);
              			addOption(log_list, cont_name.replace("#%#", " - "), cont_name, 0,0);
              		}
              	} else {
              		alert('USB-токен отсутствует');
              	}
              	window.setTimeout("token_refresh()",3000);
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