=== uLogin - виджет авторизации через социальные сети ===
Donate link: http://ulogin.ru/
Tags: ulogin, login, social, authorization
Requires at least: ExBB FM 1.0 RC1,
Tested up to: ExBB FM 1.0 RC1,
Stable widget tag: 1.7
License: GPL3

Форма авторизации uLogin через социальные сети. Улучшенный аналог loginza.

== Description ==

uLogin — это инструмент, который позволяет пользователям получить единый доступ к различным Интернет-сервисам без необходимости повторной регистрации,
а владельцам сайтов — получить дополнительный приток клиентов из социальных сетей и популярных порталов (Google, Яндекс, Mail.ru, ВКонтакте, Facebook и др.)

== Installation ==
1. Скопируйте содержимое в директорию с ExBB
2. Если используется нестандартный шаблон (по умолчанию InvisionExBB), то необходимо добавить следующие изменения в файлы шаблона:
-all_header.tpl:
 Подключить скрипт <script src="http://ulogin.ru/js/ulogin.js"></script>
-logos.tpl:
 Добавить код
 DATA;
  if ($fm->user['id'] == 0)
    echo '<div id="uLogin" x-ulogin-params="display=small;fields=first_name,last_name,email;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=twitter,google,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam;redirect_uri='.urlencode('http://'.$_SERVER['HTTP_HOST'].'/ulogin.php').'"></div>';
  echo <<<DATA

== Frequently Asked Questions ==

= Нужно ли где-то регистрироваться, чтобы плагин заработал? =

Нет, плагин заработает сразу после установки!

== Screenshots ==

