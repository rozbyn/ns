<?php
class MathComplex
{
	public $re, $im;
	function add ($re, $im)
	{
		$this->re += $re;
		$this->im += $im;
	}
}