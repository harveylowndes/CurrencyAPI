<?php

	/**
	*	Request
	* 
	*	Contains all the code for the Request class.
	* 
	*	@package  php
	*	@author  Harvey Lowndes
	*/

	/**
	*	Request Object Class 
	* 
	*	An object class used to store the details of a request.
	*	The process function retrieves the correct file needed
	*	to further process the request. 
	* 
	*	@package  php
	*/
	class Request {

		/**
        *	The request method name.
        *	@access  private
        *	@var string
        */
		private $method;

		/**
        *	The time of the request.
        *	@access  private
        *	@var DateTime
        */
		private $timestamp;

		/**
        *	The singleton instance of the Request object.
        *	@access  private
        *	@var Request
        */
		private static $instance;

		/**
		*	Constructor
		* 
		*	Constructor for the Request object.
		* 
		*	@param string $method
		*/
		public function __construct($method) {
			$this->method = $method;
			$this->timestamp = date(TIMESTAMP_FORMAT);
		}

		/**
		*	Get Instance
		* 
		*	Sets instance of class if it has not been created. 
		*	If it has been created the instance is returned.
		* 
		*	@param string $method
		*	@return Request
		*/
		public static function getInstance($method) {
			if (null === static::$instance) {
            	static::$instance = new Request($method);
        	}
        	return static::$instance;
		}

		/**
		*	__get 
		* 
		*	Returns private variable in Request object.
		* 
		*	@param string $name
		*	@return mixed
		*/
		public function __get($name) {
			return $this->$name;
		}

		/**
		*	Get Timestamp
		* 
		*	Returns timestamp.
		* 
		*	@return  DateTime
		*/
		public function getTimestamp() {
			return $this->timestamp;
		}

		/**
		*	The processing logic. 
		* 
		*	Processes the object to retrieve required file.
		*/
		public function process() {
			require INDEX_FILE . strtolower($this->method) . ".php";
		}

	}

?>