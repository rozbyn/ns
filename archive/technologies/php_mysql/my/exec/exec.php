<?php

$output = null;
$retval = null;
exec('git', $output, $retval);
echo "Returned with status $retval and output:\n<pre>";
print_r($output);
