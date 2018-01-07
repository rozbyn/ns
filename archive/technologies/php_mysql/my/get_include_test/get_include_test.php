<?php
$page = ['hea.php', 'hta.php', 'oup.php', 'yuf.php'];
echo "<a href=\"get_include_test/$page[0]?hi=Hello!\">Ссылка 1</a>" . '<br>';
echo "<a href=\"get_include_test/$page[1]?hi=Hello!\">Ссылка 2</a>" . '<br>';
echo "<a href=\"get_include_test/$page[2]?hi=Hello!\">Ссылка 3</a>" . '<br>';
echo "<a href=\"get_include_test/$page[3]?hi=Hello!\">Ссылка 4</a>" . '<br>';
include("get_include_test/$page[0]");
include("get_include_test/$page[1]");
include("get_include_test/$page[2]");
include("get_include_test/$page[3]");

?>



