<?php ## Использование функции htmlimgmail().
  // Отправляем почтовое сообщение
  require './lib/attach.php';
  $picture[0] = "s_20040815135808.jpg";
  $picture[1] = "s_20040815135939.JPG";
  $mail_to = "rozbyn@ya.ru";
  $thm     = "Тема сообщения";
  $html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML ".
          "4.01 Transitional//EN\">
           <html>
             <head><title>Почтовая рассылка</title></head>
             <body><img src='cid:".md5($picture[0])."' border='0'>Тело сообщения<br /><br /><img src='cid:".md5($picture[1])."' border='0'></body>
           </html>";
  if(htmlimgmail($mail_to, $thm, $html, $picture)) {
    echo "Успех ".date("d.m.Y H:i");
  } else {
    echo "Не отправлено";
  }
?>
