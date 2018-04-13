<?php 

function crElem ($domDocument ) {
	
}


//////////////////////
//Подключение к БД++++++++++++++++++++
if($_SERVER['DOCUMENT_ROOT'] === '/home/u784337761/public_html'){
	$myDbObj = new mysqli('localhost', 'u784337761_root', 'nSCtm9jplqVA', 'u784337761_test');
} elseif($_SERVER['DOCUMENT_ROOT'] === '/storage/ssd3/266/4204266/public_html'){
	$myDbObj = new mysqli('localhost', 'id4204266_root', 'asdaw_q32d213e', 'id4204266_test');
} else {
	$myDbObj = new mysqli('localhost', 'root', '', 'shop');
}
$myDbObj->set_charset("utf8");
//++++++++++++++++++++++++++++++++++++
$query = "SELECT * FROM categories ";
$categories = $myDbObj->query($query)->fetch_all(MYSQLI_ASSOC);


$arrayCatSubCat = [];
foreach ($categories as $category) {
	extract($category, EXTR_OVERWRITE);
	if ($parentCat === '0') {
		if (isset($arrayCatSubCat[$id])) {
			$arrayCatSubCat[$id] += $category;
		} else {
			$arrayCatSubCat[$id] = $category;
		}
	} else {
		$arrayCatSubCat[$parentCat]['subCategories'][$id] = $category;
	}
}

$dom = new DomDocument('1.0', 'UTF-8');
$all_categories = $dom->appendChild($dom->createElement('All-categories')); 
$showingCategories = $all_categories->appendChild($dom->createElement('showingCategories'));
$notShowingCategories = $all_categories->appendChild($dom->createElement('hiddenCategories'));

foreach ($arrayCatSubCat as $catId => $catProp) {
	if ($catId === -1) {
		foreach ($catProp['subCategories'] as $category) {
			$domCategory = $notShowingCategories->appendChild($dom->createElement('category'));
			$domCategory->appendChild($dom->createElement('id'))->appendChild($dom->createTextNode($category['id']));
			$domCategory->appendChild($dom->createElement('name'))->appendChild($dom->createTextNode($category['name']));
			$domCategory->appendChild($dom->createElement('priceCat'))->appendChild($dom->createTextNode($category['priceCat']));
			$domCategory->appendChild($dom->createElement('unit'))->appendChild($dom->createTextNode($category['unit']));
		}
	} else {
		$domCategory = $showingCategories->appendChild($dom->createElement('category'));
		$domCategory->appendChild($dom->createElement('id'))->appendChild($dom->createTextNode($catProp['id']));
		$domCategory->appendChild($dom->createElement('name'))->appendChild($dom->createTextNode($catProp['name']));
		$domCategory->appendChild($dom->createElement('priceCat'))->appendChild($dom->createTextNode($catProp['priceCat']));
		$domCategory->appendChild($dom->createElement('unit'))->appendChild($dom->createTextNode($catProp['unit']));
		if (isset($catProp['subCategories'])) {
			$domSubCategories = $domCategory->appendChild($dom->createElement('SubCategories'));
			foreach ($catProp['subCategories'] as $subCat) {
				$domSubCategory = $domSubCategories->appendChild($dom->createElement('category'));
				$domSubCategory->appendChild($dom->createElement('id'))->appendChild($dom->createTextNode($subCat['id']));
				$domSubCategory->appendChild($dom->createElement('name'))->appendChild($dom->createTextNode($subCat['name']));
				$domSubCategory->appendChild($dom->createElement('priceCat'))->appendChild($dom->createTextNode($subCat['priceCat']));
				$domSubCategory->appendChild($dom->createElement('unit'))->appendChild($dom->createTextNode($subCat['unit']));
			}
		}
	}
}
$dom->formatOutput = true;
$dom->save('categories.xml');


$dom = new DomDocument('1.0', 'UTF-8');
$all_goods = $dom->appendChild($dom->createElement('Products'));

$query = "SELECT * FROM goods";
$result = $myDbObj->query($query);
for (; $r = $result->fetch_assoc(); ) {
	extract($r, EXTR_OVERWRITE);
	$domProduct = $all_goods->appendChild($dom->createElement('Product'));
	$domProduct->appendChild($dom->createElement('id'))->appendChild($dom->createTextNode($id));
	$domProduct->appendChild($dom->createElement('category'))->appendChild($dom->createTextNode($category));
	$domProduct->appendChild($dom->createElement('name'))->appendChild($dom->createTextNode($name));
	$domProduct->appendChild($dom->createElement('pack'))->appendChild($dom->createTextNode($pack));
	$domProduct->appendChild($dom->createElement('price'))->appendChild($dom->createTextNode($price));
	$domProduct->appendChild($dom->createElement('img-url'))->appendChild($dom->createTextNode($img));
	$domProduct->appendChild($dom->createElement('showOnMain'))->appendChild($dom->createTextNode($showOnMain));
}

