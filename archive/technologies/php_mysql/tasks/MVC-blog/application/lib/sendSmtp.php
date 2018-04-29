<?php
function sendSmtp ($toName, $toEmail, $subject, $text, $c = []) {
	if (empty($c)) {
		$c = [
			'host' => 'ssl://smtp.yandex.ru',
			'login' => 'ezcs@yandex.ru',
			'pass' => 'Q3KmE2Bckh',
			'port' => 465,
			'fromName' => "ЕЗЦС",
			'charset' => 'UTF-8',
			'log' => 0,
		];
	}
	extract($c);
	$b64Subject = base64_encode($subject);
	$b64toName = base64_encode($toName);
	$b64fromName = base64_encode($fromName);
	$headers = <<<bombom228
Subject: =?$charset?B?$b64Subject=?=
Reply-To: $login
Content-Type: text/html; charset="UTF-8"
To: "=?$charset?B?$b64toName=?=" <$toEmail>
From: "=?$charset?B?$b64fromName=?=" <$login>
\r\n\r\n
bombom228;
	$mailBody = $headers . $text . "\r\n.\r\n";
	$responses =[
		[220, "HELO ".$c['host'], 'Не удалось открыть сокет'],
		[250, "AUTH LOGIN", 'Не могу отправить HELO'],
		[334, base64_encode($c['login']), 'Нет ответа на запрос авторизации'],
		[334, base64_encode($c['pass']), 'Логин не принят сервером'],
		[235, "MAIL FROM: <".$c['login'].">", 'Ошибка авторизации'],
		[250, "RCPT TO: <" .  $toEmail . ">", 'Не могу MAIL FROM:'],
		[250, "DATA", 'Не могу RCPT TO:'],
		[354,  $mailBody, 'Не могу DATA'],
		[250, "QUIT", 'Не смог отправить тело письма'],
	];
	$socket = @fsockopen ($c['host'], $c['port'],  $errno, $errstr, 10);
	if ($socket === false) {
		if ($log===2)
		echo 'Не удалось открыть сокет: '.$errno.': '.$errstr.'<br>';
		return false;
	}
	foreach ($responses as $s) {
		if (substr($r=fgets($socket, 1024), 0, 3) == $s[0]) {
			if ($log===2) echo $r.'<br>';
			fputs($socket, $s[1]."\r\n");
		} else {
			if ($log !== 0) {
				echo $s[2] . '<br>';
				echo $r . '<br>';
			}
			fclose($socket);
			return false;
		}
	}
	fclose($socket);
	return true;
}
