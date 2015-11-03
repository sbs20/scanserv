<?php
include("System.php");
include("Enumerations.php");

class ScanRequest {
	public $top = 0;
	public $left = 0;
	public $width = 215;
	public $height = 297;
	public $mode = "Color";
	public $depth = 8;
	public $resolution = 200;
	public $format = "tiff";
	public $outputFilepath = "";
	public $brightness = 0;
	public $contrast = 0;

	public function Validate() {
		$errors = array();

		if (!Mode::isValidValue($this->mode)) {
			array_push($errors, "Invalid mode: ".$this->mode);
		}

		if (!is_int($this->width)) {
			array_push($errors, "Invalid width: ".$this->width);
		}

		if (!is_int($this->height)) {
			array_push($errors, "Invalid height: ".$this->height);
		}

		if (!is_int($this->top)) {
			array_push($errors, "Invalid top: ".$this->top);
		}

		if (!is_int($this->left)) {
			array_push($errors, "Invalid left: ".$this->left);
		}

		if (!is_int($this->brightness)) {
			array_push($errors, "Invalid brightness: ".$this->brightness);
		}

		if (!is_int($this->contrast)) {
			array_push($errors, "Invalid contrast: ".$this->contrast);
		}

		if ($this->top + $this->height > Config::MaximumScanHeightInMm) {
			array_push($errors, "Top + height exceed maximum dimensions");
		}

		/////////// MORE HERE ///////////////

		/////////////////////////////////////
		return $errors;
	}
}
?>