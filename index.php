<!DOCTYPE HTML>
<html>
  <head>
    <title>Демо-площадка Рутокен: Рутокен Web и PHP!</title>
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
            <h1>Демо-площадка Рутокен Web + PHP</h1>
          </hgroup>
          <!-- Content -->

          <div class="text">
            <p>Демонстрационная площадка позволяет оценить и протестировать основные возможности решения Рутокен Web. Примеры написаны на PHP/JS/MySQL и воспроизводят наиболее распространенные и очевидные сценарии использования. </p>
            <p>Для демонстрации необходимо:</p>
            <ul class="string">
              <li>Включить в браузере поддержку JavaScript;</li>
              <li>Установить плагин Рутокен Web для браузера;</li>
			  <li>Для Google Chrome подключить расширение <a href="https://chrome.google.com/webstore/detail/%D0%B0%D0%B4%D0%B0%D0%BF%D1%82%D0%B5%D1%80-%D1%80%D1%83%D1%82%D0%BE%D0%BA%D0%B5%D0%BD-web-%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8/boabkkhbickbpleplbghkjpcoebckgai" target="_blank">"Адаптер Рутокен Web Плагин"</a></li>
              <li>Подключить USB-токен Рутокен Web или Рутокен ЭЦП к USB-порту.</li>
            </ul>
            <p>Когда условия, необходимые для демонстрации, будут выполнены, вы сможете пройти все этапы аутентификации с помощью Рутокен Web: регистрация, аутентификация и восстановление доступа. Помимо этого реализован механизм электронной цифровой подписи на примере тестового платежного поручения.</p>
            <!-- p>Для углубленного тестирования на собственной хостинговой площадке или встраивания Рутокен Web в интернет-приложения доступны исходные тексты серверной части. Примеры содержат комментарии и имеют прозрачную и четкую структуру, что позволит легко модифицировать их под конкретные требования.</p -->
          </div>

          <!-- /Content -->
        </article>
      </div>
      <nav>
        <ul>
          <li><a href="register.php"><span>Регистрация</span></a></li>
          <li><a href="login.php"><span>Авторизация</span></a></li>
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