<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rabinkarp1
{

	var $DocAsli;
	var $DocUji;
	var $patternSama;
	var $Kgram;
	var $jumPatternDocAsli;
	var $jumPatternDocUji;
	var $jumPatternSama;
	var $basis;
	var $similarity;
	var $panjangPatternS;
	var $ishehe;

	var $patternToHightL1;
	var $patternToHightL2;

//	public function __construct($params)
	public function getRabinKarp($Doc1, $Doc2, $Kgram)
	{
		$this->DocAsli = '';
		$this->DocUji = '';
		$this->patternSama = array();
		$this->Kgram = 0;
		$this->jumPatternDocAsli = 0;
		$this->jumPatternDocUji = 0;
		$this->jumPatternSama = 0;
		$this->basis = 256;
		$this->similarity = 0;
		$this->panjangPatternS = 0;
		$this->ishehe = 0;
		$this->patternToHightL1 = '';
		$this->patternToHightL2 = '';

//		$Doc1 = $params[0];
//		$Doc2 = $params[1];
//		$Kgram = $params[2];

		$this->DocAsli = str_replace(' ', '', $Doc1);
		$this->DocUji = str_replace(' ', '', $Doc2);
		$this->Kgram = $Kgram;
		$this->panjangPatternS = $Kgram;
		$this->jumPatternDocAsli = strlen($this->DocAsli) - $this->Kgram + 1;
		$this->jumPatternDocUji = strlen($this->DocUji) - $this->Kgram + 1;

		if ($this->jumPatternDocAsli < $this->jumPatternDocUji) {
			$this->patternSama = array(strlen($this->DocUji));
			$this->parsingKgram($this->DocAsli, $this->DocUji, $this->jumPatternDocAsli);
		} else {
			$this->patternSama = array(strlen($this->DocAsli));
			$this->parsingKgram($this->DocUji, $this->DocAsli, $this->jumPatternDocUji);
		}
		$this->getSimilarity();
	}

	private function parsingKgram($pattern, $teks, $jumKgram)
	{
		for ($i = 0; $i < $jumKgram; $i++) {
//			$nextKgram = $this->Kgram + $i;
			$nextKgram = $this->Kgram;
			$this->matching(substr($pattern, $i, $nextKgram), $teks);
		}
	}

	private function hash($pattern)
	{
		$h = 0;
		for ($i = 0; $i < strlen($pattern); $i++) {
//			$h += $this->toNumber($this->char_at($pattern, $i)) * pow($this->basis, strlen($pattern) - $i - 1);
			$h += ord($this->char_at($pattern, $i)) * pow($this->basis, strlen($pattern) - $i - 1);
		}
		return $h;
	}

	private function matching($pattern, $teks)
	{
		$panjangPattern = strlen($pattern);
		$panjangTeks = strlen($teks);
		$i = 0;
		$j = 0;
		$hashPattern = $this->hash($pattern);
		$hashTeks = $this->hash(substr($teks, 0, $panjangPattern));
//		$hashTeks = $this->hash(substr($teks, $this->ishehe, $this->panjangPatternS));
//		echo '<pre>';
//		echo $pattern . " - " . $hashPattern;
//		echo substr($teks, $this->ishehe, $this->panjangPatternS) . " - " . $hashTeks;
//		echo '<pre>';
		$this->patternToHightL1 .= " " . $pattern;
		$this->patternToHightL2 .= " " . substr($teks, $this->ishehe, $this->panjangPatternS);
		$this->ishehe++;
		for ($i = 0; $i < $panjangTeks - $panjangPattern; $i++) {
			if ($hashPattern == $hashTeks) {
				for ($j = 0; $j < $panjangPattern; $j++) {
					if ($this->char_at($teks, $i + $j) != $this->char_at($pattern, $j))
						break;
				}
				if ($j == $panjangPattern) {
					$this->jumPatternSama++;
					$this->patternSama[$i] = $pattern;
					break;
				}
			} else {
				$hashTeks = $this->hash(substr($teks, $i + 1, $panjangPattern));
			}
		}
	}

	private function getSimilarity()
	{
		$A = 2 * $this->jumPatternSama;
		$B = $this->jumPatternDocAsli + $this->jumPatternDocUji;
		$C = ($A / $B) * 100;
		$bigDecimal = round($C, 2);
		$this->similarity = $bigDecimal;
	}

	private function char_at($str, $pos)
	{
		return $str{$pos};
	}

	private function toNumber($dest)
	{
		if ($dest)
			return ord(strtolower($dest)) - 96;
		else
			return 0;
	}
}

?>
