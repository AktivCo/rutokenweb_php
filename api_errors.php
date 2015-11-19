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
          <li><a href="index.php">Демонстрация</a></li>
          <li class="current"><a href="api_methods.php">API плагина Рутокен Web</a> </li>
          <li><a href="http://www.rutoken.ru/support/download/rutoken-web/">Загрузить</a></li>
        </ul>
      </nav>
    </section>

    <section class="content">
      <div class="wrap">
        <article>
          <hgroup>
            <h1>Коды ошибок</h1>
          </hgroup>
          <!-- Content -->

          <div class="text">
            <ul class="error_codes">
              <li><strong>1</strong> <span>→</span> USB-токен не найден</li>
              <li><strong>2</strong> <span>→</span> USB-токен не залогинен пользователем</li>
              <li><strong>3</strong> <span>→</span> PIN-код не верен</li>
              <li><strong>4</strong> <span>→</span> PIN-код не корректен</li>
              <li><strong>5</strong> <span>→</span> PIN-код заблокирован</li>
              <li><strong>6</strong> <span>→</span> Неправильная длина PIN-кода</li>
              <li><strong>7</strong> <span>→</span> Отказ от ввода PIN-кода</li>
              <li><strong>10</strong> <span>→</span> Неправильные аргументы функции</li>
              <li><strong>11</strong> <span>→</span> Неправильная длина аргументов функции</li>
              <li><strong>12</strong> <span>→</span> Открыто другое окно ввода PIN-кода</li>
              <li><strong>20</strong> <span>→</span> Контейнер не найден</li>
              <li><strong>21</strong> <span>→</span> Контейнер уже существует</li>
              <li><strong>22</strong> <span>→</span> Контейнер поврежден</li>
              <li><strong>30</strong> <span>→</span> ЭЦП не верна</li>
              <li><strong>40</strong> <span>→</span> Не хватает свободной памяти для завершения операции</li>
              <li><strong>50</strong> <span>→</span> Библиотека не загружена</li>
              <li><strong>51</strong> <span>→</span> Библиотека находится в неинициализированном состоянии</li>
              <li><strong>52</strong> <span>→</span> Библиотека не поддерживает расширенный интерфейс</li>
              <li><strong>53</strong> <span>→</span> Ошибка в библиотеке rtpkcs11ecp</li>
			  <li><strong>72</strong> <span>→</span> Некорректный код восстановления</li>
            </ul>
          </div>

          <!-- /Content -->
        </article>
      </div>
      <nav>
        <ul>
          <li><a href="api_methods.php"><span>Методы</span></a></li>
          <li class="current"><a href="api_errors.php"><span>Коды ошибок</span></a></li>
          <!-- <li><a href="api_deprecated.php"><span>Устаревшие функции</span></a></li> -->
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