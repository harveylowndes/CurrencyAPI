<?php

	/**
	*	Rates XML File Handler Object Class
	* 
	*	Contains all the code for the Rates XML File Handler Class.
	* 	This file also sets the object instance to the configured XML.
	* 
	* 	@package  php
	* 	@author  Harvey Lowndes
	*/

	require('class.XMLFileLoader.inc.php');
	require('class.Currency.inc.php');

	/**
	*	Rates XML File Handler Object Class
	* 
	*	An XMLFileLoader sub-class to manage the rates XML file.
	*	Contains commonly used methods and functions. Uses the
	*	singleton pattern so only 1 instance of the object is used.
	* 
	* 	@package  php
	*/
	class RatesXMLFileHandler extends XMLFileLoader {

      	/**
        *   The singleton instance of the RatesXMLFileHandler object.
        *   @access  private
        *   @var RatesXMLFileHandler
        */
		private static $instance;

		/**
		* 	Constructor
		* 
    	*   Constructor for the RatesXMLFileHandler object.
    	* 
    	*	@param string $xml_file
    	*/
		public function __construct($xml_file) {
			parent::__construct($xml_file);
		}

		/**
		*	Validate XML
		*  	
		*	Validates the XML against its assigned XSD schema.
		* 
		*	@return bool
		*/
		public function validateXML() {
			if(!$this->xml->schemaValidate(RATES_XSD)) {
				return false;
			} else {
				return true;
			}
		}

		/**
		* 	Get Instance
		* 
    	*   Gets the set RatesXMLFileHandler object instance.
    	*	Used to support the singleton pattern so
    	*	only one instance can be set.
    	* 
    	*	@param string $xml_file
    	*	@return RatesXMLFileHandler
    	*/
		public static function getInstance($xml_file) {
			if (null === static::$instance) {
            	static::$instance = new RatesXMLFileHandler($xml_file);
        	}
        	return static::$instance;
		}

		/**
		* 	Code Exists
		* 
    	*   Checks if a code/currency exists in the XML
    	*	document.
    	* 
    	* 	@throws  APIException if there is an error checking the code against the XML file.
    	* 
    	*	@param string $code
    	*	@return bool
    	*/
		public function codeExists($code) {
			try {
				$codeExists = $this->xpath->evaluate(CURRENCY_ELEMENT_PATH . '[@' . CODE_ATTRIBUTE . '="'. $code . '"]');
				if($codeExists->length > 0) { //If returns a value
					return true;
				} else {
					return false;
				}
			} catch(Exception $e) {
				//Possible in two different templates.
				if($method == 'GET') {
					throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
				} else {
					throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
				}
			}
		}

		/**
		* 	Get Object By Code
		* 
    	*   Creates and returns a currency object.
    	* 
    	*	@param string $code
    	*	@return Currency
    	*/
		public function getObjectByCode($code) {
			try {
				//Get the element by code.
				$object = $this->xpath->query(CURRENCY_ELEMENT_PATH . '[@' . CODE_ATTRIBUTE . '="'. $code . '"]');
				$locations = array();
				foreach($object as $o){
					$rate = $o->getAttribute(RATE_ATTRIBUTE);
					$code = $o->getAttribute(CODE_ATTRIBUTE);
					$name = $o->getAttribute(NAME_ATTRIBUTE);
					//Continue xpath here.
					foreach ($this->xpath->query(CURRENCY_ELEMENT_PATH . '[@' . CODE_ATTRIBUTE . '="'. $code . '"]/' . LOCATION_NODE .'', $o) as $c) {
						array_push($locations, $c->nodeValue);
					}
					break; //Only 1 result will be found so we can exit out the loop.
				}
			} catch(Exception $e) {
				global $method;
				if($method == 'GET') {
					throw new APIException(ERROR_TITLE, ERROR_1400_MESSAGE, ERROR_1400);
				} else {
					throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
				}
			}
			return new Currency($code, $name, $rate, $locations); //Create and return the currency object.
		}

		/**
		*	Delete Currency
		*  
    	*   Deletes a currency in the XML document.
    	* 
    	*	@param string $code
    	*/
		public function deleteCurrency($code) {
			try {
				//Find the element by the code, remove it, save the xml.
				$object = $this->xpath->query(CURRENCY_ELEMENT_PATH . '[@' . CODE_ATTRIBUTE . '="'. $code . '"]');
				$object->item(0)->parentNode->removeChild($object->item(0));
				$this->xml->save(RATES_XML);
			} catch(Exception $e) {
				throw new APIException(ERROR_TITLE, ERROR_2100_MESSAGE, ERROR_2100);
			}
		}

	}
	
	$rates_xml = RatesXMLFileHandler::getInstance(RATES_XML); //Declaring as soon as its called as will be used early on in code.
?>