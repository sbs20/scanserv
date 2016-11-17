<?php
class Config {
	const IsTrace = false;
	const TraceLineEnding = "<br>\n";
	const Scanimage  = "/opt/bin/scanimage";
	const Convert  = "/opt/bin/convert";

	const OutputFilter = "/opt/bin/convert tiff:- -normalize -sharpen 0x1 jpeg:-";
	const OutputExtention = "jpg";
	// const OutputFilter = "/bin/cat";
	// const OutputExtention = "tif";

	const BypassSystemExecute = false;
	const OutputDirectory = "./output/";
	const PreviewDirectory = "./preview/";
	const MaximumScanWidthInMm = 215;
	const MaximumScanHeightInMm = 297;
}
?>
