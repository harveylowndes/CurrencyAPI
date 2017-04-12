<?php

	/**
	*	Reponse
	*  
	*	Contains all the code for the Response object.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	/**
	*	Reponse Object Class
	*  
	*	An object class to manage the response. Sets the header 
	*	and returns the message in the _toString.
	* 
	* 	@package  php
	*/
	class Response {

		/**
        *   The response message.
        *   @access  protected
        *   @var String
        */
		protected $message = "";

		/**
			Constructor
		 
		 	Constructor for the Response object.
		 
		 	@param string $message
		*/
		public function __construct($message) {
			$this->message = $message;
		}

		/**
		 	__get
		 
			Returns private variable in Response object.
		 
		 	@access  public
		 	@param string $name
		   	@return mixed
		*/
		public function __get($name) {
			return $this->$name;
		}

		/**
		* 	__toString
		* 
		*	Overrides default __toString().
		* 
		*   @return string
		*/
		public function __toString() {
			global $output_format;
	    	header(constant(strtoupper($output_format->getFormat()) . "_MESSAGE_CONTENT_TYPE"));
	    	return $this->message;
		}
	}

?>