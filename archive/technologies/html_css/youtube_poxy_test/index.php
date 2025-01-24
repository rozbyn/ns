<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$authParams = [
    'email' => 'rzebrov@yandex.ru',
    'password' => 'asdasj_ASd890ha',
];
$siteUrl = 'http://asasdasdasdasd.com.preview.services/test/proxy.php';
if (isset($_REQUEST['proxy_url'])) {
    $siteUrl .= '?proxy_url='.$_REQUEST['proxy_url'];
}

$authUrl = 'http://asasdasdasdasd.com.preview.services/freehost/preview_auth.php';


if (!empty($_REQUEST['proxy_url'])) {
    $result = [];
    $zeroResult = __sendCurl($siteUrl);
    if ($zeroResult['info']['http_code'] !== 200) {
        $firstResult = __sendCurl($authUrl, $authParams);
        if ($firstResult['info']['http_code'] !== 200) {
            echo 'Auth error'.PHP_EOL;
            var_dump($firstResult);
        } else {
            $secondResult = __sendCurl($siteUrl);
            if ($secondResult['info']['http_code'] === 200) {
                $result = $secondResult;
            } else {
                echo 'second result'.PHP_EOL;
                var_dump($secondResult);
            }
        }
    } else {
        $result = $zeroResult;
    }
    
    
    if (!empty($result)) {
        foreach($result['headers'] as $headerStr) {
            if (
                str_contains($headerStr, 'Transfer-Encoding')
            ) {
                continue;
            }
            // var_dump($headerStr);
            header($headerStr);
        }
        echo $result['html'];
        exit;
    
    }
}


// $t = file_get_contents('http://asasdasdasdasd.com.preview.services/', );
// var_dump($t);
$videoUrl = 'https://www.youtube.com/embed/2F_5_wuk8BI?si=VPDwzjexFKJdgf7-';
// $videoUrl = 'https://www.youtube.com/';
$embeddedUrl = 'http://asasdasdasdasd.com.preview.services/test/embeddedTarget.php?' 
    // . '';
    . http_build_query(['proxy_url' => $videoUrl]);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>youtube proxy test</title>
</head>
<body>
    <div class="frame-wrapper">
        
        <iframe 
            id="youtubeFrame"
            width="560" 
            height="315" 
            src="<?=$embeddedUrl?>" 
            title="YouTube video player" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin" 
            allowfullscreen
        ></iframe>
        <script>
            let frame = document.getElementById('youtubeFrame');
            console.log(frame);
        </script>
    </div>
</body>
</html>





<?php

function __sendCurl($url, $postParams = []){
    $ch = curl_init($url);
    if (!empty($postParams)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postParams));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $headers = [];
    curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$headers) {
        $len = strlen($header);
        $header = trim($header);
        if (empty($header) || !str_contains($header, ':')) {
            return $len;
        }
        $headers[] = $header;
        return $len;
    });
    $html = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [
        'html' => $html,
        'info' => $info,
        'headers' => $headers,
    ];

}