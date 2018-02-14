<?php
include("IScanner.php");
include("ScanResponse.php");
include_once("ScannerOptions.php");

class Scanimage implements IScanner {
	private function CommandLine($scanRequest) {
        $cmd = Config::Scanimage;
        $cmd .= " --format='" . Config::OutputExtension . "'";
        
        // Set device
        if (isset($scanRequest->device)) $cmd .= " --device-name='" . $scanRequest->device . "'";
        // Set device-specific options
        $scanner = ScannerOptions::get($scanRequest->device);
        $scannerOptions = $scanner["options"];
		foreach ($scanRequest->options as $key => $value) {
            $cmd .= " " . $scannerOptions[$key]->name . " '" . $value . "'";
        }
        
        // Make PDF a bit lighter
        $cmd2 = Config::OutputFilter;
        if ($scanRequest->format == Format::PDF) $cmd2 .= " -compress JPEG ";
        
		// No output filter or default output format which is handled by scanimage directly
		if (empty(Config::OutputFilter) || $scanRequest->format == Config::OutputExtension)
			$cmd = $cmd . ' > "' . $scanRequest->outputFilepath . '"';
		else
			$cmd = $cmd . ' | ' . $cmd2 . ' "' . $scanRequest->outputFilepath . '"';

		return $cmd;
	}

	public function Execute($scanRequest) {
		$scanResponse = new ScanResponse();
		$scanResponse->errors = $scanRequest->Validate();
		if (count($scanResponse->errors) == 0) {
			$scanResponse->cmdline = $this->CommandLine($scanRequest);
			System::Execute($scanResponse->cmdline, $scanResponse->output, $scanResponse->returnCode);
			$scanResponse->image = $scanRequest->outputFilepath;
		}

		return $scanResponse;
	}
}
?>
