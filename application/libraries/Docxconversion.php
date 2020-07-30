<?php
defined('BASEPATH') or exit('No direct script access allowed');

//include 'PdfToText/PdfToText.phpclass';

class Docxconversion
{

	private function read_doc($filePath)
	{
		$fileHandle = fopen($filePath, "r");
		$line = @fread($fileHandle, filesize($filePath));
		$lines = explode(chr(0x0D), $line);
		$outtext = "";
		foreach ($lines as $thisline) {
			$pos = strpos($thisline, chr(0x00));
			if (($pos !== FALSE) || (strlen($thisline) == 0)) {
			} else {
				$outtext .= $thisline . " ";
			}
		}
		$outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $outtext);
		return $outtext;
	}

	private function read_docx($filePath)
	{

		$striped_content = '';
		$content = '';

		$zip = zip_open($filePath);

		if (!$zip || is_numeric($zip)) return false;

		while ($zip_entry = zip_read($zip)) {

			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			zip_entry_close($zip_entry);
		}// end while

		zip_close($zip);

		$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
		$content = str_replace('</w:r></w:p>', "\r\n", $content);
		$striped_content = strip_tags($content);

		return $striped_content;
	}

	/************************excel sheet************************************/

	function xlsx_to_text($input_file)
	{
		$xml_filename = "xl/sharedStrings.xml"; //content file name
		$zip_handle = new ZipArchive;
		$output_text = "";
		if (true === $zip_handle->open($input_file)) {
			if (($xml_index = $zip_handle->locateName($xml_filename)) !== false) {
				$xml_datas = $zip_handle->getFromIndex($xml_index);
				$xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				$output_text = strip_tags($xml_handle->saveXML());
			} else {
				$output_text .= "";
			}
			$zip_handle->close();
		} else {
			$output_text .= "";
		}
		return $output_text;
	}

	/*************************power point files*****************************/
	function pptx_to_text($input_file)
	{
		$zip_handle = new ZipArchive;
		$output_text = "";
		if (true === $zip_handle->open($input_file)) {
			$slide_number = 1; //loop through slide files
			while (($xml_index = $zip_handle->locateName("ppt/slides/slide" . $slide_number . ".xml")) !== false) {
				$xml_datas = $zip_handle->getFromIndex($xml_index);
				$xml_handle = DOMDocument::loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				$output_text .= strip_tags($xml_handle->saveXML());
				$slide_number++;
			}
			if ($slide_number == 1) {
				$output_text .= "";
			}
			$zip_handle->close();
		} else {
			$output_text .= "";
		}
		return $output_text;
	}


	function pdf2string($sourcefile)
	{

		$fp = fopen($sourcefile, 'rb');
		$content = fread($fp, filesize($sourcefile));
		fclose($fp);

		$searchstart = 'stream';
		$searchend = 'endstream';
		$pdfText = '';
		$pos = 0;
		$pos2 = 0;
		$startpos = 0;

		while ($pos !== false && $pos2 !== false) {

			$pos = strpos($content, $searchstart, $startpos);
			$pos2 = strpos($content, $searchend, $startpos + 1);

			if ($pos !== false && $pos2 !== false) {

				if ($content[$pos] == 0x0d && $content[$pos + 1] == 0x0a) {
					$pos += 2;
				} else if ($content[$pos] == 0x0a) {
					$pos++;
				}

				if ($content[$pos2 - 2] == 0x0d && $content[$pos2 - 1] == 0x0a) {
					$pos2 -= 2;
				} else if ($content[$pos2 - 1] == 0x0a) {
					$pos2--;
				}

				$textsection = substr(
					$content,
					$pos + strlen($searchstart) + 2,
					$pos2 - $pos - strlen($searchstart) - 1
				);
				$data = @gzuncompress($textsection);
				$pdfText .= $this->pdfExtractText($data);
				$startpos = $pos2 + strlen($searchend) - 1;

			}
		}

		return preg_replace('/(\\s)+/', ' ', $pdfText);

	}

	function pdfExtractText($psData)
	{

		if (!is_string($psData)) {
			return '';
		}

		$text = '';

		// Handle brackets in the text stream that could be mistaken for
		// the end of a text field. I'm sure you can do this as part of the
		// regular expression, but my skills aren't good enough yet.
		$psData = str_replace('\\)', '##ENDBRACKET##', $psData);
		$psData = str_replace('\\]', '##ENDSBRACKET##', $psData);

		preg_match_all(
			'/(T[wdcm*])[\\s]*(\\[([^\\]]*)\\]|\\(([^\\)]*)\\))[\\s]*Tj/si',
			$psData,
			$matches
		);
		for ($i = 0; $i < sizeof($matches[0]); $i++) {
			if ($matches[3][$i] != '') {
				// Run another match over the contents.
				preg_match_all('/\\(([^)]*)\\)/si', $matches[3][$i], $subMatches);
				foreach ($subMatches[1] as $subMatch) {
					$text .= $subMatch;
				}
			} else if ($matches[4][$i] != '') {
				$text .= ($matches[1][$i] == 'Tc' ? ' ' : '') . $matches[4][$i];
			}
		}

		// Translate special characters and put back brackets.
		$trans = array(
			'...' => '&#8230;',
			'\\205' => '&#8230;',
			'\\221' => chr(145),
			'\\222' => chr(146),
			'\\223' => chr(147),
			'\\224' => chr(148),
			'\\226' => '-',
			'\\267' => '&#8226;',
			'\\(' => '(',
			'\\[' => '[',
			'##ENDBRACKET##' => ')',
			'##ENDSBRACKET##' => ']',
			chr(133) => '-',
			chr(141) => chr(147),
			chr(142) => chr(148),
			chr(143) => chr(145),
			chr(144) => chr(146),
		);
		$text = strtr($text, $trans);

		return $text;

	}

	public function convertToText($filePath)
	{

		if (isset($filePath) && !file_exists($filePath)) {
			return "File Not exists";
		}

		$fileArray = pathinfo($filePath);
		$file_ext = $fileArray['extension'];
		if ($file_ext == "doc" || $file_ext == "docx" || $file_ext == "xlsx" || $file_ext == "pptx" || $file_ext == "pdf") {
			$text = '';
			if ($file_ext == "doc") {
				$text = $this->read_doc($filePath);
			} elseif ($file_ext == "docx") {
				$text = $this->read_docx($filePath);
			} elseif ($file_ext == "xlsx") {
				$text = $this->xlsx_to_text($filePath);
			} elseif ($file_ext == "pptx") {
				$text = $this->pptx_to_text($filePath);
			} elseif ($file_ext == "pdf") {
//				$text = $this->pdf2string($filePath);
//				$pdf = new PdfToText($filePath);
//				$pdf->Load($filePath);
				$parser = new \Smalot\PdfParser\Parser();
				try {
					$pdf = $parser->parseFile($filePath);
					$text = $pdf->getText();
				} catch (Exception $e) {
					if ($e->getMessage()) {
//						$text = $e->getMessage();
						$text = 'Terjadi kesalahan, silahkan konversi file PDF ke Doc/Docx';
					}
				}
//				$text = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $pdf->Text);
//				$myfile = fopen("docuji/test.txt", "w") or die("Unable to open file!");
//				fwrite($myfile, $text);
//				fclose($myfile);
//				$text = file_get_contents('docuji/test.txt');
			}
			return $text;
		} else {
			return "Invalid File Type";
		}
	}

}

?>
