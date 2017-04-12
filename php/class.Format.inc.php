<?php 

	/**
	* 	Format
	* 
	*	Contains all the code for the Format class.
	* 	This file also sets the default response format
	*  	and checks if the format parameter has been set.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	/**
	* 	Format Object Class
	* 
	*	An object class to manage the response format.
	* 
	* 	@package  php
	*/
	class Format {

		/**
        *   The response format.
        *   @access  private
        *   @var string
        */
		private $format;

		/**
        *   The singleton instance of the Format object.
        *   @access  private
        *   @var Format
        */
		private static $instance;

		/**
		* 	Constructor
		* 
    	*   Constructor for the Format object.
    	* 
    	*	@param string $format
    	*/
		public function __construct($format) {
			$this->setFormat($format);
		}

		/**
		* 	Get Instance
		* 
    	*  	Returns the set Format object instance.
    	*	Used to support the singleton pattern so
    	*	only one instance can be set.
    	* 
    	*	@param string $format
    	*	@return Format
    	*/
		public static function getInstance($format) {
			if (null === static::$instance) {
            	static::$instance = new Format($format);
        	}
        	return static::$instance;
		}

		/**
		*	Get Format
		*  
    	*   Returns the messaging format.
    	* 
    	*	@return string
    	*/
		public function getFormat() {
			return $this->format;
		}

		/**
		*	Set Format 
		* 
    	*   Sets the messaging format.
    	* 
    	*	@param string $format
    	*/
		public function setFormat($format) {
			if($this->isValidFormat(strtolower($format))) {
				$this->format = $format;
			}
		}

		/**
		*	Is Valid Format 
		* 
    	*   Checks the validity of a format.
    	* 
    	*	@param string $format
    	*	@return bool
    	*/
		private function isValidFormat($format) {
			global $VALID_MESSAGE_FORMATS;
			if(in_array($format, $VALID_MESSAGE_FORMATS)) {
				return true;
			} else {
				throw new APIException(ERROR_TITLE, ERROR_3000_MESSAGE, ERROR_3000);
			}
		}

	}

	/*
	*	This is at the end of the file to keep it all together.
	*/

	//Set first incase of error changing the format.
	$output_format = Format::getInstance(DEFAULT_MESSAGE_FORMAT);

	//Check if format is set in query string.
	if(isset($_INPUT[FORMAT])) { 
		$output_format->setFormat($_INPUT[FORMAT]); 
	} elseif(isset($_GET[FORMAT])) {
		$output_format->setFormat($_GET[FORMAT]); 
	}

?>