<?php
namespace Foo\Bar;
include 'file1.php';

const FOO = 2;
function foo() {echo 'Foo\Bar' . '<br>';}
function strlen($str) {echo $str . '<br>';}
class foo
{
    static function staticmethod() {echo 'Foo\Bar\staticmethod' . '<br>';}
}

/* Неполные имена */
foo(); // определяется как функция Foo\Bar\foo
foo::staticmethod(); // определяется как класс Foo\Bar\foo с методом staticmethod
echo FOO; // определяется как константа Foo\Bar\FOO

/* Полные имена */
subnamespace\foo(); // определяется как функция Foo\Bar\subnamespace\foo
subnamespace\foo::staticmethod(); // определяется как класс Foo\Bar\subnamespace\foo
                                  // c методом staticmethod
echo subnamespace\FOO; // определяется как константа Foo\Bar\subnamespace\FOO
                                  
/* Абсолютные имена */
\Foo\Bar\foo(); // определяется как функция Foo\Bar\foo
\Foo\Bar\foo::staticmethod(); // определяется как класс Foo\Bar\foo с методом staticmethod
echo \Foo\Bar\FOO; // определяется как константа Foo\Bar\FOO
echo  '<br>';
$str = 'asd-0a9d093i';
strlen($str);
\foo\bar\subnamespace\strlen($str);
echo \strlen($str) . '<br>';
?>

