<?php
class Config {
	const IsTrace = false;
	const TraceLineEnding = "<br>\n";

	// You may need to update the paths to scanimage and convert according to 
	// your installation.
	const Scanimage  = "/opt/bin/scanimage";
	const Convert  = "/opt/bin/convert";
	const PreviewFilter = "/opt/bin/convert 2>/dev/null  - -trim -quality 30  ";

	// Use an empty filter by default. The spirit of the default implementation
	// is to create non-lossy scans with no post processing. Should you wish to 
	// override this behaviour then change the filter which will have the scanimage
	// output piped to it.
	const OutputFilter = "";
	//const OutputFilter = "/opt/bin/convert 2>/dev/null  - -normalize -sharpen 0x1 ";

	// As with the output filter, the default implementation prefers non-lossy
	// output. Should you wish you override this then you can change the output 
	// type below
	const OutputExtension = "tif";
	// const OutputExtension = "jpg";

	// Only useful for development debugging
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
