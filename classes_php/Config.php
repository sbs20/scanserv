<?php
class Config {
	const IsTrace = false;
	const TraceLineEnding = "<br>\n";
	const Scanimage  = "/opt/bin/scanimage";
	const Convert  = "/opt/bin/convert";
	const OutputFilter = "/opt/bin/convert 2>/dev/null  - -normalize -sharpen 0x1 ";
	const PreviewFilter = "/opt/bin/convert 2>/dev/null  - -trim -quality 30  ";
	const OutputExtention = "jpg";
	// const OutputExtention = "tif";

	const BypassSystemExecute = false;
	const OutputDirectory = "./output/";
	const PreviewDirectory = "./preview/";
	const MaximumScanWidthInMm = 215;
	const MaximumScanHeightInMm = 297;

	const DefaultResolution = 150;
	const DefaultMode = "Color";
	const DefaultBrightness = 0;
	const DefaultContrast = "0";
}
?>
