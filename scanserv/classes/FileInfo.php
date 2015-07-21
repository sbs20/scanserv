<?php
class FileInfo {
	public $fullname;
	public $name;
	public $path;
	public $extension;
	public $lastModified = null;
	public $size = 0;

	function FileInfo($fullname) {
		$this->fullname = $fullname;

		$info = pathinfo($this->fullname);
		$this->name = $info['basename'];
		$this->path = $info['dirname'];
		$this->extension = $info['extension'];
		$this->size = filesize($this->fullname);
		$this->lastModified = filemtime($this->fullname);
	}

	public function Delete() {
        if(is_readable($this->fullname)) {
          return unlink($this->fullname);
        }

		return false;
	}
}
?>