$dom->formatOutput = true;
$dom->save('goods.xml');
//echo $dom->saveXML();

$sxe = simplexml_load_string('<books><book><title>'.
      'Great American Novel</title></book></books>');
if ($sxe === false) {
  echo 'Error while parsing the document';
  exit;
}


$dom_sxe = dom_import_simplexml($sxe);
if (!$dom_sxe) {
  echo 'Error while converting XML';
  exit;
}

$dom = new DOMDocument('1.0');
$dom_sxe = $dom->importNode($dom_sxe, true);
$dom_sxe = $dom->appendChild($dom_sxe);
$dom->formatOutput = true;
$dom->save('test3.xml');

$dom = new domDocument;

$xmlString = '<books>';
for ($i = 1; $i < 5; $i++) {
	$xmlString .= '<book>';
	for ($j = 1; $j < 5; $j++) {
		$xmlString .= '<title>'.$i.'Great American Novel'.$j.'</title>';
	}
	$xmlString .= '</book>';
}
$xmlString .= '</books>';

$dom->loadXML($xmlString);
if (!$dom) {
   echo 'Error while parsing the document';
   exit;
}
 
$s = simplexml_import_dom($dom);
var_dump($s->book->title);

echo $s->book->title[2] . '<br>';
echo $s->book->title . '<br>';
echo $s->book[0]->title . '<br>';
echo $s->book[1]->title[0] . '<br>';
echo $s->book[2]->title[2] . '<br>';
echo $s->book[3]->title[3] . '<br>';
echo $s->book[2]->title[1] . '<br>';
echo $s->book[1]->title[2] . '<br>';

$dom2 = new DomDocument();
$dom2->loadHTML(file_get_contents('https://www.w3.org/')); 
$xpath = new DomXPath($dom2);
$_res = $xpath->query(".//*[@id='w3c_home_upcoming_events']/ul/li/div/p/a");
foreach($_res as $obj) {
	echo $obj->nodeValue  . ' : ';
	echo 'URL: '.$obj->getAttribute('href');
	echo  '<br>';
}




/* 
/html/body/div[1]/div[2]/div[3]/div[2]/div[1]/div/div[2]/div/div[2]/div/ul/li[1]/div[2]/p[1]/a
/html/body/div[1]/div[2]/div[3]/div[2]/div[1]/div/div[2]/div/div[2]/div/ul/li[2]/div[2]/p[1]/a
/html/body/div[1]/div[2]/div[3]/div[2]/div[1]/div/div[2]/div/div[2]/div/ul/li[3]/div[2]/p[1]/a
/html/body/div[1]/div[2]/div[3]/div[2]/div[1]/div/div[2]/div/div[2]/div/ul/li[4]/div[2]/p[1]/a
 */
/* 
tidy
$xmlData = file_get_contents('book.xml');
$rxml = new XMLReader();
$rxml->xml($xmlData);
//var_dump($rxml);

//Создает XML-строку и XML-документ при помощи DOM 
$dom = new DomDocument('1.0', 'UTF-8'); 
 
//добавление корня - <books> 
$books = $dom->appendChild($dom->createElement('books')); 
 
//добавление элемента <book> в <books> 
$book = $books->appendChild($dom->createElement('book')); 
 
// добавление элемента <title> в <book> 
$title = $book->appendChild($dom->createElement('title')); 
 
// добавление элемента текстового узла <title> в <title> 
$title->appendChild($dom->createTextNode('Great American Novel')); 

$book->appendChild($title->cloneNode(true)); 
$book->appendChild($title->cloneNode(true)); 
$book->appendChild($title->cloneNode(true)); 
$book->appendChild($title->cloneNode(true)); 
$book->appendChild($title->cloneNode(true)); 

$books->appendChild($book->cloneNode(true));
$books->appendChild($book->cloneNode(true));
$books->appendChild($book->cloneNode(true));
$books->appendChild($book->cloneNode(true));
$books->appendChild($book->cloneNode(true));

//генерация xml 
$dom->formatOutput = true; // установка атрибута formatOutput
                           // domDocument в значение true 
// save XML as string or file 
$test1 = $dom->saveXML(); // передача строки в test1 
$dom->save('test1.xml'); // сохранение файла 


$sxe = simplexml_load_string($xmlData);

if ($sxe === false) {
  echo 'Error while parsing the document';
  exit;
}

$dom_sxe = dom_import_simplexml($sxe);
if (!$dom_sxe) {
  echo 'Error while converting XML';
  exit;
}

$dom = new DOMDocument('1.0', 'UTF-8');
$dom_sxe = $dom->importNode($dom_sxe, true);
$dom_sxe = $dom->appendChild($dom_sxe);

$dom->save('test2.xml');
 */
?>