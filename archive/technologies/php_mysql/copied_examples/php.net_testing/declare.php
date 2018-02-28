
<?php

declare(ticks=2);

// Функция, исполняемая при каждом тике
$O = 0;
function tick_handler()
{
    $O++;
}

register_tick_function('tick_handler');

for($i=0;$i<100;$i++){

}



?>
