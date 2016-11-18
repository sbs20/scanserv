<?php
include("IScanner.php");
include("ScanResponse.php");

class Scanimage implements IScanner {
	private function CommandLine($scanRequest) {
		$cmd = Config::Scanimage;
		$cmd = $cmd." --mode ".$scanRequest->mode;
		$cmd = $cmd." --depth ".$scanRequest->depth;
		$cmd = $cmd." --resolution ".$scanRequest->resolution;
		$cmd = $cmd." -l ".$scanRequest->left;
		$cmd = $cmd." -t ".$scanRequest->top;
		$cmd = $cmd." -x ".$scanRequest->width;
		$cmd = $cmd." -y ".$scanRequest->height;
		$cmd = $cmd." --format ".$scanRequest->format;
		$cmd = $cmd." --brightness ".$scanRequest->brightness;
		$cmd = $cmd." --contrast ".$scanRequest->contrast;

		// Last
		if ( empty($scanRequest->outputFilter ))
			$cmd = $cmd.' >"'.$scanRequest->outputFilepath.'"';
		else
			$cmd = $cmd.' |'. $scanRequest->outputFilter.' "'.$scanRequest->outputFilepath.'"';
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
