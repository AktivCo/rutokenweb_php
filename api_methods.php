<!DOCTYPE HTML>
<html>
  <head>
    <title>Демо-площадка Рутокен: Рутокен Web и PHP</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/css/layout.css" />
    <link rel="stylesheet" href="/css/styles.css" />
  	<link rel="stylesheet" href="/script/syntax/shCore.css" />
	  <link rel="stylesheet" href="/script/syntax/shCoreDefault.css" />
    <script src="/script/jquery.js"></script>
    <script src="/script/jquery_custom.js"></script>
  	<script src="/script/sha256.js"></script>
    <script src="/script/utf8.js"></script>
  	<script src="/script/base64.js"></script>
  	<script src="/script/rutokenwebtest.js"></script>
    <script src="/script/syntax/shCore.js"></script>
    <script src="/script/syntax/shBrushJScript.js"></script>
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
          <li><a href="index.php">Демонстрация</a></li>
          <li class="current"><a href="api_methods.php">API плагина Рутокен Web</a> </li>
          <li><a href="http://www.rutoken.ru/support/download/rutoken-web/">Загрузить</a></li>
        </ul>
      </nav>
    </section>

    <section class="content">
    <div id="inf" class="inf"></div>
    <div class="wrap" id="loadingdiv">
              Инициализация приложения...
          </div>


      <div class="wrap" style='display:none;' id="waitforload">
        <article>
          <hgroup>
            <h1>Методы</h1>
          </hgroup>
          <!-- Content -->

          <div class="text midst">
            <p>Плагин Рутокен Web работает в контексте браузера, совместим со всеми современными браузерами, и предназначен для использования возможностей USB-токена функциональными элементами Web-приложений. В этом разделе представлен перечень функций, используемй плагином.</p>

          <div class='slider detail'>
            <dl>
              <dt><h2><span>Дополнительные возможности</span></h2></dt>
              <dd>
              <p>Перегрузки некоторых функций позволяют использовать: </p>
              <ul class="string">
                <li>Qt-CSS для стилизации окна ввода пин-кода;</li>
                <li>Callback-функцию, выполняемую с результатом после его получения;</li>
                <li>Callback-функцию, выполняемую в случае получения ошибки.</li>
              </ul>
              <p>Вы можете определить свой CSS здесь: </p>
                <textarea id="qtcss" rows="8" cols="70">
