<?php
// Enable buffering
ob_start();

include("classes/Scanimage.php");
include("classes/ScanRequest.php");
include("classes/FileInfo.php");

// Write ajax header
//Content-Type: application/json; charset=utf-8

header('Content-Type: application/json');
date_default_timezone_set('Europe/London');

class Api {
	public static function HandleCmdlineRequest($request) {
		$cmd = $request->data;
		System::Execute($cmd, $output, $ret);
		return array("cmd" => $cmd, "output" => $output, "ret" => $ret);
	}

	public static function HandlePreviewRequest($request) {
		$scanRequest = new ScanRequest();
		$scanRequest->outputFilepath = Config::PreviewDirectory."preview.tif";
		$scanRequest->resolution = 50;
		$scanner = new Scanimage();
		$scanResponse = $scanner->Execute($scanRequest);	
		return $scanResponse;
	}

	public static function HandlePreviewToJpegRequest() {
		$cmd = Config::Convert." ".Config::PreviewDirectory."preview.tif ".Config::PreviewDirectory."preview.jpg";
		System::Execute($cmd, $output, $ret);
		return array("cmd" => $cmd, "output" => $output, "ret" => $ret);
	}

	public static function HandleScanRequest($request) {
		$clientRequest = $request->data;

		$scanRequest = new ScanRequest();

		if ($clientRequest->top) {
			$scanRequest->top = (int)$clientRequest->top;
		}

		if ($clientRequest->left) {
			$scanRequest->left = (int)$clientRequest->left;
		}

		if ($clientRequest->height) {
			$scanRequest->height = (int)$clientRequest->height;
		}

		if ($clientRequest->width) {
			$scanRequest->width = (int)$clientRequest->width;
		}

		if ($clientRequest->resolution) {
			$scanRequest->resolution = (int)$clientRequest->resolution;
		}

		if ($clientRequest->mode) {
			$scanRequest->mode = $clientRequest->mode;
		}

		if ($clientRequest->brightness) {
			$scanRequest->brightness = (int)$clientRequest->brightness;
		}

		if ($clientRequest->contrast) {
			$scanRequest->contrast = (int)$clientRequest->contrast;
		}

		$outputfile = Config::OutputDirectory."Scan_".date("Y-m-d H.i.s",time()).".tif";
		$scanRequest->outputFilepath = $outputfile;
		$scanner = new Scanimage();
		$scanResponse = $scanner->Execute($scanRequest);
	
		return $scanResponse;
	}

	public static function HandleFileListRequest() {
		$files = array();
		$outdir = System::OutputDirectory();

		foreach (new DirectoryIterator($outdir) as $fileinfo) {
			if(!is_dir($outdir.$fileinfo) && $fileinfo->getExtension() === "tif") {    
				$files[$fileinfo->getMTime()] = $fileinfo->getFilename();
			}
		}

		krsort($files);
		$dirArray = array_values($files);

		$files = array();

		foreach ($dirArray as $filepath) {
			array_push($files, new FileInfo($outdir.$filepath));
		}

		return $files;
	}

	public static function HandleFileDeleteRequest($request) {
		$fileInfo = new FileInfo($request->data);
		return $fileInfo->Delete();
	}

	public static function Main() {
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			$input = file_get_contents('php://input');
			$request = json_decode($input);

			$responseType = $request->type;
				
			switch ($request->type) {
				case "scan":
					$responseData = self::HandleScanRequest($request);
					break;

				case "preview":
					$responseData = self::HandlePreviewRequest($request);
					break;

				case "fileList":
					$responseData = self::HandleFileListRequest();
					break;

				case "fileDelete":
					$responseData = self::HandleFileDeleteRequest($request);
					break;

				case "previewToJpeg":
					$responseData = self::HandlePreviewToJpegRequest();
					break;

				case "cmdline":
					$responseData = self::HandleCmdlineRequest($request);
					break;

				default:
					$responseType = "unknown";
					$responseData = null;
					break;
			};
		
			$response = array(
				"type" => $responseType,
				"data" => $responseData
			);

			echo json_encode($response);
		
		} else {
			echo "GET METHOD NOT SUPPORTED";
		}
	}
}

Api::Main();
?>