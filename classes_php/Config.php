<?php
class Config {
	const IsTrace = false;
	const TraceLineEnding = "<br>\n";
	const Scanimage  = "/usr/bin/scanimage";
	const Convert  = "/usr/bin/convert";
	const OutputFilter = "/usr/bin/convert tiff:- -normalize -sharpen 0x1 jpeg:-";
	const BypassSystemExecute = false;
	const OutputDirectory = "./output/";
	const PreviewDirectory = "./preview/";
	const MaximumScanWidthInMm = 215;
	const MaximumScanHeightInMm = 297;
}
?>
