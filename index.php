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
            <li class="current"><a href="index.php">Главная</a></li>
            <li><a href="register.php">Регистрация</a></li>
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
              <h1>Демоплощадка Рутокен Web и PHP</h1>
              <div class="img_right">
                <img src="/images/rutoken.png" width="200" height="100" alt="" />
              </div>
              <p>Демонстрационная площадка позволяет оценить и протестировать основные криптографические возможности решения <strong>Рутокен Web</strong>.
                 Примеры написаны на PHP/JS/MySQL и воспроизводят наиболее распространенные и очевидные сценарии использования USB-токенов в Интернет-проектах. </p>
              <p>Для демонстрации необходимо выполнить следующие условия:</p>
              <ul>
                <li>Включить в браузере поддержку JavaScript;</li>
                <li><a href="http://www.rutokenweb.ru/software/browser_RTW_Plugin_1.1.exe">Установить плагин Рутокен Web</a> для браузера;</li>
                <li>Подключить USB-токен Рутокен Web или Рутокен ЭЦП к USB-порту. Для работы USB-токена не требуется установка драйверов или другого дополнительного программного обеспечения.</li>
              </ul>
              <p>Когда условия, необходимые для демонстрации, будут выполнены, вы сможете пройти все этапы аутентификации с помощью Рутокен Web: регистрация, аутентификация и восстановление доступа. Помимо этого, реализован механизм электронной цифровой подписи на примере тестового платежного поручения, а также обзор возможностей API плагина Рутокен Web.</p>
              <p>Для углубленного тестирования на собственной хостинговой площадке или встраивания Рутокен Web в Интернет-приложения доступны <a href="http://www.rutokenweb.ru/software/source_RTW_PHP.zip">исходные тексты серверной части</a>. Примеры хорошо прокомментированы и имеют максимально прозрачную и четкую структуру, что позволит легко модифицировать их под конкретные требования.</p>
              <div class="accent yandex round_5px">
                <div class="message round_3px">
                  <h2>Рутокен Web и Яндекс.Почта</h2>
                  <p>Практический пример интеграции Рутокен Web с Яндекс API демонстрирует возможности использования USB-токена совместно с сервисом Яндекс.Почта.  Быстрая регистрация позволит получить почтовый аккаунт на Яндексе с адресом в домене <strong>webtoken.ru</strong>. Через эту же форму вы сможете получать доступ к своему почтовому ящику, используя USB-токен Рутокен Web. Форма выполнена в виде виджета и может быть размещена на главной странице Яндекса с помощью кнопки «Добавить на Яндекс».</p>
                  <div class="yandex round_5px">
                    <iframe style="width: 250; height: 70px; margin-bottom: 10px; padding: 0;" frameborder="0" allowtransparency="true" id="wd-iframe-60117-1" src="http://webtoken.ru/wdgt.php?prefs_get=%7B%7D&amp;locale=ru&amp;wauth=1..a47env.60117-1.1310640899286633...6.50824561.973.4bb06942ad2bdadcd7fecc1b387b25ac&amp;.=http%3A%2F%2Fwww.yandex.ru%7Cyandex.ru&amp;rnd=0.1694571699119135"></iframe><br />
                    <a href="http://www.yandex.ru?add=60117&amp;from=promocode" target="_blank"><img src="http://img.yandex.net/i/service/wdgt/yand-add-b.png" border="0" alt="Добавить на главную страницу Яндекс"/></a>
                  </div>
                </div>
              </div>
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