<?php

/**
 * tLangFilesControl
 */
class tLangFilesControl {

	/**
	 * Default Directory Name
	 * @var string $dirName
	 */
	private $dirName;

	/**
	 * Files list
	 * Using by files() method
	 * @var array $files
	 */
	private $files = array();

	/**
	 * Language files content
	 * @var array $filesContent
	 */
	private $filesContent = array();

	/**
	 * loadFilesContent()
	 * This method reads language files.
	 * @param string $dirName
	 * @return array $filesContent
	 */
	public function loadFilesContent ($dirName) {
		


		# Set @var dirName = @param dirName
		$this->dirName = $dirName;

		# Default dir files list
		$filesList = $this->files();

			# Count array $files elements
			$countFiles = count($this->files);

			for($i = 1; $i <= $countFiles; $i++) {

				# $i - 1
				$b = $i - 1;	

				# File path
				$path = $this->dirName .'/'. $this->files[$b];

				# Require file
				$fileContent = require($path);

				array_push($this->filesContent, $fileContent);

			}

			return $this->filesContent;


	}

	/**
	 * Files method
	 * Checks the directory
	 * Lists files, checks extensions and push array $files
	 * @return array $filesList
	 */
	private function files () {

		# File exists
		if(!file_exists($this->dirName))
			throw new tLangException('id', $this->dirName);


		# Is it directroy?
		if(!is_dir($this->dirName))
			throw new tLangException('nd', $this->dirName);


		# Order the files names in dir
		$dir = opendir($this->dirName);

			# Listing files
			while($file = readdir($dir)) {

				# File extensinon
				$extension = pathinfo($this->dirName . $file, PATHINFO_EXTENSION);
				
				# Read only .php exte+nsions
				if($extension === 'php')
					array_push($this->files, $file);

			}

		return $this->files;
		
	}

}
