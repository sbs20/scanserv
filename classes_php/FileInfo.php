<?php
class FileInfo {
	public $fullname;
	public $name;
	public $path;
	public $extension;
	public $lastModified;
	public $size;

	function FileInfo($fullname) {
        $this->fullname = $fullname;

        $bytes = filesize($this->fullname);
        if ($bytes >= 1000000000) { $bytes = number_format($bytes / 1000000000, 1) . ' GB'; }
        elseif ($bytes >= 1000000) { $bytes = number_format($bytes / 1000000, 1) . ' MB'; }
        elseif ($bytes >= 1000) { $bytes = number_format($bytes / 1000, 1) . ' KB'; }
        else { $bytes = $bytes . ' B'; }

        $info = pathinfo($this->fullname);
        $this->name = $info['basename'];
        $this->path = $info['dirname'];
        $this->extension = $info['extension'];
        $this->size = $bytes;
        $this->lastModified = date("Y-m-d @ H:i:s",filemtime($this->fullname));
        }

	public function Delete() {
        if(is_readable($this->fullname)) {
            return unlink($this->fullname);
        }

		return false;
	}
}
?>
