<?php
include("System.php");
include("Enumerations.php");
include_once("ScannerOptions.php");

class ScanRequest {
    public $device = "";
    public $format = "";
	public $outputFilepath = "";
    public $outputFilter = "";
    public $options = NULL;
    
    public function __construct() {
        $this->options = array();
    }
    
    public function Validate() {
		$errors = array();
        
        // Get options from device interface
        $scanner = ScannerOptions::get($this->device);
        $scannerOptions = $scanner["options"];
                
        foreach ($this->options as $key => $value) {
            // If option is not present in device interface or its default value marked "inactive", then remove it
            if (!array_key_exists($key, $scannerOptions) || $scannerOptions[$key]->defaultValue === "inactive") {
                unset($this->options[$key]);
            // Otherwise, validate the selected value
            } else if (!$scannerOptions[$key]->isValidValue($value)) {
                array_push($errors, "Invalid value for " . $key . ": " . $value);
            }
        }
        
        // Make sure device name is set to the correct interface
        $this->device = $scanner["name"];
        
        return $errors;
    }
}
?>
