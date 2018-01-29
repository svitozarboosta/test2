<?php

namespace theme;


class ContentRepository {

	protected function getContent() {
		switch ($this->_type) {
			case 'txt':
				return file_get_contents($this->_file['file']);
				break;
			case 'doc':
			case 'docx':
				require(__DIR__ . '/libs/DocxConversion.php');
				return $this->getDocContent($this->_file['file']);
				break;
			case 'pdf':
				require(__DIR__ . '/vendor/autoload.php');
				return $this->getPdfContent($this->_file['file']);
				break;
			default:
				return false;
				break;
		}
	}

	private function getDocContent($file) {
		$doc = new \DocxConversion($file);
		return $doc->convertToText();
	}

	private function getPdfContent($file) {
		$pdf_reader = new \Smalot\PdfParser\Parser();
		$pdf = $pdf_reader->parseFile($file);
		return $pdf->getText();
	}

}