* {
  background-color: transparent;
}
QPushButton {
  min-width: 75px;
  min-height: 25px;
  border-radius: 5px;
  background-color: #fff;
  font-weight: bold;
  color: #284;
}
QPushButton:hover {
  background-color: #eee;
  color: #173;
}
QLabel {
  color: #fff;
}
QLineEdit {
  padding-top: 3px;
  padding-bottom: 3px;
  background-color: #fff;
  color: #284;
}
QDialog {
  background-color: #284;
}
                </textarea>
              </dd>
            </dl>
          </div>

          <div class="text functions">

            <h2>Базовые функции</h2>

            <h3>get_version();</h3>
            <p>Функция возвращает номер версии плагина.</p>
            <div class="accent api" data-func="get_version">
              <button class="test" data-test="get_version">get_version()</button>
              <div class="result"></div>
            </div>

            <h3>rtwIsTokenPresentAndOK();</h3>
            <p>Функция проверяет наличие и работоспособность USB-токена Рутокен Web. Если USB-токен подключен к USB-порту компьютера, исправен и работает, то функция возвращает TRUE. В противном случае функция вернет код ошибки.</p>
            <div class="accent api" data-func="rtwIsTokenPresentAndOK">
              <button class="test" data-test="rtwIsTokenPresentAndOK">rtwIsTokenPresentAndOK()</button>
              <div class="result"></div>
            </div>

            <h3>rtwGetDeviceID();</h3>
            <p>Функция возвращает уникальный серийный номер токена.</p>
            <div class="accent api" data-func="rtwGetDeviceID">
              <button class="test" data-test="rtwGetDeviceID" class="">rtwGetDeviceID()</button>
              <div class="result"></div>
            </div>

            <h3>rtwGetNumberOfContainers();</h3>
            <p>Функция позволяет получить количество контейнеров на USB-токене Рутокен Web. Возвращает количество контейнеров или код ошибки.</p>
            <div class="accent api" data-func="rtwGetNumberOfContainers">
              <button class="test"  type="button" data-test="rtwGetNumberOfContainers">rtwGetNumberOfContainers()</button>
              <div class="result"></div>
            </div>

            <h3>rtwGenKeyPair(container_name);</h3>
            <p><span>rtwGenKeyPair( container_name , css );</span> <br> Функция позволяет сгенерировать ключевую пару — открытый и закрытый ключи для контейнера с именем <strong>contName</strong>. Возвращает открытый ключ или код ошибки.</p>
            <p>Для демонстрации введите имя контейнера:</p>
            <div class="form thin">
                <input id="cont_name" type="text" name="cont_name" value="test_container_name" style="width: 210px;" />
            </div>
            <div class="accent api" data-func="rtwGenKeyPair">
              <!-- <button class="test" data-test="rtwGenKeyPair">rtwGenKeyPair(container_name)</button> -->
              <div class="clear"></div>
              <button class="test" data-test="rtwGenKeyPair_CSS_CallBack">rtwGenKeyPair(container_name, css)</button>
              <p class="clear">Открытый ключ созданного контейнера:
              <div id="newpubkey" class="result"></div></p>
            </div>

            <h2>Функции для работы с контейнерами</h2>
            <p>Для демонстрации следующих функций необходимо выбрать на USB-токене Рутокен Web контейнер из списка доступных.</p>

            <h3>rtwGetContainerName(contIndex);</h3>
            <p>Получить имя контейнера по заданному индексу контейнера contIndex. Функция может использоваться для построения списка записей. Возвращает имя контейнера или код ошибки.</p>

            <div class="accent api" data-func="rtwGetPublicKey">
              <div class="form thin">
                <select id="token_login" name="list_log" style='float: left; margin-top: 2px; margin-right: 15px; '>
                  <option selected="selected" value="none">- </option>
                </select>
                <button type="button" title="Обновить" data-test="token_refresh">Обновить</button>
              </div>
              <div class="result"></div>
            </div>

            <h3>rtwGetPublicKey(container_name);</h3>
            <p>Получить открытый ключ по заданному имени контейнера contName. Возвращает открытый ключ или код ошибки.</p>
            <div class="accent api" data-func="rtwGetPublicKey">
              <button class="test" data-test="rtwGetPublicKey">rtwGetPublicKey(contname)</button>
              <div class="clear"></div>
              <button  class="test" data-test="GetRepairKey" >rtwGetPublicKey('repair key')</button>
              <div id="contresult" class="result"></div>
            </div>

            <h3>rtwDestroyContainer(container_name);</h3>
            <p><span>rtwDestroyContainer(container_name, css] )</span> <br> Удалить контейнер с именем <strong>contName</strong>. Возвращает <strong>TRUE</strong> или код ошибки.</p>
            <div class="accent api round_5px" data-func="rtwDestroyContainer">
           <!--   <button class="test" data-test="rtwDestroyContainer">rtwDestroyContainer(contname)</button> -->
              <div class="clear"></div>
              <button class="test" data-test="rtwDestroyContainer_CSS_CallBack">rtwDestroyContainer(contname, css)</button>
              <div id="destroyresult" class="result"></div>
            </div>

            <h3>rtwSign(contname, hash);</h3>
            <p><span>rtwSign(contname, hash, css)</span> <br> Функция позволяет подписать хэш msg2Sign при помощи алгоритма ЭЦП ГОСТ Р 34.10-2001 с использованием закрытого ключа контейнера contname. Возвращает ЭЦП или код ошибки.</p>
            <p>Вы можете ввести собственное значение:</p>
            <div class="form thin">
              <input type="text" name="hash" id="hash" value="2BE1AFE68F9FE586F36C626FABF9DFC316491742EC793388EFADDE81FE34F3DC" style="width: 705px;" />
            </div>
            <div class="accent api" data-func="rtwSign">
            <!--  <button class="test" data-test="rtwSign">rtwSign(contname, hash)</button> -->
              <div class="clear"></div>
              <button class="test" data-test="rtwSign_CSS_CallBack">rtwSign(contname, hash, css)</button>
              <div id="signresult" class="result"></div>
            </div>

            <h3>rtwHashSign(contname, message);</h3>
            <p><span>rtwHashSign(contname, message, css)</span> <br> Функция позволяет подписать текстовые данные message при помощи алгоритма ЭЦП ГОСТ Р 34.10-2001 с использованием закрытого ключа контейнера contname, перед подписью хешируя данные на борту токена. Возвращает ЭЦП или код ошибки.</p>
            <p>Вы можете ввести собственное значение:</p>
            <div class="form thin">
              <textarea id="message" rows="5" cols="70" style="width: 705px; line-height: 1.4;"><!PINPADFILE RU><!>невидимый текст<N>Плательщик:<V>Иванов Иван Иванович<N>Номер счета плательщика:<V>42301810001000075212<N>Сумма:<V>150000<N>Валюта:<V>RUR<N>Получатель:<V>Петров Петр Петрович<N>Номер счета получателя:<V>40817810338295201618<N>Назначение платежа:<V>перевод личных средств</textarea>
            </div>
            <div class="accent api" data-func="rtwHashSign">
             <!-- <button class="test" data-test="rtwHashSign">rtwHashSign(contname, message)</button> -->
              <div class="clear"></div>
              <button class="test" data-test="rtwHashSign_CSS_CallBack">rtwHashSign(contname, message, css)</button>
              <div id="signmessageresult" class="result"></div>
            </div>

            <h3>rtwMakeSessionKey(contname, public_key, ukm);</h3>
            <p><span>rtwMakeSessionKey(contname, public_key, ukm, css)</span> <br> Функция позволяет вырабатывать общий сессионный секретный ключ между двумя абонентами для шифрования передаваемых данных. Для выработки ключа используются закрытый ключ контейнера contname, открытый ключ public_key второго абонента и случайное число ukm. Возвращает сессионный ключ или код ошибки.</p>
            <p>Вы можете ввести собственные значения:</p>
            <div class="form thin">
               <span style="display: inline-block; width: 80px; margin-bottom: 10px;">ukm:</span> <input style="width: 255px; margin-bottom: 10px;" type="text" name="ukm" id="ukm" size="80" value="1234567812345678" /><br>
               <span style="display: inline-block; width: 80px;">public_key:</span> <input style="width: 615px;" type="text" name="pubkeysession" id="pubkeysession" size="80" value="8A5242A3853E1A540C6439D8179B3700FDF5658D74DE4C63213E9EBE0B6B72C57C7F0C7D5FDCB412FF4311DDD31094103643A24CD4DAEC3AAABC9468C33AE440" />
            </div>
            <div class="accent api" data-func="rtwMakeSessionKey">
             <!-- <button class="test" data-test="rtwMakeSessionKey">rtwMakeSessionKey(contname, public_key, ukm)</button> -->
              <button class="test" data-test="rtwMakeSessionKey_CSS">rtwMakeSessionKey(contname, public_key, ukm, css)</button>
            <!--  <button class="test" data-test="rtwMakeSessionKey_CSS_CallBack">rtwMakeSessionKey(contname, public_key, ukm, css)</button> -->
              <div id="sessionresult" class="result"></div>
            </div>

            <h3>rtwRepair(repairKey, msg2Sign);</h3>
