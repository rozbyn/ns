<?php
namespace Foo\Bar\subnamespace;

const FOO = 1;
function foo() {echo 'Foo\Bar\subnamespace' . '<br>';}
function strlen($str) {echo '\subnamespace\\'.$str . '<br>';}
class foo
{
    static function staticmethod() {echo 'Foo\Bar\subnamespace\staticmethod' . '<br>';}
}
?>
