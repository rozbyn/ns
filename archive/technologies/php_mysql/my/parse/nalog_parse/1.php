<?php



// file_put_contents('test231.txt', $getRES);

if(!empty($_POST['tok'])){
	$captchaToken = $_POST['tok'];
} else {
	$connGET = curl_init("https://egrul.nalog.ru/");
	curl_setopt($connGET, CURLOPT_RETURNTRANSFER, true);
	$getRES = curl_exec($connGET);
	$doc = new DOMDocument;
	$r = error_reporting(E_ERROR | E_PARSE);
	$doc->loadHTML($getRES);
	error_reporting($r);
	$xpath = new DOMXpath($doc);
	$elements = $xpath->query("/html/body/div[1]/div[2]/div/div[2]/div/form/div[4]/div/div/input");
	$captchaToken = $elements[0]->getAttribute('value');
}
var_dump($captchaToken);
echo <<<a123123123123asdasdasdasd
<img src="https://egrul.nalog.ru/static/captcha.html?a=$captchaToken&version=2">
<form action="" method="POST">
	<button name="tok" value="$captchaToken" type="submit">Обновить</button>
</form>

<form action="" method="POST">
	<input name="captcha">
	<input type="hidden" value="$captchaToken" name="CAPACA">
	<button name="cap" value="yes" type="submit">Ok</button>
</form>

a123123123123asdasdasdasd;



if(!empty($_POST['cap']) && $_POST['cap']=="yes"){
	$connPOST = curl_init("https://egrul.nalog.ru/");
	$arrData = [
		'fam'=>'Зебров',
		'nam'=>'Михаил',
		'region'=>'21',
		// 'kind' => 'fl',
		// 'ogrninnul' => '',
		// 'ogrninnfl' => '',
		// 'namul' => '',
		// 'otch' => '',
		// 'captcha'=>'877718',
		// 'captchaToken'=>'6C10AA101BF6342DDF1292C4CB139594AC04567DC18C7508251ECAB14051604C723089FC24B00FC27D270892C38BA0D7',	
		// 'captcha'=>'630741',
		// 'captchaToken'=>'493F8955C4782E32F653E69ACFE85B82235BDAF5BCD32A1CB8EFCF4AEF4B8BAA9161E66BF45262889BDDFDBB0AA557C02B0DA1687EF75B1F382BA05346C9707A',
		// 'regionul'=>'',
		// 'srchFl'=>'name',
		// 'srchUl'=>'name',
	];
	$arrData['captcha'] = $_POST['captcha'];
	$arrData['captchaToken'] = $_POST['CAPACA'];
	$URLdata = http_build_query($arrData);
	$options = [
		CURLOPT_POSTFIELDS => $URLdata,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER => false,
		CURLOPT_POST => true,
	];
	curl_setopt_array($connPOST, $options);
	$postRES = curl_exec($connPOST);
	$postRES = json_decode($postRES, true);
	var_dump($postRES);
}

