<p>Функция позволяет подписать хэш msg2Sign при помощи алгоритма ЭЦП ГОСТ Р 34.10-2001 с использованием внешнего закрытого ключа privKey. Возвращает ЭЦП или код ошибки.</p>
            <div class="form thin">
               <span style="display: inline-block; width: 80px; margin-bottom: 10px;">priv_key:</span> <input style="width: 615px; margin-bottom: 10px;" type="text" name="pkey" id="priv_key" size="80" value="2BE1AFE68F9FE586F36C626FABF9DFC316491742EC793388EFADDE81FE34F3DC" /><br>
               <span style="display: inline-block; width: 80px;">hash:</span> <input style="width: 615px;" type="text" name="hash" id="repairhash" size="80" value="2BE1AFE68F9FE586F36C626FABF9DFC316491742EC793388EFADDE81FE34F3DC" />
            </div>
            <div class="accent api" data-func="rtwRepair">
              <button type="button" data-test="rtwRepair">rtwRepair(priv_key, hash)</button>
              <div class="result"></div>
            </div>
          </div>

          <div id="pluginContainer">
    

          <script>
            SyntaxHighlighter.all()
          </script>

          <!-- /Content -->
        </article>
      </div>
      <nav>
        <ul>
          <li class="current"><a href="api_methods.php"><span>Методы</span></a></li>
          <li><a href="api_errors.php"><span>Коды ошибок</span></a></li>
         <!--  <li><a href="api_deprecated.php"><span>Устаревшие функции</span></a></li> -->
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