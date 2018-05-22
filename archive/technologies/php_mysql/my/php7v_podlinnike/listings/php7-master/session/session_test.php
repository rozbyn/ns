<?php
//session_name('rozb1');
$sessionName1 = 'addaddada123123123';
session_start(['name'=>$sessionName1]);
$sessionId1 = session_id();
echo <<<adasdasda
<pre>
name1: $sessionName1;
id1: $sessionId1;

adasdasda;

echo session_save_path();
$_SESSION = [];
var_dump($_COOKIE);
unset($_COOKIE[session_id()]);

session_destroy();