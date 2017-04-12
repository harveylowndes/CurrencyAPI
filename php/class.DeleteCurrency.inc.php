<?php

	/**
	* 	Delete Currency
	* 
	*	Contains all the code for the Delete Currency class.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	require('class.Action.inc.php');

	/**
	* 	Delete Currency Action Object Class
	* 
	*	An Action sub-class to remove an exisiting element 
	*	from the XML file.
	* 
	* 	@package  php
	*/
	class DeleteCurrency extends Action {

		/**
        *   The DELETE Method Object containing the URI encoded query string parameter values.
        *   @access  private
        *   @var DeleteObject
        */
		private $deleteObject;

		/**
		* 	Constructor
		* 	
    	*   Constructor for the DeleteCurrency object.
    	* 
    	*	@param MethodObject $delete_object
    	*/
		public function __construct($delete_object) {
			$this->deleteObject = $delete_object;
		}

		/**
		*	The processing logic.
		* 
		* 	Deletes the currency from the XML.
    	*/
		public function process() {
			global $rates_xml;
			$rates_xml->deleteCurrency($this->deleteObject->getCurrency()->getCode());
		}

		/**
		*	Get Message
		*  
    	*  	The returned message.
    	* 
    	* 	@throws  APIException if unable to replace template variables.
    	* 
    	*	@return string
    	*/
		public function getMessage() {
			global $request;
			global $output_format;
			try {
				//NOT VERY EFFICIENT BUT FOR EASE OF CHANGE
				$message = constant(strtoupper($output_format->getFormat()) . '_DELETE_RESPONSE_TEMPLATE');
				$message = str_replace("{{request}}", $request->method, $message);
				$message = str_replace("{{timestamp}}", $request->timestamp, $message);
				$message = str_replace("{{code}}", $this->deleteObject->getCurrency()->getCode(), $message);
			} catch(Exception $e) {
				throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
			}
			return $message;
		}

	}

?>