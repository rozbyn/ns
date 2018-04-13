<?php 



class test {
    public $pub = false;
    private $priv = true;
    protected $prot = 42;
}
$t = new test;
$t->pub = $t;
$data = array(
    'one' => 'a somewhat long string!',
    'two' => array(
        'two.one' => array(
            'two.one.zero' => 210,
            'two.one.one' => array(
                'two.one.one.zero' => 3.141592564,
                'two.one.one.one'  => 2.7,
            ),
        ),
    ),
    'three' => $t,
    'four' => range(0, 5),
);
var_dump( $data );


$a = array(1, 2, 3);
$b =& $a;
$c =& $a[2];
$d =& $a;
$e =& $c;
$f = 10;
$g = $f;

xdebug_debug_zval('a');
xdebug_debug_zval("a[2]");
xdebug_debug_zval("f");
xdebug_debug_zval("g");


$a1 = array(1, 2, 3);
$b1 =& $a1;
$c1 =& $a1[2];

xdebug_debug_zval_stdout('a1');
xdebug_dump_superglobals();
ini_set('xdebug.var_display_max_children', 3 );
ini_set('xdebug.var_display_max_data', 8 );
ini_set('xdebug.var_display_max_depth', 1 );
xdebug_var_dump($data);
?>