<?php
defined('BASEPATH') or exit('No direct script access allowed');

include 'stemming/stemming.php';

class Stem
{
	public function tokenizing($kk)
	{
		$toLower = strtolower($kk);
		$ready = preg_replace('/[^a-zA-Z0-9]/', ',', $toLower);
		$exploded = explode(',', $ready);
		return $exploded;
	}

	public function stopword($kk)
	{
		$stopword = cekStopword($kk);
		return $stopword;
	}

	public function stemming($kk)
	{
		$stemming = stemming($kk);
		return $stemming;
	}

}

?>
