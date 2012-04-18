<?php
/**
 * Provides a wrapper class to handle logging operations.
 * @author tungtt
 */
class LogWriter
{
	/**
	 * Path to target log file.
	 * @var string
	 */
	private $_filePath;
	
	/**
	 * File handler.
	 */
	private $_fileHandler;
	
	/**
	 * Defines path of a file to use.
	 * @param string $filePath Path to target log file
	 */
	function __construct($filePath)
	{
		if (empty($filePath))
			die('No path is provided!');
		$this->_filePath = $filePath;
	}
	
	/**
	 * Frees resource.
	 */
	function __destruct()
	{
		if ($this->_fileHandler)
		{
			//fclose($this->fileHandler);
			$this->_fileHandler = null;
		}
	}
	
	/**
	 * Writes a log message to target file. The function returns true if message was written successfully.
	 * It returns false when failed to open file or cannot place an exclusive lock on file.
	 * @param string $message A message to be written
	 * @return true|false
	 */
	public function log($message)
	{
		if (!$this->_fileHandler)
			$this->_fileHandler = fopen($this->_filePath, 'a');
		
		if (!$this->_fileHandler)
			return false;
			
		// Place an exclusive lock on target file.
		if (flock($this->_fileHandler, LOCK_EX))
		{
			fwrite($this->_fileHandler, date('c') . ' - ' . $message . PHP_EOL);
			// Release the lock.
			flock($this->_fileHandler, LOCK_UN);
		}
		else
			return false;
			
		fclose($this->_fileHandler);
		return true;
	}
}
