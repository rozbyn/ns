<?php
//
//$dbConfigFilePath = $_SERVER['DOCUMENT_ROOT'] . '/config/dbConfig.php';
//if(!is_file($dbConfigFilePath)){
//	exit('no db config');
//}
//$dbConfig = require_once $dbConfigFilePath;
//
//$myDbObj = new mysqli($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['name']);
//$myDbObj->set_charset("utf8");
//
//https://script.google.com/home/projects/1ag48oqEfD_x7fNHatm9VZyt7HR7hpJOzzBFXfVg-HGt1KmRXiAVtvMXs/edit
//

require_once './vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;



$auth = ['VAPID' => [
	'subject' => 'mailto: <ezcs@yandex.ru>',
	'publicKey' => 'BKT5kerifUq3Ewadkppnf_UNwHW7QyHUkLLCllFEPIup8mvCs_kGHrcdF6ZhcHG87nZxqRVLAQsQzqz8qG_bSlo',
	'privateKey' => 'L3JSt1jyPJLFBYPU2nDVIVrkM_Ld6YpS2YqdvqsBByA',
]];

$subscriptionData = [
  "endpoint" => "https://fcm.googleapis.com/fcm/send/eg4_nGwMo3k:APA91bH2KpEkycae0lJymeQTcE1ItQd1VG-8VHUuJq5nctFRPdSC2hJXFuhRWqBBC-ttpC2Nh431Huzm9UaTzI43xKFQcUsjHxcIOcEsJc7JxIPElCPshQaFrkSh_oDo84Tkf5zHGEun",
  "expirationTime" => null,
  "keys" => [
    "p256dh" => "BOTyZt4COOzJqD_pqR4hqa42YS4i7YHbjiNxRhNI3lM2FaeyRXz_fSwF60BRngYakTGaWvoYBmDw5mFFa8VyeGU",
    "auth" => "2YfqnVnlcZylnzX6vy0B9A"
  ]
];
$subscription = Subscription::create($subscriptionData);
$webPush = new WebPush($auth);
$report = $webPush->sendOneNotification(
  $subscription,
 json_encode([
	 'title' => 'bbob',
	 'desc' => 'asuidhasj aud09ui as09u dasuoikmnlk mlniopasf iusduh 98dj lksdnlkm. fsd 9uisd87 gysd9f jsdyf ',
 ])
);

$data = $report->getResponse()->getBody()->getContents();
if (!empty($data)) {
	echo $data;
}